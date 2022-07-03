<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        $data = [

            'titulo' => 'Login',
        ];

        return view('Login/index', $data);
    }
}
