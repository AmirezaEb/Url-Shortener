<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\Url;
use App\Models\User;
use App\Utilities\Auth;
use App\Utilities\Cookie;
use App\Utilities\ExceptionHandler;
use App\Utilities\Lang;
use Exception;

class PanelController
{
    # Number of items per page for pagination
    private $perPage = 10;

    /**
     * Display the user's dashboard with paginated URLs
     * 
     * @param Request $request
     */
    public function index(Request $request)
    {
        try {
            $cookie = Auth::checkLogin(); # Check if the user is logged in via cookie
            if ($cookie) {
                # Fetch user data based on cookie
                $user = User::where('email', $cookie)->first();

                # If user exists, paginate URLs and prepare data for view
                if ($user) {
                    $pagination = $this->paginate($request, $user->id);
                    $data = (object)[
                        'userName' => $user->email,
                        'urls' => $pagination->items,
                        'page' => $pagination->page,
                        'totalPage' => $pagination->totalPage,
                        'startPaginate' => $pagination->startPaginate
                    ];

                    view('panel.index', $data); # Render the view with user data
                } else {
                    throw new Exception(Lang::get('Er-UserNotFound'));
                }
            } else {
                throw new Exception(Lang::get('Er-TryLogin'));
            }
        } catch (Exception $e) {
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './auth');
        }
    }

    /**
     * Handle URL editing (GET to show, POST to update)
     * 
     * @param Request $request
     */
    public function edit(Request $request)
    {
        try {
            $urlId = $request->param('url_id'); # Get the ID of the URL to edit
            $infoUrl = Url::find($urlId); # Fetch URL details

            # Ensure the URL exists before proceeding
            if ($infoUrl) {
                $creatorUrl = $infoUrl->user; # Fetch the user who created the URL

                # Check if logged-in user is the creator of the URL and handle request
                if ($this->isUserAuthorized($creatorUrl->email)) {
                    if ($request->method() === 'get') {
                        $data = (object)['url' => $infoUrl];
                        view('panel.editUrl', $data); # Show the edit URL page
                    } elseif ($request->method() === 'post') {
                        $this->processUrlEdit($request, $urlId);
                    }
                } else {
                    throw new Exception(Lang::get('Er-Unauthorized'));
                }
            } else {
                throw new Exception(Lang::get('Er-UrlNotFound'));
            }
        } catch (Exception $e) {
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './panel');
        }
    }

    /**
     * Handle URL deletion
     * 
     * @param Request $request
     */
    public function delete(Request $request)
    {
        try {
            $urlId = $request->param('url_id'); # Get the ID of the URL to delete
            $url = Url::find($urlId); # Fetch URL details

            # Check if URL exists and if the logged-in user is the creator
            if ($url && $this->isUserAuthorized($url->user->email)) {
                $deleteUrl = Url::where('id', $urlId)->delete(); # Delete the URL from the database

                if ($deleteUrl) {
                    ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-DeleteSuccess'), './panel');
                } else {
                    throw new Exception(Lang::get('Er-TryAgin'));
                }
            } else {
                throw new Exception(Lang::get('Er-Unauthorized'));
            }
        } catch (Exception $e) {
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './panel');
        }
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        Cookie::deleteCookie('Auth'); # Delete the authentication cookie
        ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-LogOut'), '../'); # Redirect to the home page
    }

    /**
     * Paginate the user's URLs
     * 
     * @param Request $request
     * @param int $userId
     * @return object
     */
    private function paginate(Request $request, int $userId)
    {
        # Validate or set default page number
        $currentPage = $request->has('page') && ctype_digit($request->param('page')) && $request->param('page') >= 1
            ? (int) $request->param('page')
            : 1;

        # Get the total number of URLs for the user
        $totalItems = Url::where('created_by', $userId)->count();
        $totalPages = (int) ceil($totalItems / $this->perPage);

        # Ensure the current page does not exceed the total number of pages
        $currentPage = min($currentPage, $totalPages);

        # Calculate the starting index for pagination
        $startPaginate = ($currentPage - 1) * $this->perPage;

        # Fetch the paginated URLs
        $items = Url::where('created_by', $userId)
            ->skip($startPaginate)
            ->take($this->perPage)
            ->get();

        # Return pagination data
        return (object)[
            'page' => $currentPage,
            'items' => $items,
            'totalPage' => $totalPages,
            'startPaginate' => $startPaginate
        ];
    }

    /**
     * Check if the logged-in user is authorized
     * 
     * @param string $email
     * @return bool
     */
    private function isUserAuthorized(string $email): bool
    {
        return Auth::checkLogin() === $email;
    }

    /**
     * Process the URL edit request (POST)
     * 
     * @param Request $request
     * @param int $urlId
     */
    private function processUrlEdit(Request $request, int $urlId)
    {
        # Validate the new URL format
        if (filter_var($request->param('editURL'), FILTER_VALIDATE_URL)) {
            # Update the URL in the database
            Url::where('id', $urlId)->update([
                'url' => htmlspecialchars($request->param('editURL'))
            ]);
            ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-EditSuccess'), './panel');
        } else {
            ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgin'), "./panel/edit/$urlId");
        }
    }
}
