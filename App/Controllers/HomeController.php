<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use App\Utilities\Auth;

class HomeController
{
    // private $request = new Request();

    public function index()
    {
        return view('home.index');
    }

    public function createUrl(Request $request)
    {

        if ($request->method() === 'post' && isset($request->params()['sub-create']) && !empty($request->params()['Url'])) {
            $users = User::all();
            $authUser = Auth::chackLogin();
            // if (isset($_COOKIE[''])){}
        }
    }

    public function redirectUrl(Request $request){
        echo "<pre>";
        var_dump($request);
    }
}
