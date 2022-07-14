<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Item;

class Itens extends BaseController
{
    private $itemModel;


    public function __construct()
    {
        $this->itemModel = new \App\Models\ItemModel();
    }


    public function index()
    {
        $data = [

            'titulo' => 'Produtos e Serviços',
            

        ];

        return view('Itens/index', $data);

    }

    public function exibir(int $id = null)
    {

        $item = $this->buscaItemOu404($id);

        $data = [

            'titulo' => "Item ".$item->exibeTipo(),
            'item' => $item,
        ];

        return view('Itens/exibir', $data);

    }

    public function codigoBarras(int $id = null)
    {

        $item = $this->buscaItemOu404($id);

        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        $item->codigo_barras = $generator->getBarcode($item->codigo_interno, $generator::TYPE_CODE_128, 3, 80);

        echo $item->codigo_barras;
    }

    public function recuperaItens()
    {
        if (!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        $atributos = [
            'id',
            'nome',
            'codigo_interno',
            'tipo',
            'estoque',
            'preco_venda',
            'situacao',
            'deletado_em',

        ];

        $itens = $this->itemModel->select($atributos)
                                    ->withDeleted(true)
                                    ->orderBy('id', 'DESC')
                                    ->findAll();

        $data = [];

        foreach($itens as $item)
        {
            $data[] = [
                'nome' => anchor("itens/exibir/$item->id", esc($item->nome), 'title= "Clique para visualizar o produto '.esc($item->nome).' "'),
                'codigo_interno' => $item->codigo_interno,
                'tipo' => $item->exibeTipo(),
                'estoque' => $item->exibeEstoque(),
                'preco_venda' =>'R$ '.$item->preco_venda,
                'situacao' => $item->exibeSituacao(),

            ];
        }

        $retorno = [
            'data' => $data,
        ];

        return $this->response->setJSON($retorno);
    }

        /**
     * Método que recupera o Item (produto)
     * 
     * @param integer $id
     * @return Exceptions|object
     */

    private function buscaItemOu404(int $id = null)
    {

        if (!$id || !$item = $this->itemModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Item não encontrado pelo ID informado");

        }

        return $item;

    }





}
