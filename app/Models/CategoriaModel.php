<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    
        protected $table            = 'categorias';
        protected $returnType       = 'App\Entities\Categoria';
        protected $allowedFields    = [
            'nome',
            'descricao',
            'ativo',
    
        ];

         // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'nome'        => 'required|min_length[2]|max_length[90]|is_unique[categorias.nome,id,{id}]',
       

    ];
    protected $validationMessages = [
        'nome' => [
            'required'      => 'Insira um nome único para sua categoria',
            'min_length'    => 'insira pelo menos 2 caracteres.',
            'max_length'    => 'O máximo permitido é 90 caractéres.',
            'is_unique'     => 'Já existe uma categoria com este nome',
        ],

    ];

    public function categoriasAtivas()
    {
        $atributos = [
            'categorias.*'
        ];

        return $this->select($atributos)->where('ativo',1)->findAll();
    }
}
