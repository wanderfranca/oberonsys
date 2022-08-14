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

        $post = $this->request->getGet();
        $data_inicial = $post['initial_date'];
        $data_final = $post['final_date'];



            $contas = $this->contaPagarModel->recuperaContasPagar($data_inicial, $data_final);

            $data = [];

            foreach($contas as $conta){
                $data[] = [
                    'situacao'      => $conta->exibeSituacao(),
                    'descricao_conta' => anchor("cpagar/exibir/$conta->id", esc($conta->descricao_conta), 'title="Abrir conta a pagar' . esc($conta->descricao_conta).'"'),
                    'razao'         => esc($conta->razao),
                    'valor_conta'   => 'R$ ' .esc(number_format($conta->valor_conta, 2)),
                    // 'tipo_documento_nome' => $conta->tipo_documento_nome,
                    'despesa_nome' => esc($conta->despesa_nome),
                    'data_vencimento' => date('d/m/Y',strtotime($conta->data_vencimento)),
                    // 'banco_finalidade' => $conta->banco_finalidade,
                    'opcoes'        => "<div class='btn-group dropleft'>
                                        <button type='button' class='btn' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        <i class='fa fa-chevron-down text-primary' aria-hidden='true'></i>
                                        </button>
                                        <div class='dropdown-menu bg-white'>
                                            <a class='dropdown-item' href='cpagar/exibir/$conta->id'>Visualizar</a>
                                            <a class='dropdown-item' href='cpagar/editar/$conta->id'>Editar</a>
                                            <a class='dropdown-item' href='cpagar/imprimir/$conta->id'>Imprimir</a>
                                        </div></div></div>",
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            


            return $this->response->setJSON($retorno);

    }

    public function exibir(int $id = null)
    {
        $conta = $this->contaPagarModel->buscaContaOu404($id);
        $fornecedorDaConta = strtoupper($conta->razao);

        $data = [

            'titulo' => "CONTA A PAGAR - $fornecedorDaConta" ,
            'conta' => $conta,

        ];

        // dd($conta);
        return view('ContasPagar/exibir', $data);

        

        return view('Contaspagar/index', $data);

    }
}
