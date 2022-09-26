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

            $icone = '<i class="fa fa-undo"></i> Recuperar';
            $situacao = anchor("ordens/desfazerexclusao/$this->codigo", $icone, ['class'=> 'btn btn-outline-success btn-sm']);

            return $situacao;
        }else 
        {

            if($this->situacao === 'aberta')
            {
                return '<span class="text-info" title="Esta Ordem de Serviço está aberta"><i class="fa fa-unlock" aria-hidden="true"></i>&nbsp;'.ucfirst($this->situacao);
            }
            if($this->situacao === 'encerrada')
            {
                return '<span class="text-white"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;'.ucfirst($this->situacao);
            }
            if($this->situacao === 'aguardando')
            {
                return '<span class="text-secondary" title="Aguardando pagamento via boleto"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;'.ucfirst($this->situacao);
            }
            if($this->situacao === 'nao_pago')
            {
                return '<span class="text-warning" title="O boleto desta Ordem de Serviço não foi pago"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp Não pago';
            }
            if($this->situacao === 'cancelada')
            {
                return '<span class="text-danger" title="Ordem de Serviço cancelada"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp'.ucfirst($this->situacao);;
            }

        }

        

    
    }
}
