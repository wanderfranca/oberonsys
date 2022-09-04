<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table            = 'formas_pagamentos';
    protected $returnType       = 'App\Entities\FormaPagamento';
    protected $allowedFields    = [
        'nome',
        'descricao',
        'ativo',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';

    // Validações
    protected $validationRules = [
        'nome'      => 'required|min_length[2]|max_length[120]|is_unique[formas_pagamentos.nome,id,{id}]',
        'descricao' => 'required|max_length[230]',
    ];
    protected $validationMessages = [
        'nome' => [
            'required' => '* Forma de pagamento obrigatória',
            'is_unique'=> '* Já existe uma forma de pagamento com este nome'
        ],
        'descricao' => [
            'required' => '* A descrição do grupo é obrigatória',
        ],

    ];

}
