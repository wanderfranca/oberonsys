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
}
