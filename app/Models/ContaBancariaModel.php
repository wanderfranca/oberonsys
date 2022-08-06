<?php

namespace App\Models;

use CodeIgniter\Model;

class ContaBancariaModel extends Model
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

    // Dates
    protected $createdField         = 'cadastrado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

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

    public function recuperaInstituicoesBancarias(){

        $atributos = [
            'fin_instituicoes_bancarias.*',
            
        ];

        return $this->select($atributos)->findAll();

    }

}
