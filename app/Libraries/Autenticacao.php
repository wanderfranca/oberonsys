<?php 

namespace App\Libraries;

class Autenticacao {

    private $usuario;
    private $usuarioModel;
    private $grupoUsuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
        $this->grupoUsuarioModel = new \App\Models\GrupoUsuarioModel();
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

    // Método: Logout
    public function logout(): void
    {
        session()->destroy();
    }

    // Método: Pegar o usuário logado
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

    // --------------------------- Métodos privados ------------

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

        
        $usuario = $this->definePermissoesDoUsuarioLogado($usuario);

        return $usuario;
    }

    // Método: Verificar se o usuário logado é um administrador
    private function isAdmin(): bool
    {
        $grupoAdmin = 1;

        $administrador = $this->grupoUsuarioModel->usuarioEstaNoGrupo($grupoAdmin, session()->get('usuario_id'));

        if ($administrador == null) {
            
            return false;
        }

        return true;
        

    }

    // Método: Verificar se o usuário logado é um cliente
    private function isCliente(): bool
    {
        $grupoCliente = 2;

        $cliente = $this->grupoUsuarioModel->usuarioEstaNoGrupo($grupoCliente, session()->get('usuario_id'));

        if ($cliente == null) {
            
            return false;
        }

        return true;
        

    }

    // Método: Define as permissões que o usuário logado possui
    private function definePermissoesDoUsuarioLogado($usuario) : object
    {

        // usado em termPermissaoPara() na Entity Usuario
        $usuario->is_admin = $this->isAdmin();

        if($usuario->is_admin == true)
        {
            $usuario->is_cliente = false;
        
        } else 
        {
            $usuario->is_cliente = $this->isCliente();    
        }

        //Verificação: Recupera permissões dos usuários que não são admin ou cliente 
        if($usuario->is_admin == false && $usuario->is_cliente == false)
        {

            $usuario->permissoes = $this->recuperaPermissoesDoUsuarioLogado();

        }

        return $usuario;

    }

    // Método: Recupera permissões do usuário logado
    private function recuperaPermissoesDoUsuarioLogado() : array
    {
        $permissoesDoUsuario = $this->usuarioModel->recuperaPermissoesDoUsuarioLogado(session()->get('usuario_id'));
        return array_column($permissoesDoUsuario, 'permissao');
    }

}