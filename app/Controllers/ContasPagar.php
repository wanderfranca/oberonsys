<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ContaPagar;
use App\Entities\ContaBancaria;

class ContasPagar extends BaseController
{
    private $contaPagarModel;
    private $fornecedorModel;
    private $contaBancariaModel;

    public function __construct()
    {
        $this->contaPagarModel = new \App\Models\ContaPagarModel();
        $this->fornecedorModel = new \App\Models\FornecedorModel();
        $this->contaBancariaModel = new \App\Models\ContaBancariaModel();
    }

    public function index()
    {

        $data = [

            'titulo' => 'CONTAS A PAGAR',

        ];

        

        return view('Contaspagar/index', $data);

    }

    // Método: Recupera todas as contas a pagar
    public function recuperaContasPagar()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $contas = $this->contaPagarModel->recuperaContasPagar();

            $data = [];

            foreach($contas as $conta){
                $data[] = [
                    'descricao_conta' => anchor("contasPagar/exibir/$conta->id", esc($conta->descricao_conta), 'title="Abrir conta a pagar' . esc($conta->descricao_conta).'"'),
                    'razao'         => anchor("ContasPagar/exibir/$conta->id", esc($conta->razao), 'title="Exibir a conta '.esc($conta->razao).'"'),
                    'valor_conta'   => 'R$ ' .esc($conta->valor_conta),
                    'situacao'      => $conta->exibeSituacao(),
                    'tipo_documento_nome' => $conta->tipo_documento_nome,
                ];

            }

            $retorno = [

                'data' => $data,

            ];


            return $this->response->setJSON($retorno);

    }
}
