<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Cliente extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em'
    ];

        //Método: Exibir a situação do cliente
        public function exibeSituacao()
        {
    
            if($this->deletado_em != null){
                // Cliente excluído
    
                $icone = '<span class="text-white">Excluído</span> <i class="fa fa-undo"></i> Recuperar';
                $situacao = anchor("clientes/desfazerexclusao/$this->id", $icone, ['class'=> 'btn btn-outline-success btn-sm']);
    
                return $situacao;
    
            }

            $situacao = '<span class="text-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Disponível</span>';

            return $situacao;

        
        }
}
