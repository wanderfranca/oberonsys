<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ContaBancaria;
use App\Models\ContaBancariaModel;
use App\Models\InstituicoesBancariasModel;

class ContasBancarias extends BaseController
{
    private $contaBancariaModel;
    private $insituicoesBancariaModel;


    public function __construct()
    {
        $this->contaBancariaModel = new \App\Models\ContaBancariaModel();
        $this->insituicoesBancariaModel = new \App\Models\InstituicoesBancariasModel();  
    }

    public function index()
    {
        $data = [

            'titulo' => 'CONTAS BANCÁRIAS',

        ];

        return view('Contasbancarias/index', $data);    
    }

    public function recuperacontas()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                'fin_instituicoes_bancarias.instituicao_bancaria_nome AS instituicao_nome',
                'fin_contas_bancarias.id AS conta_id',
                'banco_id',
                'banco_agencia',
                'banco_conta',
                'banco_tipo',
                'banco_pix1',
                'banco_pix2',
                'ativo',
                'fin_contas_bancarias.criado_em AS banco_criado_em',
                // 'atualizado_em',

            ];

            // SELECT EM TODAS AS CATEGPROAS
            $contasbancarias = $this->contaBancariaModel
                                                ->select($atributos)
                                                ->join('fin_instituicoes_bancarias', 'banco_id = fin_instituicoes_bancarias.id')
                                                ->orderBy('fin_instituicoes_bancarias.id', 'DESC')
                                                ->findAll();

            //Receberá o array de objetos de contasbancarias
            $data = [];

            foreach($contasbancarias as $contabancaria){

                $data[] = [

                    'instituicao_nome'    => anchor("contasbancarias/editar/$contabancaria->id", esc($contabancaria->instituicao_nome), 'title="Exibir Conta Bancária '.esc($contabancaria->instituicao_nome).'"'),
                    'banco_agencia'       => esc($contabancaria->banco_agencia),
                    'banco_conta'         => esc($contabancaria->banco_conta),
                    'banco_tipo'          => esc($contabancaria->banco_tipo),
                    'banco_pix1'          => esc($contabancaria->banco_pix1),
                    'banco_pix2'          => esc($contabancaria->banco_pix2),
                    'ativo'               => esc($contabancaria->ativo == 1 ? 'Ativo' : 'Inativo' ), 
                ];

            }

            $retorno = [

                'data' => $data,

            ];


            return $this->response->setJSON($retorno);

    }

    public function criar()
    {
        $contabancaria = new ContaBancaria();
        $bancos = $this->insituicoesBancariaModel->bancosAll();

        $data = [
            'titulo' => 'CADASTAR NOVA CONTA BANCÁRIA',
            'contabancaria' => $contabancaria,
            'bancos' => $bancos,

        ];

        // echo '<pre>';
        // print_r($data);
        // exit;

        return view('Contasbancarias/criar', $data);

    }

    public function cadastrar()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

         // Envio o hash do token do form
         $retorno['token'] = csrf_hash();

         // Recupero o post da requisição AJAX
         $post = $this->request->getPost();  
 
          // Salvando a nova Categoria no Banco de Dados
         $contabancaria = new ContaBancaria($post);

         echo '<pre>';
         print_r($post);
         exit;

         if($this->contaBancariaModel->save($contabancaria)){

            $btnCriar = anchor("Contasbancarias/criar", 'Cadastrar mais contas', ['class' => 'btn btn-primary mt2']);
            session()->setFlashdata('sucesso', "Nova conta cadastrada e pronta para ser utilizada em suas movimentações.<br> $btnCriar");

            $retorno['id'] = $this->contaBancariaModel->getInsertID();

            //Retornar para o Json
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->categoriaModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);

    }
}
