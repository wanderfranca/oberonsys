<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    // Método: Login e Autenticação de usuários na plataforma
    public function novo()
    {
        
        $data = [

            'titulo' => 'Login',
            // 'saudacao' => 'IMPLEMENTAR',
        ];

        return view('Login/novo', $data);
    }

    public function criar()
    {
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Pegar E-mail, Password e Endereço IP
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // $ip = $this->request->getIPAddress();

        // Serviço: instância autênticação
        $autenticacao = service('autenticacao');

        // Verificação: login inválido
        if($autenticacao->login($email, $password) === false)
        {
            $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['credenciais' => 'Login ou senha inválido'];
            return $this->response->setJSON($retorno);

        }

        $usuarioLogado = $autenticacao->pegaUsuarioLogado();
        session()->setFlashdata('bem-vindo', "Olá <strong>$usuarioLogado->nome</strong>!");

        if($usuarioLogado->is_cliente)
        {
            $retorno['redirect'] = 'ordens/minhas';
            return $this->response->setJSON($retorno);
        }

            $retorno['redirect'] = 'home';
            return $this->response->setJSON($retorno);    

    }

    public function logout()
    {
        $autenticacao = service('autenticacao');

        $usuarioLogado = $autenticacao->pegaUsuarioLogado();

        $autenticacao->logout();

        return redirect()->to(site_url("login"));


    }

    public function mostraMensagemLogout($nome = null)
    {
        return redirect()->to(site_url("login"))->with("msgLogout", "$nome. Muito obrigado, esperamos ver você novamente =D");
        
    }



}
