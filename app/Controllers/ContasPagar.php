<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ContaPagar;
use App\Entities\ContaBancaria;
use App\Entities\Despesa;

class ContasPagar extends BaseController
{
    private $contaPagarModel;
    private $contaBancariaModel;
    private $despesaModel;
    private $tipoDocumentoModel;

    public function __construct()
    {
        $this->contaPagarModel = new \App\Models\ContaPagarModel();
        $this->fornecedorModel = new \App\Models\FornecedorModel();
        $this->contaBancariaModel = new \App\Models\ContaBancariaModel();
        $this->despesaModel = new \App\Models\DespesaModel();
        $this->tipoDocumentoModel = new \App\Models\TipoDocumentoModel();
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
                                        <div class='dropdown-menu'>
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

        $data = [

            'titulo'    => "CONTA A PAGAR" ,
            'conta'     => $conta,

        ];

        // dd($conta);
        return view('ContasPagar/exibir', $data);

        
    }

    public function editar(int $id = null)
    {
        $conta = $this->contaPagarModel->buscaContaOu404($id);
        $despesasAtivas = $this->despesaModel->despesasAtivas(); //Todas as despesas ativas
        $contasBancariasAtivas = $this->contaBancariaModel->contasBancariasAtivas(); //Todas as contas bancárias ativas da empresa
        $tiposDocumentosAtivos = $this->tipoDocumentoModel->tiposDocumentosAtivos(); //Todas as despesas ativas
        $fornecedorDaConta = strtoupper($conta->razao);

        $data = [

            'titulo' => "EDITAR CONTA DO FORNECEDOR - $fornecedorDaConta" ,
            'despesasAtivas' => $despesasAtivas,
            'contasBancariasAtivas' => $contasBancariasAtivas,
            'tiposDocumentosAtivos' => $tiposDocumentosAtivos,
            'conta' => $conta,
            

        ];

        // dd($conta);
        return view('ContasPagar/editar', $data);


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

        $conta = $this->contaPagarModel->buscaContaOu404($post['id']);

        $conta->fill($post);

        if($conta->hasChanged() === false)
        {
            $retorno['info'] = 'Não há dados para atualizar!';
            
            return $this->response->setJSON($retorno);
        }

        // Remover a virgula do valor da conta, para passar pelo form validation
        // Se não remover a virgula aqui, o form_validation(greater_than[0]) diz que valores como 2,100.00 são menores que zero (pois são strig com virgula)
        $conta->valor_conta = str_replace(",", "", $conta->valor_conta);

        //Validação: Se a situação for ABERTA, set a data de pagamento como NULL
        if($conta->situacao == 0)
        {
            $conta->data_pagamento = '';
        }


            if($conta->data_pagamento > date('Y-m-d'))
            {
                $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                $retorno['erros_model'] = ['data_pagamento' => '* A data de pagamento não pode ser superior a Hoje'];                    
                return $this->response->setJSON($retorno);
            }
        }


        if($this->contaPagarModel->save($conta)){

            session()->setFlashdata('sucesso', "Conta atualizada com sucesso!");
            return $this->response->setJSON($retorno);

        }

            //Erros de validação
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = $this->contaPagarModel->errors();

            //Retorno para o AJAX
            return $this->response->setJSON($retorno);

    }
}
