<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use App\Utilities\Auth;

class HomeController
{
    public function index(): void
    {
        return view('home.index');
    }

    public function createUrl(Request $request): void
    {

        if ($request->method() === 'post' && isset($request->params()['sub-create']) && !empty($request->params()['Url'])) {
            $users = User::all();
            $authUser = Auth::chackLogin();
        }
    }

    public function redirectUrl(Request $request): void
    {
        # Code ...
    }
}
