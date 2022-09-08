<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Ordem extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em'
    ];

    //Método: Exibir a situação da OS
    public function exibeSituacao()
    {

        if($this->deletado_em != null){
            // OS excluída

            if(url_is('relatorios*'))
            {
                return '<span class="text-white">Excluída</span>';
            }

            $icone = '<span class="text-white">Excluída</span> <i class="fa fa-undo"></i> Recuperar OS';
            $situacao = anchor("ordens/desfazerexclusao/$this->codigo", $icone, ['class'=> 'btn btn-outline-success btn-sm']);

            return $situacao;
        }else 
        {

            if($this->situacao === 'aberta')
            {
                return '<span class="text-info"><i class="fa fa-unlock" aria-hidden="true"></i>&nbsp;'.ucfirst($this->situacao);
            }
            if($this->situacao === 'encerrada')
            {
                return '<span class="text-white"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;'.ucfirst($this->situacao);
            }
            if($this->situacao === 'aguardando')
            {
                return '<span class="text-secondary"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;'.ucfirst($this->situacao);
            }
            if($this->situacao === 'nao_pago')
            {
                return '<span class="text-warning"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp Não pago';
            }
            if($this->situacao === 'cancelada')
            {
                return '<span class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp'.ucfirst($this->situacao);;
            }

        }

        

    
    }
}