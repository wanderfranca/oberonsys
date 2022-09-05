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
        'codigo' => 'required|max_length[29]|is_unique[ordens.codigo,id,{id}]',
        'equipamento' => 'required|max_length[145]',
    ];
    protected $validationMessages = [
        'cliente_id' => [
            'required' => '* Informe quem é o cliente',
        ],
        'codigo' => [
            'required' => '* Informe o código da OS',
            'max_length' => '* O máximo de caracteres é 29',
            'is_unique' => '* Já existe uma ordem com esse código',
        ],
        'equipamento' => [
            'required' => '* o equipamento',
        ],

    ];

    public function recuperaOrdens()
    {
        $atributos = [
            'ordens.codigo',
            'ordens.criado_em',
            'ordens.situacao',
            'clientes.nome',
            'clientes.cpf',
        ];

        return $this->select($atributos)
                    ->join('clientes', 'clientes.id = ordens.cliente_id')
                    ->orderBy('ordens.id', 'DESC')
                    ->withDeleted(true)
                    ->findAll();
    }

    /**
     * Método: Gerar código (protocolo de atendimento) da OS automaticamente
     * Formato: Dia + Mês + Ano + hora + minuto + 4 caracter alfanum maisculos aleatórios
     */
    public function geraCodigoOrdem() : string
    {
        do{

            $codigo = 'OS' . date('dmYHis') . strtoupper(random_string('alnum', 4));

            $this->select('codigo')->where('codigo', $codigo);

         }while($this->countAllResults() > 1);

        return $codigo;
    }
}
