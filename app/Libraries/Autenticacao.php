<?php 

namespace App\Libraries;

class Autenticacao {

    private $usuario;
    private $usuarioModel;

    public function __construc()
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }

    // Método: Login de usuário
    public function login(string $email, string $password): bool 
    {

        $usuario = $this->usuarioModel->buscaUsuarioPorEmail($email);

         //Verificação: Usuário
        if($usuario === null)
        {
            return false;
        }

        //Verificação: Senha
        if($usuario->verificaPassword($password) == false)
        {
            return false;
        }

        //Verificação: Status
        if($usuario->ativo == false)
        {
            return false;
        }
        
        // Logar na aplicação
        $this->logaUsuario($usuario);
        return true;

    }


    // Método: Criar a sessão do usuário
    private function logaUsuario(object $usuario): void
    {

        // Recuperar a instância da sessão
        $session = session();

        // Gerar um novo ID de sessão
        $session->regenerate();

        // Setar o ID do usuário na sessão
        $session->set('usuario_id', $usuario->id);

    }

}