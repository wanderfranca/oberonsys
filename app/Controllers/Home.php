<?php

namespace App\Controllers;

use App\Libraries\Autenticacao;

use App\Traits\ValidacoesTrait;

class Home extends BaseController
{
    use ValidacoesTrait;

    public function index()
    {
        
        $data = [

            'titulo' => 'Início',
        ];

        return view('Home/index', $data);
        // return view('Password/reset_email', $data);
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

    public function email()
    {
        $email = service('email');

        $email->setFrom('no-replay@oberonsys.com', 'Oberon Sistema');
        $email->setTo('ysqhwuex@knowledgemd.com');

        $email->setSubject('Recuperação de senha - Nova');
        $email->setMessage('Iniciando os testes na parte de recuperação de senha');

        if($email->send())
        {
            echo 'Email enviado';

        } else{

            echo $email->printDebugger();

        }
    }

    public function cep()
    {
        $cep = '83430000';

        return $this->response->setJSON($this->consultaViaCep($cep));

    }


}