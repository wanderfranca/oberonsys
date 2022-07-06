<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Token;

class Usuario extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em',
        'deletado_em',
    ];

    //Método: Exibir a situação do usuário
    public function exibeSituacao()
    {

        if($this->deletado_em != null){
            // Usuário excluído

            $icone = '<span class="text-white">Excluído</span> <i class="fa fa-undo"></i> Desfazer';
            $situacao = anchor("usuarios/desfazerexclusao/$this->id", $icone, ['class'=> 'btn btn-outline-success btn-sm']);

            return $situacao;

        }

        // Se usuário for ativo
        if($this->ativo == true){
            
            return '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo'; 

        }

        // Se usuário for Inativo
        if($this->ativo == false){
            
            return '<i class="fa fa-lock text-danger"></i>&nbsp;Inativo'; 

        }

    }
    
    // Método: Verificar a senha do usuário
    public function verificaPassword(string $password): bool
    {

        return password_verify($password, $this->password_hash);

    }

    // Método: Verifica se o usuário tem permissão para acessar uma determinada rota
    public function temPermissaoPara(string $permissao) : bool
    {
        // Se o usuário logado é admin, return true
        if($this->is_admin == true)
        {
            return true;
        }

        // Se o usuário tiver permissões VAZIA, return false
        if(empty($this->permissoes))
        {
            return false;
        }

        // O usuário possui permissões
        // Então verificar se ele possui a permissão correta, caso não, return false
        if(in_array($permissao, $this->permissoes) == false)
        {
            return false;
        }
        
        // Permissão concedida
        return true;

    }

    /**
     * Método: iniciar a recuperação de senha
     */
    public function iniciaPasswordReset() : void
    {
        $token = new Token();

        // Enviar para o e-mail do usuário
        $this->reset_token = $token->getValue();
        
        // Salvar no banco de dados
        $this->reset_hash = $token->getHash();

        //O usuário tem 2H para resetar a senha
        $this->reset_expira_em = date('Y-m-d H:i:s', time() + 7200);
    }

}
