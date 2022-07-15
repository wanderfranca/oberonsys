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
        'situacao',
        'descricao',
        'categoria_id',
    ];

    // Dates
    protected $useTimestamps = true;
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

    // Callbacks
    protected $beforeInsert   = ['removeVirgulaValores'];
    protected $beforeUpdate   = ['removeVirgulaValores'];


    // Função: remover a vírgula dos preços
    protected function removeVirgulaValores(array $data)
    {
        if (isset($data['data']['preco_custo'])) {

            $data['data']['preco_custo'] = str_replace(",", "", $data['data']['preco_custo']);
 
        }
            
        if (isset($data['data']['preco_venda'])) {

            $data['data']['preco_venda'] = str_replace(",", "", $data['data']['preco_venda']);
 
        }

            return $data;
    }

    /**
 * Método: que recupera o grupo de acesso do usuário informado
 * Utilizado no controller de usuarios
 */
    public function recuperaCategoriaDeItens(int $id){

        $atributos = [
            'itens.id AS item_id',
            'categorias.*',
            'itens.categoria_id AS item_categoria_id',
            'categorias.id AS categoria_id',
            'categorias.nome AS categoria_nome',
            
        ];

        return $this->select($atributos)
                    ->join('categorias', 'categorias.id = itens.categoria_id')
                    ->where('itens.id', $id)
                    ->groupBy('categorias.nome')
                    ->findAll();

    }

    
    /**
     * Método: Gerar código interno automaticamente
     * 
     */
    public function geraCodigoInternoItem() : string
    {
        do{

            $codigoInterno = random_string('numeric', 14);

            $this->where('codigo_interno', $codigoInterno)->first();

         }while($this->countAllResults() > 1);

        return $codigoInterno;
    }

}
