<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Item;

class Itens extends BaseController
{
    private $itemModel;
    private $itemHistoricoModel;
    private $categoriaModel;


    public function __construct()
    {
        $this->itemModel = new \App\Models\ItemModel();
        $this->itemHistoricoModel= new \App\Models\ItemHistoricoModel();
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

        $quantidade_paginacao = 5;

        $this->defineHistoricoItem($item, $quantidade_paginacao);

        $item->historico_item = $this->itemHistoricoModel->where('item_id', $item->id)->paginate($quantidade_paginacao);
        

        if($item->historico_item !=null)
        {
            $item->pager = $this->itemHistoricoModel->pager;
        }
        
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

    public function cadastrar()
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
            $item = new Item($post);

            // $item->codigo_interno = $this->itemModel->geraCodigoInternoItem();

            $item_id = $this->post['id'];

                       
            // Verificações de produto
            if($item->tipo === 'produto')
            {

                // Verificação: Marca do produto
                if($item->marca == "" || $item->marca == null)
                {
                    //Retornar os erros de validação do formulário
                    $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                    $retorno['erros_model'] = ['marca' => '* Defina uma marca para o produto'];                    
                    return $this->response->setJSON($retorno);
                }

                // Verificação: Modelo do produto
                if($item->modelo == "" || $item->modelo == null)
                {
                    //Retornar os erros de validação do formulário
                    $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                    $retorno['erros_model'] = ['modelo' => '* Defina um modelo para o produto'];                    
                    return $this->response->setJSON($retorno);
                }

                // Verificação: Proibido estoque vazio no ato de cadastro
                if($item->estoque == "")
                {
                    //Retornar os erros de validação do formulário
                    $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                    $retorno['erros_model'] = ['estoque' => '* Defina a quantidade do produto em estoque'];                    
                    return $this->response->setJSON($retorno);
                }

               
                              
                    if($this->itemModel->where('itens', array('ean' => $ean,'id !='=> $item_id)) == false){
                        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                        $retorno['erros_model'] = ['estoque' => '* Defina a quantidade do produto em estoque'];
                        return $this->response->setJSON($retorno);
                    
                    }


                // if($item->ean == "")
                // {
                //     //Retornar os erros de validação do formulário
                //     $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                //     $retorno['erros_model'] = ['estoque' => '* Defina a quantidade do produto em estoque'];                    
                //     return $this->response->setJSON($retorno);
                // }

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

                $btnCriar = anchor("Itens/criar", 'Cadastrar mais Produtos/Serviços', ['class' => 'btn btn-primary mt2']);
                session()->setFlashdata('sucesso', "Seu item foi cadastrado com sucesso! <br> $btnCriar");
    
                $retorno['id'] = $this->itemModel->getInsertID();


                return $this->response->setJSON($retorno);
    
            }
    
            //Retornar os erros de validação do formulário
            $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = $this->itemModel->errors();
    
    
            // Retorno para o ajax request
            return $this->response->setJSON($retorno);




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

                // Store do histórico do item
                $this->insereHistoricoItem($item, 'Atualização');

                //Mensagem e envio para JSON
                session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
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


    /**
     * Método: Define o histórico de alterações do item
     * Retorna em Objeto
     * 
     */
    private function defineHistoricoItem(object $item, int $quantidade_paginacao)
    {
        $atributos = [
            'usuarios.id',
            'usuarios.nome AS nome_usuario',
            'atributos_alterados',
            'data_modificacao',
            'acao',
            'usuario_id',
        ];

        $historico = $this->itemHistoricoModel
                            ->asArray()
                            ->select($atributos)
                            ->join('usuarios', 'usuario_id = usuarios.id')
                            ->where('item_id', $item->id)
                            ->orderBy('data_modificacao', 'DESC')
                            ->paginate($quantidade_paginacao); //Faça o paginate pelo valor da informação definida no parâmetro
   

        if($historico != null)
        {
            foreach($historico as $key => $hist)
            {
                $historico[$key]['atributos_alterados'] = unserialize($hist['atributos_alterados']);
            
            }

            $item->historico = $historico;
        }

        return $item;
    }

    /**
     * Método: Fazer o insert (store) das informações de atualização de item na tabela
     * 
     */
    private function insereHistoricoItem(object $item, string $acao) : void
    {
        $historico = [
            'usuario_id' => usuario_logado()->id,
            'item_id' => $item->id,
            'acao'=> $acao,
            'atributos_alterados' => $item->recuperaAtributosAlterados(),
        ];

        $this->itemHistoricoModel->insert($historico);
    }


}
