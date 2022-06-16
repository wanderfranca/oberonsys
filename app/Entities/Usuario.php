<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Usuario extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em',
        'deletado_em',
    ];

    public function exibeSituacao(){

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
    
}
