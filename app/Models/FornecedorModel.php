<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedorModel extends Model
{
    protected $table            = 'fornecedores';
    protected $returnType       = 'App\Entities\Fornecedor';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'razao',
        'cnpj',
        'ie',
        'telefone',
        'email',
        'responsavel',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'ativo',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'razao'                 => 'required|min_length[3]|max_length[120]|is_unique[fornecedores.razao,id,{id}]',
        'cnpj'                  => 'required|validaCNPJ|max_length[25]|is_unique[fornecedores.cnpj,id,{id}]',
        'ie'                    => 'required|max_length[25]|is_unique[fornecedores.ie,id,{id}]',
        'telefone'              => 'required|max_length[18]|is_unique[fornecedores.telefone,id,{id}]',
        'cep'                   => 'required|max_length[15]',
        'endereco'              => 'required|max_length[100]',
        'numero'                => 'max_length[20]',
        'bairro'                => 'required|max_length[50]',
        'cidade'                => 'required|max_length[50]',
        'estado'                => 'required|max_length[2]',
        'email'                 => 'valid_email|max_length[90]',

    ];
    protected $validationMessages = [
        'razao' => [
            'required' => 'Razão social ou Nome, é obrigatório.',
            'min_length' => 'insira pelo menos 3 caracteres.',
            'max_length' => 'O máximo permitido é 120 caracteres.',
        ],
        'cnpj' => [
            'required' => 'O CNPJ é obrigatório.',
            'max_length' => 'CNPJ Inválido',
            'is_unique' => 'Já existe um fornecedor cadastrado com este CNPJ',
        ],

        'email' => [
            'max_length' => 'O campo E-mail ultrapassou 90 caracteres.',
            'valid_email' => 'Informe um E-mail válido',
        ],

    ];


}
