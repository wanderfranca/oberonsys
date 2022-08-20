<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Item;

class Itens extends BaseController
{
    private $itemModel;
    private $itemHistoricoModel;
    private $itemImagemModel;
    private $categoriaModel;


    public function __construct()
    {
        $this->itemModel = new \App\Models\ItemModel();
        $this->itemHistoricoModel= new \App\Models\ItemHistoricoModel();
        $this->itemImagemModel= new \App\Models\ItemImagemModel();
        $this->categoriaModel = new \App\Models\CategoriaModel();
    }


    public function index()
    {
        $data = [

            'titulo'                => 'Produtos e Serviços',
            'titulo_visaogeral'     => 'Visão Geral',
            'titulo_estoquezerado'  => 'Produtos com estoque zerado',
            
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
                                    // ->withDeleted(true)
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
                'tipo' => $item->exibeTipo(),
                'preco_venda' =>'R$ '.$item->preco_venda,
                'situacao' => $item->exibeSituacao(),

            ];
        }

        $retorno = [
            'data' => $data,
        ];

        return $this->response->setJSON($retorno);
    }

    // Método: recuperar produtos excluídos (deletado_em)
    public function recuperaProdutosExcluidos()
    {
        if (!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        $atributos = [
            'id',
            'nome',
            'codigo_interno',
            'estoque',
            'tipo',
            'preco_venda',
            'situacao',
            'deletado_em',

        ];

        $itens = $this->itemModel->select($atributos)
                                    ->withDeleted(true)
                                    ->where('deletado_em <', date('Y-m-d H:i:s'))
                                    ->where('tipo', 'produto')
                                    ->orderBy('id', 'DESC')
                                    ->findAll();

        $data = [];

        foreach($itens as $item)
        {
            $data[] = [
                'nome' => anchor("itens/exibir/$item->id", esc($item->nome), 'title= "Clique para visualizar o produto '.esc($item->nome).' "'),
                'codigo_interno' => $item->codigo_interno,
                'estoque' => $item->exibeEstoque(),
                'preco_venda' =>'R$ '.$item->preco_venda,
                'situacao' => $item->exibeSituacao(),

            ];
        }

        $retorno = [
            'data' => $data,
        ];

        // echo '<pre>';
        // print_r($data);
        // exit;

        return $this->response->setJSON($retorno);
    }

    // Método: recuperar serviços excluídos (deletado_em)
    public function recuperaServicosExcluidos()
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
            'preco_venda',
            'situacao',
            'deletado_em',

        ];

        $itens = $this->itemModel->select($atributos)
                                    ->withDeleted(true)
                                    ->where('deletado_em <', date('Y-m-d H:i:s'))
                                    ->where('tipo', 'serviço')
                                    ->orderBy('id', 'DESC')
                                    ->findAll();

        $data = [];

        foreach($itens as $item)
        {
            $data[] = [
                'nome' => anchor("itens/exibir/$item->id", esc($item->nome), 'title= "Clique para visualizar o cadastro do serviço '.esc($item->nome).' "'),
                'codigo_interno' => $item->codigo_interno,
                'preco_venda' =>'R$ '.$item->preco_venda,
                'situacao' => $item->exibeSituacao(),

            ];
        }

        $retorno = [
            'data' => $data,
        ];


        return $this->response->setJSON($retorno);
    }

    // Método: Recuperar produtos com estoque zerado
    public function recuperaItensEstoqueZerado()
    {
        if(!$this->request->isAJAX())
        {return redirect()->back();}

        $atributos = [
            'id',
            'nome',
            'codigo_interno',
            'estoque',
            'tipo',
            'preco_venda',
            'situacao',
            'deletado_em',

        ];

        $itens = $this->itemModel->select($atributos)
                                    ->withDeleted(true)
                                    ->where('estoque =', 0)
                                    ->where('tipo', 'produto')
                                    ->orderBy('id', 'DESC')
                                    ->findAll();

        $data = [];

        foreach($itens as $item)
        {
            $data[] = [
                'nome' => anchor("itens/exibir/$item->id", esc($item->nome), 'title= "Clique para visualizar o produto '.esc($item->nome).' "'),
                'codigo_interno' => $item->codigo_interno,
                'estoque' => $item->exibeEstoque(),
                'preco_venda' =>'R$ '.$item->preco_venda,
                'situacao' => $item->exibeSituacao(),

            ];
        }

        $retorno = [
            
            'data' => $data,
        ];

        // echo '<pre>';
        // print_r($data);
        // exit;

        return $this->response->setJSON($retorno);

    }
    

    // Método: Recuperar produtos com estoque zerado
    public function recuperaItensNegativos()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        $atributos = [
            'id',
            'nome',
            'codigo_interno',
            'estoque',
            'tipo',
            'preco_venda',
            'situacao',
            'deletado_em',

        ];

        $itens = $this->itemModel->select($atributos)
                                    ->withDeleted(true)
                                    ->where('estoque <', 0)
                                    ->where('tipo', 'produto')
                                    ->orderBy('id', 'DESC')
                                    ->findAll();

        $data = [];

        foreach($itens as $item)
        {
            $data[] = [
                'nome' => anchor("itens/exibir/$item->id", esc($item->nome), 'title= "Clique para visualizar o produto '.esc($item->nome).' "'),
                'codigo_interno' => $item->codigo_interno,
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
    
    // Método: exibe produtos excluídos
    public function produtosexcluidos()
    {


        $data = [

            'titulo' => 'PRODUTOS EXCLUÍDOS',            

        ];

        return view('Itens/excluidos_produtos', $data);

    }

    // Método: exibe serviços excluídos
    public function servicosexcluidos()
    {

        $data = [

            'titulo' => 'SERVIÇOS EXCLUÍDOS',            

        ];

        return view('Itens/excluidos_servicos', $data);

    }

    // Método: exibir produtos e serviços ativos
    public function exibir(int $id = null)
    {

        $item = $this->buscaItemOu404($id);

        // Quantidade de paginas
        $quantidade_paginacao = 5;

        $this->defineHistoricoItem($item, $quantidade_paginacao);

        $item->historico_item = $this->itemHistoricoModel->where('item_id', $item->id)->paginate($quantidade_paginacao);
        

        if($item->historico_item !=null)
        {
            $item->pager = $this->itemHistoricoModel->pager;
        }

        if($item->tipo === "produto")
        {
            $itemImagem = $this->itemImagemModel->select('imagem')->where('item_id', $item->id)->first();
            if($itemImagem !== null)
            {
                $item->imagem = $itemImagem->imagem;
            }
        }
        
        $data = [

            'titulo' => "Visualizar item",
            'item' => $item,
        ];

        return view('Itens/exibir', $data);

    }

    // Método: criar produto
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
        $categoriasAtivas = $this->categoriaModel->categoriasAtivas(); //Todas as categorias
        $categoriaItem = $this->itemModel->recuperaCategoriaDeItens($id);

        $data = [

            'titulo' => "EDITAR ITEM: " .$item->nome,
            'item' => $item,
            'categoriaItem' => $categoriaItem,
            'categoriasAtivas' => $categoriasAtivas,
        ];


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

    public function editarImagem(int $id = null)
    {

        $item = $this->buscaItemOu404($id);

        if($item->tipo === 'serviço')
        {

            return redirect()->back()->with('info', "Imagens são apaenas para itens do tipo PRODUTO");
        }

        $item->imagens = $this->itemImagemModel->where('item_id', $item->id)->findAll();

        $data = [
            'titulo'    => "UPLOAD DE IMAGENS - ".strtoupper($item->nome),
            'item'      => $item,

        ];

        return view('Itens/editar_imagem', $data);

    }

    public function upload()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        // Armazenar o hash do token do FORM
        $retorno['token'] = csrf_hash();

        $validacao = service('validation');

        $regras = [
            'imagens' => 'uploaded[imagens]|max_size[imagens,2048]|ext_in[imagens,png,jpg,jpeg,webp,gif]',
        ];

        $mensagens = [//Errors
            'imagens' => [
                'uploaded' => 'Por favor, escolha uma ou mais imagens',
                'ext_in' => 'Por favor, escolha uma imagem png, jpg, jpeg, webp ou gif',
                'max_size' => 'Tamanho Máx permitido é 2048kb',
            ],
        ];

        $validacao->setRules($regras, $mensagens);

        if($validacao->withRequest($this->request)->run() === false){
        
            // Retorno de validações
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $validacao->getErrors();

            return $this->response->setJSON($retorno);

        }

        // Recupero o post da requisição
        $post = $this->request->getPost();

        //Validar a existência do item
        $item = $this->buscaItemOu404($post['id']);

        $resultadoTotalImagens = $this->defineQuantidadeDeImagens($item->id);

        if($resultadoTotalImagens['totalImagens'] > 10)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['total_imagens' => "O produto pode ter no máximo 10 imagens. Ele possui " . $resultadoTotalImagens['existentes'] . ' imagens'];

            return $this->response->setJson($retorno);
        }

        // getFiles - para múltiplas imagens
        $imagens = $this->request->getFiles('imagens');

        // Validação Foreach: Tamanho mínimo da imagem
        foreach($imagens['imagens'] as $imagem)
        {
            
        list($largura, $altura) = getimagesize($imagem->getPathname());

        if($largura < "400" || $altura < "400" ){

                $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                $retorno['erros_model'] = ['dimensao' => 'A imagem não pode ser menor do que 400 x 400 pixels'];

                return $this->response->setJSON($retorno);

            }
        }

        // Receberá as imagens para o insertBach
        $arrayImagens = [];

        foreach($imagens['imagens'] as $imagem)
        {
            $caminhoImagem = $imagem->store('itens');

            $caminhoImagem = WRITEPATH . "uploads/$caminhoImagem";

            $this->padronizaImagem600x600($caminhoImagem);

            array_push($arrayImagens, [
                'item_id' => $item->id ,
                'imagem' => $imagem->getName(),
            ]);
        }

        $this->itemImagemModel->insertBatch($arrayImagens);

        session()->setFlashdata('sucesso', 'Imagens enviadas com sucesso!');
        return $this->response->setJSON($retorno);
        
    }

    public function imagem(string $imagem = null)
    {

        if($imagem != null){

            $this->exibeArquivo('itens', $imagem);

        }

    }

    public function removeimagem(string $imagem = null)
    {

        if($this->request->getMethod() === 'post')
        {
            $objImagem = $this->buscaImagemOu404($imagem);

            // Remover nota fiscal - delete na tabela
            $this->itemImagemModel->delete($objImagem->id);

            // Remover arquivo
            $caminhoImagem = WRITEPATH . "uploads/itens/$imagem";

            if(is_file($caminhoImagem))
            {
                unlink($caminhoImagem);
            }

            return redirect()->back()->with("sucesso", "A imagem foi removida com sucesso!");

        }

        return redirect()->back();

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

    public function excluir(int $id = null)
    {

        $item = $this->buscaItemOu404($id);

        if($item->deletado_em != null)
        {
            return redirect()->back()->with('info', "O item $item->nome Já está excluído");
        }

        // Verificar se é o um post
        if($this->request->getMethod() === 'post')
        {
            $this->itemModel->delete($item->id);

            // Inserir histórico de exclusão
            $this->insereHistoricoItem($item, "Exclusão");

            if($item->tipo ==='produto')
            {
                $this->removeTodasImagensDoItem($item->id);

            }

            return redirect()->to(site_url("itens"))->with('sucesso', "Item $item->nome foi excluído com sucesso");
        }

        $data = [

            'titulo' => "EXCLUIR ITEM: ".esc($item->nome),
            'item' => $item,

        ];


        return view('Itens/excluir', $data);

    }

    public function desfazerExclusao(int $id = null)
    {


        $item = $this->buscaItemOu404($id);

        if($item->deletado_em == null){

            return redirect()->back()->with('info', "Apenas itens excluídos podem ser recuperados");

        }

        $item->deletado_em = null;
        $this->itemModel->protect(false)->save($item);
        // Inserir histórico de exclusão
        $this->insereHistoricoItem($item, "Recuperação");
        
        return redirect()->back()->with('sucesso', "$item->nome Restaurado com sucesso! Produtos restaurados, voltam sem IMAGEM, você pode alterar isso quando quiser =D");

    }


    /*---------------- MÉTODOS PRIVADOS ----------------- */


   private function defineQuantidadeDeImagens(int $item_id): array
   {
        // Recuperar as imagens que o item já possui
        $existentes = $this->itemImagemModel->where('item_id', $item_id)->countAllResults();

        // Contar o número de imagens que estão vindo no post
        $quantidadeImagensPost = count(array_filter($_FILES['imagens']['name']));

        $retorno = [
            'existentes' => $existentes,
            'totalImagens' => $existentes + $quantidadeImagensPost,
        ];
        //total de imagens suportada
       return $retorno;
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

    // Método: recupera imagem do item
    private function buscaImagemOu404(string $imagem = null)
    {

        if (!$imagem || !$objImagem = $this->itemImagemModel->where('imagem', $imagem)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Imagem não encontrada");

        }

        return $objImagem;

    }


    private function removeTodasImagensDoItem(int $item_id) : void 
    {
        // Recuperar as imagens que o item possa ou não TER
        $itensImagens = $this->itemImagemModel->where('item_id', $item_id)->findAll();

        if(empty($itensImagens)===false)
        {
            $this->itemImagemModel->where('item_id', $item_id)->delete();

            foreach($itensImagens as $imagem)
            {
                $caminhoImagem = WRITEPATH . "uploads/itens/$imagem->imagem";

                if(is_file($caminhoImagem))
                {
                    unlink($caminhoImagem);
                }
            }
        }
    }

    /**
     * Método: Define o histórico de alterações do item
     * Retorna em Objeto
     * 
     */
    private function defineHistoricoItem(object $item, int $quantidade_paginacao)
    {
       $historico = $this->itemHistoricoModel->recuperaHistoricoItem($item->id, $quantidade_paginacao);   

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