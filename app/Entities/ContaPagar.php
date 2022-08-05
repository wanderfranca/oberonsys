<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ContaPagar extends Entity
{
    protected $dates   = ['criado_em', 'atualizado_em',];


    // Método: Exibe situação da conta a pagar
    // 0 = em aberto
    // 1 = Paga
    public function exibeSituacao() : string
    {
        // Verificação: Conta paga
        if($this->situacao == 1 )
        {
            return '<i class="fa fa-check-circle text-success"></i>&nbsp;Paga em: ' . date('d/m/Y', strtotime($this->atualizado_em));
        }

        // Verificação: Conta Vence Hoje
        if($this->data_vencimento == date('Y-m-d') )
        {
            return '<i class="fa fa-check-circle text-warning"></i>&nbsp;Hoje ' . date('d/m/Y', strtotime($this->data_vencimento));
        }

        // Verificação: Conta Vencerá em...
        if($this->data_vencimento > date('Y-m-d') )
        {
            return '<i class="fa fa-check-circle text-info"></i>&nbsp;Vencerá em ' . date('d/m/Y', strtotime($this->data_vencimento));
        }

        // Verificação: Conta em atraso
        if($this->data_vencimento < date('Y-m-d') && $this->situacao == 0)
        {
            return '<i class="fa fa-check-circle text-danger"></i>&nbsp;Em atraso ' . date('d/m/Y', strtotime($this->data_vencimento));
        }
    }
}


