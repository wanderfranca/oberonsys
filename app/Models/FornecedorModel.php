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
        'cep',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'ativo',

    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'razao'                 => 'required|min_length[3]|max_length[150]|is_unique[fornecedores.razao,id,{id}]',
        'cnpj'                  => 'required|validaCNPJ|max_length[25]|is_unique[fornecedores.cnpj,id,{id}]',
        'ie'                    => 'required|max_length[25]|is_unique[fornecedores.ie,id,{id}]',
        'telefone'              => 'required|max_length[18]|is_unique[fornecedores.telefone,id,{id}]',
        'cep'                   => 'required|max_length[15]',
        'endereco'              => 'required|max_length[100]',
        'numero'                => 'max_length[20]',
        'bairro'                => 'required|max_length[50]',
        'cidade'                => 'required|max_length[50]',
        'estado'                => 'required|max_length[2]',
    ];
    protected $validationMessages = [
        'razao' => [
            'required' => 'A razão social é obrigatória.',
            'min_length' => 'insira pelo menos 3 caracteres.',
            'max_length' => 'O máximo permitido é 150 caractéres.',
        ],
        'cnpj' => [
            'required' => 'O campo E-mail é obrigatório.',
            'max_length' => 'CNPJ Inválido',
            'is_unique' => 'Já existe um fornecedor cadastrado com este CNPJ',
        ],

    ];


}
