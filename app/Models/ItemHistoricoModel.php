<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemHistoricoModel extends Model
{
    protected $table            = 'itens_historico';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'usuario_id',
        'item_id',
        'acao',
        'atributos_alterados',
    ];

   public function recuperaHistoricoItem($item_id, $quantidade_paginacao)
   {

    $atributos = [
        'usuarios.id',
        'usuarios.nome AS nome_usuario',
        'atributos_alterados',
        'itens_historico.criado_em',
        'acao',
        'usuario_id',
    ];

        return $this
        ->asArray()
        ->select($atributos)
        ->join('usuarios', 'usuario_id = usuarios.id')
        ->where('item_id', $item_id)
        ->orderBy('itens_historico.criado_em', 'DESC')
        ->paginate($quantidade_paginacao); //Faça o paginate pelo valor da informação definida no parâmetro
   }
}
