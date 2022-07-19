<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Fornecedor extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em'
    ];


        //Método: Exibir a situação do usuário
        public function exibeSituacao()
        {
    
            if($this->deletado_em != null){
                // Fornecedor excluído
    
                $icone = '<span class="text-white">Excluído</span> <i class="fa fa-undo"></i> Recuperar';
                $situacao = anchor("fornecedores/desfazerexclusao/$this->id", $icone, ['class'=> 'btn btn-outline-success btn-sm']);
    
                return $situacao;
    
            }

                // Se o forncedor for ativo
                if($this->ativo == true)
                {
                    return '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo'; 
                }

                // Se o fornecedor for Inativo
                if($this->ativo == false)
                {
                    return '<i class="fa fa-lock text-danger"></i>&nbsp;Inativo'; 
                }
        
        }
      
}