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

    public function recuperaItens()
    {

    }





}
