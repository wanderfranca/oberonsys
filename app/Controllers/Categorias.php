<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Categorias extends BaseController
{

    private $categoriaModel;


    public function __construct()
    {
        $this->categoriaModel = new \App\Models\CategoriaModel();
    }


    public function index()
    {
        $data = [

            'titulo' => 'Categorias',

        ];

        return view('categorias/index', $data);
    }
  
    
    public function recuperaCategorias()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                'id',
                'nome',
                'descricao',
                'ativo',
                'criado_em',
                // 'atualizado_em',

            ];

            // SELECT EM TODAS AS CATEGPROAS
            $categorias = $this->categoriaModel->select($atributos)
                                                ->orderBy('id', 'DESC')
                                                ->findAll();


            //Receberá o array de objetos de categorias
            $data = [];

            foreach($categorias as $categoria){


                $data[] = [

                    'nome'          => anchor("categorias/editar/$categoria->id", esc($categoria->nome), 'title="Exibir categoria '.esc($categoria->nome).'"'),
                    'descricao'     => esc($categoria->descricao),
                    'ativo'         => esc($categoria->ativo == 1 ? 'Ativo' : 'Inativo' ), 
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    public function buscaCategoriaOu404(int $id = null)
    {
        if (!$id || !$categoria = $this->categoriaModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("categoria não encontrado pelo Código informado");

        }

        return $categoria;
    }
}
