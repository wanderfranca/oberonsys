<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function novo()
    {
        $data = [

            'titulo' => 'Login',
        ];

        return view('Login/novo', $data);
    }
}
