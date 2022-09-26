<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracaoModel extends Model
{
    protected $table            = 'configuracoes';
    protected $returnType       = 'App\Entities\Configuracao';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'razao',
        'codigo_empresa',
        'cpf_cnpj',
        'cnae',
        'nire',
        'data_nire',
        'isento',
        'ie',
        'im',
        'regime_tributario',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'complemento',
        'cidade',
        'estado',
        'telefone1',
        'telefone2',
        'email',
        'site',
        'logotipo',
        'atualizado_por',
        'criado_em',
        'atualizado_em',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';

     // Validation
     protected $validationRules = [
        'razao'                 => 'required|min_length[3]|max_length[145]|is_unique[configuracoes.razao,id,{id}]',
        'cpf_cnpj'              => 'required|max_length[25]|is_unique[configuracoes.cpf_cnpj,id,{id}]',
        'ie'                    => 'max_length[25]|is_unique[configuracoes.ie,id,{id}]',
        'cnae'                  => 'max_length[25]',
        'nire'                  => 'max_length[25]',
        'cep'                   => 'required|max_length[15]',
        'endereco'              => 'required|max_length[100]',
        'numero'                => 'required|max_length[20]',
        'bairro'                => 'required|max_length[50]',
        'cidade'                => 'required|max_length[50]',
        'estado'                => 'required|max_length[2]',
        'email'                 => 'valid_email|max_length[100]',

    ];
    protected $validationMessages = [
        'razao' => [
            'required' => 'A razão social é obrigatória.',
            'min_length' => 'insira pelo menos 3 caracteres.',
            'max_length' => 'O máximo permitido é 150 caractéres.',
        ],
        'cpf_cnpj' => [
            'required' => 'O campo E-mail é obrigatório.',
            'max_length' => 'CNPJ Inválido',
            'is_unique' => 'Já existe um fornecedor cadastrado com este CNPJ',
        ],
        'email' => [
            'max_length' => 'O campo E-mail ultrapassou 90 caracteres.',
            'valid_email' => 'Informe um E-mail válido',
        ],
        'cep' => [
            'required' => 'O Cep é obrigatório.',
        ],
        'endereco' => [
            'required' => 'O Endereço é obrigatório.',
        ],
        'numero' => [
            'required' => 'O número do endereço é obrigatório.',
        ],
        'bairro' => [
            'required' => 'O bairro é obrigatório.',
        ],
        'cidade' => [
            'required' => 'A cidade é obrigatória.',
        ],
        'estado' => [
            'required' => 'O Estado (UF) é obrigatório.',
        ],
    ];
}
