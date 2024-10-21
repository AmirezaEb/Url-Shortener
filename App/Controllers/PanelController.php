<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\Url;
use App\Models\User;
use App\Utilities\Auth;
use App\Utilities\Cookie;
use App\Utilities\ExceptionHandler;
use App\Utilities\Lang;

class PanelController
{

    private $perPage = 10;

    public function index(Request $request)
    {
        $Cookie = Auth::chackLogin();
        if ($Cookie) {
            $user = User::where('email', $Cookie)->first();
            $pagination = $this->paginate($request, $user->id);
            $data = (object)[
                'userName' => $user->email,
                'urls' => $pagination->items,
                'page' => $pagination->page,
                'totalPage' => $pagination->totalPage,
                'startPaginate' => $pagination->startPaginate
            ];

            view('panel.index', $data);
        } else {
            ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryLogin'), './auth');
        }
    }

    public function edit(Request $request)
    {
        $urlId = $request->param('url_id');
        $infoUrl = Url::find($urlId);
        $creatorUrl = Url::find($urlId)->user;

        if (Auth::chackLogin() == $creatorUrl->email && $request->method() === 'get') {
            $data = (object)[
                'url' => $infoUrl
            ];

            view('panel.editUrl', $data);
        } elseif (Auth::chackLogin() == $creatorUrl->email && $request->method() === 'post') {
            if (filter_var($request->param('editURL'), FILTER_VALIDATE_URL) !== false) {

                $UpdateUrl = Url::where('id', $urlId)->update([
                    'url' => htmlspecialchars($request->param('editURL'))
                ]);

                ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-EditSuccess'), './panel');
            } else {
                ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgin'), './panel/edit/' . $urlId);
            }
        } else {
            ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgin'), './panel');
        }
    }

    public function delete(Request $request)
    {
        $urlId = $request->param('url_id');
        $creatorUrl = Url::find($urlId)->user;

        if (Auth::chackLogin() == $creatorUrl->email) {

            $deleteUrl = Url::where('id', $urlId)->delete();

            if ($deleteUrl) {
                ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-DeleteSuccess'), './panel');
            } else {
                ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgin'), './panel');
            }
        } else {
            ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgin'), './panel');
        }
    }

    public function logout()
    {
        Cookie::deleteCookie('Auth');
        ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-LogOut'), '../');
    }

    private function paginate(Request $request, int $userId)
    {
        if ($request->has('page') && $request->param('page') >= 1 && ctype_digit($request->param('page'))) {
            $currentPage = (int) $request->param('page');
        } else {
            $request->AddParams('page', 1);
            $currentPage = 1;
        }

        $totalItems = Url::where('created_by', $userId)->count();
        $totallPages = ceil($totalItems / $this->perPage);

        if ($totallPages < $currentPage) {
            $currentPage = $totallPages;
        }

        $startPaginate = ($currentPage - 1) * $this->perPage;

        $item = Url::where('created_by', $userId)->skip($startPaginate)->take($this->perPage)->get();

        return (object)[
            'page' => $currentPage,
            'items' => $item,
            'totalPage' => $totallPages,
            'startPaginate' => $startPaginate
        ];
    }
}
