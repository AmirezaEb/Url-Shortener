<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use App\Utilities\Auth;
use App\Utilities\ExceptionHandler;
use App\Utilities\Lang;

class PanelController
{
    public function index(Request $request)
    {
        $Cookie = Auth::chackLogin();
        if ($Cookie) {
            $user = User::where('email', $Cookie)->first();
            view('panel.index');
        } else {
            var_dump($Cookie);
            // ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryLogin'), './auth');
        }
    }
}
