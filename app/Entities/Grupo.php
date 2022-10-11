<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Grupo extends Entity
{
    protected $dates   = ['criado_em', 'atualizado_em', 'deletado_em'];


    public function exibeSituacao(){

        if($this->deletado_em != null){
            // Grupo excluído

            $icone = '<i class="fa fa-undo"></i> Desfazer exclusão';
            $situacao = anchor("grupos/desfazerexclusao/$this->id", $icone, ['class'=> 'btn btn-outline-success btn-sm']);

            return $situacao;

        }

        // Se grupo for ativo
        if($this->exibir == true){
            
            return '<i class="fa fa-eye text-success"></i>&nbsp;Exibindo'; 

        }

        // Se usuário for Inativo
        if($this->exibir == false){
            
            return '<i class="fa fa-eye-slash text-danger"></i>&nbsp;Não exibir'; 

        }

    }

}


