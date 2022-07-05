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
        $autenticacao = service('autenticacao');

        $autenticacao->login('winston@suporteoberon.com.br', '123456');

        $usuario = $autenticacao->pegaUsuarioLogado();

        dd($usuario);

        // dd($autenticacao->pegaUsuarioLogado());
        // $autenticacao->logout();
        // return redirect()->to(site_url('/'));
        // dd($autenticacao->estaLogado());
        // dd($autenticacao->isCliente());

    }


}
