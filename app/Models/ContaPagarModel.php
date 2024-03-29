<?php

namespace App\Models;

use CodeIgniter\Model;

class ContaPagarModel extends Model
{
    protected $table            = 'contas_pagar';
    protected $returnType       = 'App\Entities\ContaPagar';

    protected $allowedFields    = [
        'fornecedor_id',
        'despesa_id',
        'documento_id',
        'conta_bancaria_id',
        'numero_documento',
        'valor_conta',
        'data_vencimento',
        'descricao_conta',
        'data_pagamento',
        'observacao',
        'situacao',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';

    // Validações
    protected $validationRules = [
        'fornecedor_id'         => 'required',
        'valor_conta'           => 'required|greater_than[0]',
        'data_vencimento'       => 'required',
        'descricao_conta'       => 'required',

    ];
    protected $validationMessages = [
        'fornecedor_id' => [
            'required' => 'Selecione 1 fornecedor',
        ],
        'valor_conta' => [
            'required' => 'O valor da conta é obrigatório',
            'greater_than' => 'O valor deve ser superior a 0 (zero)', 
        ],
        'data_vencimento' => [
            'required' => 'Informe a data de vencimento da conta',
        ],
        'descricao_conta' => [
            'required' => 'Informe a descrição da conta',
        ],

    ];

        // Callbacks
        protected $beforeInsert   = ['removeVirgulaValores'];
        protected $beforeUpdate   = ['removeVirgulaValores'];
    
    
        // Função: remover a vírgula dos preços
        protected function removeVirgulaValores(array $data)
        {
            if (isset($data['data']['valor_conta'])) {
    
                $data['data']['valor_conta'] = str_replace(",", "", $data['data']['valor_conta']);
     
            }
    
                return $data;
        }

    public function recuperaContasPagar(string $data_inicial, string $data_final) : array
    {

     $atributos = [
            'contas_pagar.*',
            'fornecedores.razao',
            'fornecedores.cnpj',
            'fin_despesas.despesa_nome AS despesa_nome',
            'tipos_documentos.tipo_documento_nome',
            'fin_contas_bancarias.id AS conta_id',
            'fin_contas_bancarias.banco_id',            
            'fin_contas_bancarias.banco_finalidade as banco_finalidade',            
        ];

        return $this->select($atributos)
                    ->join('fornecedores', 'fornecedores.id = contas_pagar.fornecedor_id')
                    ->join('fin_despesas','fin_despesas.id = contas_pagar.despesa_id')
                    ->join('tipos_documentos','tipos_documentos.id = contas_pagar.documento_id')
                    ->join('fin_contas_bancarias','fin_contas_bancarias.id = contas_pagar.conta_bancaria_id')
                    ->where('data_vencimento >= '. "'$data_inicial'" . ' AND data_vencimento <= '. "'$data_final'")
                    ->orderBy('contas_pagar.id', 'DESC') // 0 - contas em aberto e depois contas pagas
                    ->findAll(); 
    }

    public function buscaContaOu404(int $id = null)
    {
        if($id === null)
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("conta a pagar não encontrada");

        }

        $atributos = [
            'fornecedores.razao',
            'fornecedores.cnpj',
            'fin_despesas.despesa_nome',
            'tipos_documentos.tipo_documento_nome',
            'fin_contas_bancarias.id AS conta_id',
            'fin_contas_bancarias.banco_id',
            'contas_pagar.*',
        ];

        $conta  =  $this->select($atributos)
                    ->join('fornecedores', 'fornecedores.id = contas_pagar.fornecedor_id')
                    ->join('fin_despesas','fin_despesas.id = contas_pagar.despesa_id')
                    ->join('tipos_documentos','tipos_documentos.id = contas_pagar.documento_id')
                    ->join('fin_contas_bancarias','fin_contas_bancarias.id = contas_pagar.conta_bancaria_id')
                    ->orderBy('contas_pagar.situacao', 'ASC') // 0 - contas em aberto e depois contas pagas
                    ->find($id); 

        if($id === null)
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Conta a pagar não encontrada");

        }

        return $conta;


    }




}
