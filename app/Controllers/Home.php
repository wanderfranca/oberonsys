<?php

namespace App\Controllers;

use App\Libraries\Autenticacao;

class Home extends BaseController
{
    public function index()
    {
        $data = [

            'titulo' => 'Início',
        ];

        return view('Home/index', $data);
    }


    public function login()
    {
        $autenticacao = new Autenticacao();

        // $autenticacao->login('1234@email.com', '123456');

        // $autenticacao->logout();
        // return redirect()->to(site_url('/'));

       dd($autenticacao->estaLogado());

    }


}
