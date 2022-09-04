<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class FormasPagamentos extends BaseController
{
    private $formaPagamentoModel;


    public function __construct()
    {
        $this->formaPagamentoModel = new \App\Models\FormaPagamentoModel();

    }

    public function index()
    {

        $data = [

            'titulo' => 'FORMAS DE PAGAMENTOS DO SISTEMA',

        ];

        return view('FormasPagamentos/index', $data);

    }

    // Método: Recupera todas as formas a pagar
    public function recuperaFormas()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $formas = $this->formaPagamentoModel->findAll();

            $data = [];

            foreach($formas as $forma){
                $data[] = [
                    'nome' => anchor("formas/exibir/$forma->id", esc($forma->nome), 'title="Abrir forma a pagar' . esc($forma->nome).'"'),
                    'descricao' => esc($forma->descricao),
                    'criado_em' => esc($forma->criado_em->humanize()),
                    'situacao' => $forma->exibeSituacao(),
                ];
            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }
}
