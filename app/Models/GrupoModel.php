<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    protected $table            = 'grupos';
    protected $returnType       = 'App\Entities\Grupo';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'descricao', 'exibir'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

        // Validações
        protected $validationRules = [
            'nome'      => 'required|min_length[2]|max_length[120]|is_unique[grupos.nome,id,{id}]',
            'descricao' => 'required|max_length[230]',
        ];
        protected $validationMessages = [
            'nome' => [
                'required' => 'É necessário preencher o nome do grupo',
                'is_unique'=> 'Já existe um grupo com este nome, por favor escolha outro'
            ],
            'descricao' => [
                'required' => 'A descrição do grupo é obrigatória',
            ],

        ];

}
