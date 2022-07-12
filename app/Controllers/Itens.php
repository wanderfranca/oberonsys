<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Itens extends BaseController
{
    private $categoriaModel;


    public function __construct()
    {
        $this->categoriaModel = new \App\Models\CategoriaModel();
        $this->itemModel = new \App\Models\ItemModel();
    }


    public function index()
    {
        //
    }





}
