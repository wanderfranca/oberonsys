<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdemModel extends Model
{
    protected $table            = 'ordens';
    protected $returnType       = 'App\Entities\Ordem';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'cliente_id',
        'codigo',
        'forma_pagamento',
        'situacao',
        'itens',
        'valor_produtos',
        'valor_servicos',
        'valor_desconto',
        'valor_ordem',
        'equipamento',
        'defeito',
        'observacoes',
        'parecer_tecnico',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'cliente_id' => 'required',
        'codigo' => 'required|max_length[29]',
        'equipamento' => 'required|max_length[145]',
    ];
    protected $validationMessages = [
        'cliente_id' => [
            'required' => '* Informe quem é o cliente',
        ],
        'codigo' => [
            'required' => '* Informe o código da OS',
            'max_length' => '* O máximo de caracteres é 29',
        ],
        'equipamento' => [
            'required' => '* o equipamento',
        ],

    ];

    /**
     * Método: Gerar código interno da OS automaticamente
     * 
     */
    public function geraCodigoOrdem() : string
    {
        do{

            $codigo = random_string('alnum', 20);

            $this->sleect('codigo')->where('codigo', $codigo);

         }while($this->countAllResults() > 1);

        return $codigo;
    }


}
