<?php

namespace App\Models;

use CodeIgniter\Model;

class ContasBancariasModel extends Model
{
    protected $table            = 'fin_contas_bancarias';
    protected $returnType       = 'App\Entities\ContaBancaria';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'banco_id',
        'banco_conta',
        'banco_agencia',
        'banco_tipo',
        'banco_pix1',
        'banco_pix2',
        'banco_telefone',
        'banco_ativo',

    ];

     // Validation
     protected $validationRules = [
        'banco_conta'       => 'required|min_length[2]|max_length[15]|is_unique[fin_contas_bancarias.banco_conta,id,{id}]',
        'banco_agencia'     => 'required',  
       

    ];
    protected $validationMessages = [
        'banco_conta' => [
            'required'      => 'Insira o número da sua conta',
            'min_length'    => 'insira pelo menos 2 caracteres.',
            'max_length'    => 'O máximo permitido é 15 caractéres.',
            'is_unique'     => 'Já existe uma categoria com este nome',
        ],
        'banco_agencia' => [
            'required'
        ]

    ];

    public function contasBancariasAtivas()
    {
        $atributos = [
            'fin_contas_bancarias.*'
        ];

        return $this->select($atributos)->where('ativo',1)->findAll();
    }

    public function recuperaInstituicoesBancarias(int $id){

        $atributos = [
            'fin_contas_bancarias.id AS conta_id',
            'fin_instituicoes_bancarias.*',
            'fin_contas_bancarias.id AS conta_id',
            'fin_instituicoes_bancarias.id AS banco_id',
            'fin_instituicoes_bancarias.instituicao_bancaria_nome AS banco_nome',
            
        ];

        return $this->select($atributos)
                    ->join('fin_instituicoes_bancarias', 'banco_id = conta_id')
                    ->where('fin_contas_bancarias.id', $id)
                    ->groupBy('banco_nome')
                    ->orderBy('fin_instituicoes_bancarias.id','ASC')
                    ->findAll();

    }

}
