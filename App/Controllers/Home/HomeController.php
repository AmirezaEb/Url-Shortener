<?php

namespace App\Controllers\Home;

use App\Core\Request;

class HomeController
{
    // private $request = new Request();

    public function index()
    {
        view('home.index');
    }

    public function createUrl(Request $request)
    {
        if($request->method() === 'post' && isset($request->params()['sub-create']) && !empty($request->params()['Url'])){
            
        }
    }
}
