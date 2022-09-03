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
            return '<i class="fa fa-check-circle text-success"></i>&nbsp;<b class="text-white">PAGA</b>';
        }

        // Verificação: Conta Vence Hoje
        if($this->data_vencimento == date('Y-m-d') )
        {
            return '<i class="fa fa-exclamation-circle text-warning"></i>&nbsp;<b class="text-warning">VENCE HOJE </b>';
        }

        // Verificação: Conta Vencerá em...
        if($this->data_vencimento > date('Y-m-d') )
        {
            return '<i class="fa fa-circle text-info"></i>&nbsp;<b class="text-white">A VENCER</b>';
        }

        // Verificação: Conta em atraso
        if($this->data_vencimento < date('Y-m-d') && $this->situacao == 0)
        {
            return '<i class="fa fa-exclamation-circle text-danger"></i>&nbsp;<b class="text-white">EM ATRASO</b>';
        }
    }

    public function defineDataVencimentoEvento() : int
    {
        $dataAtualConvertida = $this->mutateDate(date('Y-m-d'));

        return $dataAtualConvertida->difference($this->data_vencimento)->getDays();
    }
}


