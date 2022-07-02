<?php 

namespace App\Libraries;

class Autenticacao {

    private $usuario;
    private $usuarioModel;

    public function __construct()
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
            exit('Usuário não encontrado');
            return false;
        }

        //Verificação: Senha
        if($usuario->verificaPassword($password) == false)
        {
            exit('Senha Inválida');
            return false;
            
        }

        //Verificação: Status
        if($usuario->ativo == false)
        {
            exit('Usuário inativo');
            return false;
        }
        
        // Logar na aplicação
        $this->logaUsuario($usuario);
        return true;

    }

    // Método: Logout
    public function logout(): void
    {
        session()->destroy();
    }

    public function pegaUsuarioLogado()
    {
        if($this->usuario === null)
        {
            $this->usuario = $this->pegaUsuarioDaSessao();
        }

        return $this->usuario;
    }

    //Metodo: Verifica se o usuário está logado
    public function estaLogado() : bool
    {
        return $this->pegaUsuarioLogado() !== null;
    }


    // Método: Criar a sessão do usuário
    private function logaUsuario(object $usuario): void
    {

        // Recuperar a instância da sessão
        $session = session();

        // Gerar um novo ID de sessão
        $_SESSION['__ci_last_regenerate'] = time(); 

        // Setar o ID do usuário na sessão
        $session->set('usuario_id', $usuario->id);

    }

    // Método: Recuperar usuário da sessão e valida usuário logado
    private function pegaUsuarioDaSessao()
    {
        if(session()->has('usuario_id') == false)
        {
            return null;
        }

        $usuario = $this->usuarioModel->find(session()->get('usuario_id'));

        // Validação: Se o usuário existe e se tem permissão de login na aplicação
        if($usuario == null || $usuario->ativo == false)
        {
            return null;
        }

        return $usuario;
    }

}