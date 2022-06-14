<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [

        'nome',
        'email',
        'password',
        'reset_hash',
        'reset_expira_em',
        'imagem',
        //campo ativo não - pois existe a manipulação de formulário

    ];

    // Dados
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'nome'                  => 'required|min_length[3]|max_length[125]',
        'email'                 => 'required|valid_email|min_length[5]|max_length[230]|is_unique[usuarios.email,id,{id}]',
        'password'              => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];
    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatório.',
            'min_length' => 'O campo nome precisa ter pelo menos 3 caracteres.',
            'max_length' => 'O campo nome ultrapassou 125 caracteres.',
        ],
        'email' => [
            'required' => 'O campo E-mail é obrigatório.',
            'min_length' => 'O campo E-mail precisa ter pelo menos 5 caracteres.',
            'max_length' => 'O campo E-mail ultrapassou 230 caracteres.',
            'is_unique' => 'Este e-mail já está sendo utilizado por outro usuário.',
        ],
        'password_confirmation' => [
            'required_with' => 'Por favor, cofirme sua senha.',
            'matches' => 'As senhas precisam combinar',
        ],
    ];

    // Callbacks
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];


    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']); 
            unset($data['data']['password_confirmation']); 
        }

            return $data;
    }

}
