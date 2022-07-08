<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Fornecedores extends BaseController
{

    private $fornecedorModel;

    public function __construct()
    {
        $this->fornecedorModel = new \App\Models\FornecedorModel();
    }

    public function index()
    {
        $data = [

            'titulo' => 'Fornecedores',

        ];

        return view('Fornecedores/index', $data);
    }

    public function recuperaFornecedores()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                
                'id',
                'razao',
                'cnpj',
                'telefone',
                'ativo',
                'deletado_em',
            ];

            // SELECT EM TODOS OS FornecedorS
            $fornecedores = $this->fornecedorModel->select($atributos)
                                                ->withDeleted(true) //Buscar também os dados deletados
                                                ->orderBy('id', 'DESC')
                                                ->findAll();


            //Receberá o array de objetos de fornecedores
            $data = [];

            foreach($fornecedores as $fornecedor){


                $data[] = [

                    'razao'         => anchor("fornecedores/exibir/$fornecedor->id", esc($fornecedor->razao), 'title="Exibir Fornecedor '.esc($fornecedor->razao).'"'),
                    'cnpj'          => esc($fornecedor->cnpj),
                    'telefone'      => esc($fornecedor->telefone),
                    'ativo'         => $fornecedor->exibeSituacao(),
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    public function exibir(int $id = null)
    {


        $fornecedor = $this->buscaFornecedorOu404($id);

        // dd($fornecedor);

        $data = [

            'titulo' => "Perfil do fornecedor: ".esc($fornecedor->nome),
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/exibir', $data);


    }

    /**
     * Método: que recupera o Fornecedor
     * 
     * @param integer $id
     * @return Exceptions|object
     */

    private function buscaFornecedorOu404(int $id = null)
    {

        if (!$id || !$fornecedor = $this->fornecedorModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Fornecedor não encontrado pelo ID informado");

        }

        return $fornecedor;

    }
}
