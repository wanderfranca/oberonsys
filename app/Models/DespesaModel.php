<?php

namespace App\Models;

use CodeIgniter\Model;

class DespesaModel extends Model
{
    protected $table            = 'fin_despesas';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'despesa_nome',
        'despesa_descricao',

    ];

    // Validation
    protected $validationRules = [
        'despesa_nome'        => 'required|min_length[2]|max_length[90]|is_unique[fin_despesas.despesa_nome,id,{id}]',
       

    ];
    protected $validationMessages = [
        'despesa_nome' => [
            'required'      => 'Insira um nome único para sua despesa',
            'min_length'    => 'insira pelo menos 2 caracteres.',
            'max_length'    => 'O máximo permitido é 90 caractéres.',
            'is_unique'     => 'Já existe uma despesa com este nome',
        ],

    ];

    public function despesasAtivas()
    {
        $atributos = [
            'fin_despesas.*'
        ];

        return $this->select($atributos)->findAll();
    }
}
