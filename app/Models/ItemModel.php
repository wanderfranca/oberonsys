<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'itens';
    protected $returnType       = 'App\Entities\Item';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'codigo_interno',
        'ean',
        'nome',
        'marca',
        'modelo',
        'preco_custo',
        'preco_venda',
        'estoque',
        'controla_estoque',
        'tipo',
        'ativo',
        'descricao',
        'categoria_id',
    ];

    // Dates
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'nome'                  => 'required|min_length[2]|max_length[120]|is_unique[itens.nome,id,{id}]',
        'preco_venda'           => 'required',
        'descricao'             => 'required',
    ];
    protected $validationMessages = [];

    /**
     * Método: Gerar código interno automaticamente
     * 
     */
    public function geraCodigoInternoItem() : string
    {
        do{

            $codigoInterno = random_string('numeric', 8);

            $this->where('codigo_interno', $codigoInterno)->first();

         }while($this->countAllResults() > 1);

        return $codigoInterno;
    }

}
