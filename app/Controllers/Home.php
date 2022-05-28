<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [

            'titulo' => 'Início',


        ];

        return view('Home/index', $data);
    }
}
