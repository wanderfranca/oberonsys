<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdemItemModel extends Model
{
    protected $table            = 'ordens_itens';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'ordem_id',
        'item_id',
        'item_quantidade',
        'item_preco',
        'item_preco_total',
    ];

    
    /**
     * Método: Recuperar os itens da OS
     * 
     * @param  integer $ordem_id
     * @return array|null 
     */
    public function recuperaItensDaOrdem(int $ordem_id)
    {
        $atributos = [
            'itens.id',
            'itens.nome',
            'itens.preco_venda',
            'itens.tipo',
            'itens.controla_estoque',
            'ordens_itens.id AS id_principal',
            'ordens_itens.item_quantidade',
            'ordens_itens.item_preco AS preco_vendido',
            'ordens_itens.item_preco_total AS preco_total_vendido',
        ];

        return $this->select($atributos)
                    ->join('itens', 'itens.id = ordens_itens.item_id')
                    ->where('ordens_itens.ordem_id', $ordem_id)
                    ->groupBy('itens.nome')
                    ->orderBy('itens.tipo', 'ASC')
                    ->findAll();

    }
    
    /**
     * atualizaQuantidadeItem
     * Método: Faz update na coluna item_quantidade e item_preco_total
     * Objeto: Pega o objeto atualizado e recalcula o valor total dos itens
     * @param  mixed $ordemItem
     * @return void
     */
    public function atualizaQuantidadeItem(object $ordemItem)
    {

        return $this->set('item_quantidade', $ordemItem->item_quantidade)
                    ->set('item_preco_total', $ordemItem->item_preco_total)
                    ->where('id', $ordemItem->id)
                    ->update();

    }

}
