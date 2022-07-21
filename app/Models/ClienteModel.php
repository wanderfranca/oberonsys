<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $returnType       = 'App\Entities\Cliente';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'usuario_id',
        'nome',
        'cpf',
        'telefone',
        'email',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'complemento',
        'cidade',
        'estado',

    ];

    // Dados
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'nome'                  => 'required|min_length[3]|max_length[100]',
        'email'                 => 'required|valid_email|min_length[5]|max_length[110]|is_unique[clientes.email,id,{id}]',
        'email'                 => 'is_unique[usuarios.email,id,{id}]', //Verificar e-mail na tabela de usuários (único para cliente e único para usuário)
        'telefone'              => 'required|exact_length[15]|is_unique[clientes.telefone,id,{id}]', //requerido pelo GERENCIANET
        'cpf'                   => 'required|exact_length[14]|validaCPF|is_unique[clientes.cpf,id,{id}]', 
        'cep'                   => 'required|exact_length[9]', 

    ];
    protected $validationMessages = [
        'nome' => [
            'required' => '* Informe o nome do cliente.',
            'min_length' => '* Pelo menos 3 caracteres.',
            'max_length' => '* Ultrapassou 100 caracteres.',
        ],
        'email' => [
            'required' => '* Um E-mail é obrigatório.',
            'min_length' => '* Precisa ter pelo menos 5 caracteres.',
            'max_length' => '* Ultrapassou 110 caracteres.',
            'is_unique' => '* Este e-mail já está sendo utilizado por outro cliente.',
        ],
        'cpf' => [
            'required' => '* Informe um CPF válido.',
            'exact_length' => '* Verifique e preencha corretamente',
            'is_unique' => '* Este CPF já está sendo utilizado por outro cliente.',
        ],

        'cep' => [
            'required' => '* Informe um CEP válido.',
        ],
    ];

}
