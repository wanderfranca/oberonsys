<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Traits\OrdemTrait;

class OrdensItens extends BaseController
{

    use OrdemTrait;

    private $ordemModel;
    private $ordemItemModel;
    private $itemModel;

    public function __construct()
    {
        $this->ordemModel = new \App\Models\OrdemModel();
        $this->ordemItemModel = new \App\Models\OrdemItemModel();
        $this->itemModel = new \App\Models\ItemModel();
    }


    public function itens(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);

        // Preparar a exibição dos possíveis itens
        $this->preparaItensDaOrdem($ordem);

        $data = [

            'titulo' => "Gerenciar os itens da ordem - $ordem->codigo",
            'ordem' => $ordem,

        ];

        return view('Ordens/itens', $data);

    }

    public function pesquisaItens()
    {
        if(!$this->request->isAjax())
        {
            return redirect()->back();
        }

        $term = $this->request->getGet('term');

        $itens = $this->itemModel->pesquisaItens($term);

        $retorno = [];

        foreach($itens as $item)
        {
            $data['id'] = $item->id;
            $data['item_preco'] = number_format($item->preco_venda, 2);
            
            $itemTipo = ucfirst($item->tipo);

            // Se for produto
            if($item->tipo === 'produto')
            {
                // Tem imagem
                if($item->imagem != null)
                {
                    $caminhoImagem = "itens/imagem/$item->imagem";
                    $altImagem = $item->nome;

                } else 
                {
                    $caminhoImagem = "recursos/img/item_sem_imagem.png";
                    $altImagem = "$item->nome Não possui imagem";
                }

                $data['value'] = "[ Código: $item->codigo_interno ] [ $itemTipo ] [ Estoque: $item->estoque ] $item->nome";

                // Se for serviço
            } else
            {
                $caminhoImagem = "recursos/img/servico.png";
                $altImagem = $item->nome;

                $data['value'] = "[ Código: $item->codigo_interno ] [ $itemTipo ] $item->nome";

            }

            $imagem = [
                'src' => $caminhoImagem,
                'class' => 'img-fluid imag-thumbnail',
                'alt' => $altImagem,
                'width' => '50',
            ];

            $data['label'] = '<span>'.img($imagem).' '. $data['value'].'</span>';

            $retorno[] = $data;

        }

        return $this->response->setJSON($retorno);

    }

    public function adicionarItem()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        $validacao = service('validation');

        $regras = [
            'item_id' => 'required',
            'item_quantidade' => 'required|greater_than[0]',
        ];

        $mensagens = [//Errors
            'item_id' => [
                'required' => '* Escolha pelo menos um item',
            ],
            'item_quantidade' => [
                'required' => '* Informe a quantidade do item',
                'greater_than' => '* O item não pode ser inferior a 1',
            ],
        ];

        $validacao->setRules($regras, $mensagens);

        if($validacao->withRequest($this->request)->run() === false){
        
            // Retorno de validações
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $validacao->getErrors();

            return $this->response->setJSON($retorno);

        }

        $post = $this->request->getPost();

        $ordem = $this->ordemModel->buscaOrdemOu404($post['codigo']);

        // Validar a existência do item
        $item = $this->buscaItemOu404($post['item_id']);


        if($item->tipo === 'produto' && $post['item_quantidade'] > $item->estoque)
        {
             // Retorno de validações
            $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['estoque' => "Este produto possui apenas <b class='text-white'> $item->estoque </b> UND. em estoque"];

                return $this->response->setJSON($retorno);
        }

        // Verificar se a OS já possui o item escolhido
        if($this->verificaSeOrdemPossuiItem($ordem->id, $item->id))
        {
            $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['estoque' => "Esta O.S já possui o item selecionado"];

                return $this->response->setJSON($retorno);
        }


        // Dados que serão inseridos
        $ordemItem = [
            'ordem_id' => (int) $ordem->id,
            'item_id' => (int) $item->id,
            'item_quantidade' => (int) $post['item_quantidade'],
            'item_preco' => $post['item_preco'],
            'item_preco_total' => $post['item_preco'] * (int) $post['item_quantidade'],
        ];

        // echo '<pre>';
        // print_r($ordemItem);
        // exit;

        if($this->ordemItemModel->insert($ordemItem))
        {
            session()->setFlashdata('sucesso', "+1 um item adicionado!");

            return $this->response->setJSON($retorno);
        }

        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->ordemItemModel->errors();

        return $this->response->setJSON($retorno);

    }

    /**
     * Método que recupera o Item (produto ou serviço)
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
     * verificaSeOrdemPossuiItem
     * Método: Verifica no banco de dados se a ordem de serviço já possui aquele determinado item
     * Returnará um boleano, caso encontre ou não
     * Obs: Posso utilizar esse método como base para outros eventos
     * @param  mixed $ordem_id
     * @param  mixed $item_id
     * @return bool
     */
    private function verificaSeOrdemPossuiItem(int $ordem_id, int $item_id ) : bool
    {
        $possuiItem = $this->ordemItemModel
                            ->where('ordem_id', $ordem_id)
                            ->where('item_id', $item_id)
                            ->first();
        
         // A OS Não possui o item
        if($possuiItem === null) {

            return false;

        }

        // A OS possui o item
        return true;
    }
}
