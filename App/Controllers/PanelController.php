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
    # Define items per page for pagination
    private $perPage = 10;

    /**
     * Display the user's dashboard with their URLs in a paginated format.
     * 
     * @param Request $request  The incoming HTTP request containing user data, parameters, etc.
     */
    public function index(Request $request)
    {
        try {
            # Check if the user is logged in by verifying their cookie.
            $cookie = Auth::checkLogin();
            
            if ($cookie) {
                # Retrieve the user's data based on their email from the cookie.
                $user = User::where('email', $cookie)->first();

                # If user data does not exist, throw an exception with an error message.
                if (!$user) {
                    throw new Exception(Lang::get('Er-UserNotFound'));
                }

                # Retrieve pagination data for URLs associated with the user.
                $pagination = $this->paginate($request, $user->id);

                # Package the data to pass into the view.
                $data = (object)[
                    'userName' => $user->email,
                    'urls' => $pagination->items,
                    'page' => $pagination->page,
                    'totalPage' => $pagination->totalPage,
                    'startPaginate' => $pagination->startPaginate
                ];

                # Render the user's dashboard view with their data.
                view('panel.index', $data);
            } else {
                # If the user is not logged in, redirect to the login page with an error message.
                throw new Exception(Lang::get('Er-TryLogin'));
            }
        } catch (Exception $e) {
            # Handle any exceptions and redirect to the auth page with an error message.
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './auth');
        }
    }

    /**
     * Display or process the URL editing form.
     * 
     * @param Request $request  The HTTP request containing the URL ID and edit data.
     */
    public function edit(Request $request)
    {
        try {
            # Get the URL ID from the request parameters.
            $urlId = $request->param('url_id');

            # Retrieve the URL details based on the given ID.
            $infoUrl = Url::find($urlId);

            # Ensure the URL exists and the user is authorized to edit it.
            if ($infoUrl && $this->isUserAuthorized($infoUrl->user->email)) {
                if ($request->method() === 'get') {
                    # Display the URL edit form with the current URL information.
                    $data = (object)['url' => $infoUrl];
                    view('panel.editUrl', $data);
                } elseif ($request->method() === 'post') {
                    # Process the submitted URL edit form.
                    $this->processUrlEdit($request, $urlId);
                }
            } else {
                # If the URL does not exist or the user is unauthorized, throw an exception.
                throw new Exception(Lang::get('Er-Unauthorized'));
            }
        } catch (Exception $e) {
            # Handle exceptions and redirect back to the panel with an error message.
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './panel');
        }
    }

    /**
     * Delete a URL if the logged-in user is authorized.
     * 
     * @param Request $request  The request containing the URL ID to delete.
     */
    public function delete(Request $request)
    {
        try {
            # Get the URL ID from the request.
            $urlId = $request->param('url_id');

            # Find the URL entry based on the given ID.
            $url = Url::find($urlId);

            # Check if the URL exists and if the logged-in user is the creator.
            if ($url && $this->isUserAuthorized($url->user->email)) {
                # Delete the URL entry from the database.
                $deleteUrl = Url::where('id', $urlId)->delete();

                #Delete the associated QR code image file from the system.
                $deleteQrCode = unlink(BASEPATH . 'public/QrCode/' . $url->shortUrl . '.png');

                # Confirm the deletion of both the URL entry and the QR code image.
                if ($deleteUrl && $deleteQrCode) {
                    // Redirect back to the panel with a success message.
                    ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-DeleteSuccess'), './panel');
                } else {
                    # If deletion fails, throw an exception with an error message.
                    throw new Exception(Lang::get('Er-TryAgin'));
                }
            } else {
                # If the URL doesn't exist or the user is unauthorized, throw an exception.
                throw new Exception(Lang::get('Er-Unauthorized'));
            }
        } catch (Exception $e) {
            # Handle exceptions and redirect back to the panel with an error message.
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './panel');
        }
    }

    /**
     * Handle user logout by deleting the authentication cookie and redirecting to the home page.
     */
    public function logout()
    {
        # Delete the authentication cookie to log out the user.
        Cookie::deleteCookie('Auth');

        # Redirect to the home page with a logout success message.
        ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-LogOut'), '../');
    }

    /**
     * Paginate the user's URLs for display on the dashboard.
     * 
     * @param Request $request  The incoming HTTP request containing pagination parameters.
     * @param int $userId       The user's ID to filter URLs.
     * @return object           Pagination data including items and pagination details.
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
     * Check if the currently logged-in user is the owner of the URL.
     * 
     * @param string $email  The email of the user who created the URL.
     * @return bool          True if authorized, false otherwise.
     */
    private function isUserAuthorized(string $email): bool
    {
        # Verify if the email of the logged-in user matches the provided email.
        return Auth::checkLogin() === $email;
    }

    /**
     * Process the URL edit form submission (POST request).
     * 
     * @param Request $request  The HTTP request containing the updated URL data.
     * @param int $urlId        The ID of the URL to be updated.
     */
    private function processUrlEdit(Request $request, int $urlId)
    {
        # Get the new URL from the request.
        $editURL = $request->param('editURL');

        # Validate the new URL format.
        if (validateUrl($editURL)) {
            # Update the URL in the database.
            Url::where('id', $urlId)->update([
                'url' => htmlspecialchars($editURL)
            ]);

            # Redirect back to the panel with a success message.
            ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-EditSuccess'), './panel');
        } else {
            # If validation fails, redirect back to the edit form with an error message.
            ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgin'), "./panel/edit/$urlId");
        }
    }
}
