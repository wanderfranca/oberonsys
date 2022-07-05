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

    public function criar()
    {
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

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
        session()->setFlashdata('sucesso', "Olá $usuarioLogado->nome !");

        if($usuarioLogado->is_cliente)
        {
            $retorno['redirect'] = 'Ordens/minhas';
            return $this->response->setJSON($retorno);
        }

            $retorno['redirect'] = 'home';
            return $this->response->setJSON($retorno);
        

    }
}
