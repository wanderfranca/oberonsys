<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Password extends BaseController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }


    public function esqueci()
    {
        $data = [
            'titulo' => 'Esqueci a minha senha',
        ];
        

        return view('Password/esqueci', $data);
    
    }

    public function processaEsqueci()
    {
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição
        $email = $this->request->getPost('email');

        $usuario = $this->usuarioModel->buscaUsuarioPorEmail($email);

        if($usuario === null || $usuario->ativo === false)
        {

            $retorno['erro'] = 'Não foi possível encontrar uma conta válida com o e-mail informado';
            return $this->response->setJSON($retorno);

        }

        $usuario->iniciaPasswordReset();

        $this->usuarioModel->save($usuario);


        $this->enviaEmailRedefinicaoSenha($usuario);

        return $this->response->setJSON([]);

    }

    public function resetEnviado()
    {

        $data = [
            'titulo' => 'E-mail de recuperação enviado',
            'msg' => 'Enviamos um link para redefinição de senha, verifique sua caixa de entrada (ou spam)',
            
        ];
        

        return view('Password/reset_enviado', $data);

    }

    // Método que verifica o token e faz o reset da senha
    public function reset($token = null)
    {

        if($token == null)
        {
            return redirect()->to(site_url("password/esqueci"))->with("atencao", "Link inválido ou expirado");
        }

        // Buscar o usuário na base de dados e comparar o hash do token q veio como parâmetro
        $usuario = $this->usuarioModel->buscaUsuarioParaRedefinirSenha($token);

        if($usuario === null)
        {
            return redirect()->to(site_url("password/esqueci"))->with("atencao", "Link inválido ou expirado");

        }

        $data = [
            'titulo' => 'Crie a sua nova senha',
            'token' => $token,
        ];

        return view('Password/reset', $data);


    }

    // Método: Envia e-mail para redefinição de senha para o usuário
    private function enviaEmailRedefinicaoSenha(object $usuario) : void
    {

        $email = service('email');

        $email->setFrom('no-replay@oberonsys.com', 'Oberon Sistema');
        
        $email->setTo($usuario->email);

        $email->setSubject('Redefinição de Senha');


        $data = [

                    'token' => $usuario->reset_token,
            
                ];

        $mensagem = view('Password/reset_email_2', $data);

        $email->setMessage($mensagem);

        $email->send();

    }
}
