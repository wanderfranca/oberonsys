<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Item;

class Itens extends BaseController
{
    private $itemModel;
    private $categoriaModel;


    public function __construct()
    {
        $this->itemModel = new \App\Models\ItemModel();
        $this->categoriaModel = new \App\Models\CategoriaModel();
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

    public function exibir(int $id = null)
    {

        $item = $this->buscaItemOu404($id);

        $data = [

            'titulo' => "Item ".$item->exibeTipo(),
            'item' => $item,
        ];

        return view('Itens/exibir', $data);

    }

    public function criar()
    {

        $item = new Item();
        $categoriasAtivas = $this->categoriaModel->categoriasAtivas(); //Todas as categorias

        $data = [

            'titulo' => "Cadastrar Um Novo Produto ou Serviço",
            'item' => $item,
            'categoriasAtivas' => $categoriasAtivas,
        ];

        return view('Itens/criar', $data);

    }

    public function editar(int $id = null)
    {

        $item = $this->buscaItemOu404($id);
        $categoria_id = $item->categoria_id;
        $categoriasAtivas = $this->categoriaModel->categoriasAtivas(); //Todas as categorias
        $categoriaItem = $this->itemModel->recuperaCategoriaDeItens($id);

        $data = [

            'titulo' => "Editar: " .$item->nome,
            'item' => $item,
            'categoriaItem' => $categoriaItem,
            'categoriasAtivas' => $categoriasAtivas,
        ];

        // echo '<pre>',
        // print_r($data['categoriaItem']);
        // exit;


        return view('Itens/editar', $data);

    }

    public function atualizar()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

            // Envio o hash do token do form
            $retorno['token'] = csrf_hash();

            // Recupero o post da requisição
            $post = $this->request->getPost();

            // Recuperar do post o Item pelo ID
            $item = $this->buscaItemOu404($post['id']);

            $item->fill($post);

            if($item->hasChanged() === false)
            {
                $retorno['info'] = 'Não há dados para atualizar';
                return $this->response->setJSON($retorno);

            }

            // Verificações de produto
            if($item->tipo === 'produto')
            {
                if($item->estoque == "")
                {
                    //Retornar os erros de validação do formulário
                    $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                    $retorno['erros_model'] = ['estoque' => '* Defina uma quantidade de estoque'];                    
                    return $this->response->setJSON($retorno);
                }

                $precoCusto = str_replace([',', '.'], '', $item->preco_custo);
                $precoVenda = str_replace([',', '.'], '', $item->preco_venda);

                if($precoCusto > $precoVenda)
                {
                    //Retornar os erros de validação do formulário
                    $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                    $retorno['erros_model'] = ['estoque' => '* O preço de <b class="text-white">Custo</b> não pode ser maior que o preço de <b class="text-white">Venda</b>'];                    
                    return $this->response->setJSON($retorno);
                }

            }

            if($this->itemModel->save($item)){

                session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
    
                //
                return $this->response->setJSON($retorno);
    
            }
    
            //Retornar os erros de validação do formulário
            $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = $this->itemModel->errors();
    
    
            // Retorno para o ajax request
            return $this->response->setJSON($retorno);




    }

    public function codigoBarras(int $id = null)
    {

        $item = $this->buscaItemOu404($id);

        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        $item->codigo_barras = $generator->getBarcode($item->codigo_interno, $generator::TYPE_CODE_128, 3, 80);

        $data = [

            'titulo' => "Código de Barras",
            'item' => $item,
        ];

        return view('Itens/codigo_barras', $data);


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
