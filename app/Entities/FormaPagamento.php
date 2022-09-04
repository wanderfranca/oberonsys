<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FormaPagamento extends Entity
{
    protected $dates   = ['criado_em', 'atualizado_em'];


    //Método: Exibir a situação do usuário
    public function exibeSituacao()
    {

            // Se ativa
            if($this->ativo == true)
            {
                return '<i class="fa fa-unlock text-success"></i>&nbsp;Ativa'; 
            }

            // Se inativa
            if($this->ativo == false)
            {
                return '<i class="fa fa-lock text-danger"></i>&nbsp;Inativa'; 
            }
    
    }


}

     
