<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ContaBancaria;
use App\Models\ContaBancariaModel;
use App\Models\InstituicoesBancariasModel;

class ContasBancarias extends BaseController
{
    private $contaBancariaModel;


    public function __construct()
    {
        $this->contaBancariaModel = new \App\Models\ContaBancariaModel();
        $this->instituicoesBancariaModel = new \App\Models\InstituicoesBancariasModel();  
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

                    'instituicao_nome'    => anchor("contasbancarias/editar/$contabancaria->conta_id", esc($contabancaria->instituicao_nome), 'title="Exibir Conta Bancária '.esc($contabancaria->instituicao_nome).'"'),
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
        $bancos = $this->instituicoesBancariaModel->bancosAll();

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
 
          // Salvando a nova contabancaria no Banco de Dados
         $contabancaria = new ContaBancaria($post);

        //  echo '<pre>';
        //  print_r($post);
        //  exit;

         if($this->contaBancariaModel->save($contabancaria)){

            $btnCriar = anchor("Contasbancarias/criar", 'Cadastrar mais contas', ['class' => 'btn btn-primary mt2']);
            session()->setFlashdata('sucesso', "Nova conta cadastrada e pronta para ser utilizada em suas movimentações.<br> $btnCriar");

            $retorno['id'] = $this->contaBancariaModel->getInsertID();

            //Retornar para o Json
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->contaBancariaModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);

    }

    public function editar(int $id = null)
    {

        $contabancaria = $this->buscaContaBancariaOu404($id);
        $bancos = $this->instituicoesBancariaModel->bancosAll();


        $data = [

            'titulo' => "EDITAR CONTA BANCÁRIA",
            'contabancaria' => $contabancaria,
            'bancos' => $bancos,

        ];

        return view('contasbancarias/editar',$data);

    }

    public function atualizar()
    {

        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

          // Recupero o post da requisição AJAX
          $post = $this->request->getPost();  

          $contabancaria = $this->buscaContaBancariaOu404($post['id']);
  
          $contabancaria->fill($post);
  
          if($contabancaria->hasChanged() === false)
          {
  
              $retorno['info'] = 'Não há dados para atualizar!';
  
              return $this->response->setJSON($retorno);
  
          }
  
          if($this->contaBancariaModel->save($contabancaria)){
  
              session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
  
              //
              return $this->response->setJSON($retorno);
  
          }
  
          //Retornar os erros de validação do formulário
          $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
          $retorno['erros_model'] = $this->contaBancariaModel->errors();
  
  
          // Retorno para o ajax request
          return $this->response->setJSON($retorno);

    }

    public function excluir(int $id = null)
    {

        $contabancaria = $this->buscaContaBancariaOu404($id);

        if($contabancaria->deletado_em != null)
        {
            return redirect()->back()->with('info', "esta conta bancária já está excluída");
        }

        if($this->request->getMethod() === 'post')
        {
            $this->contaBancariaModel->delete($id);

            return redirect()->to(site_url("contasbancarias"))->with('sucesso', "Conta foi excluída com sucesso");
        }

        $data = [

            'titulo' => "EXCLUIR CONTA BANCÁRIA",
            'contabancaria' => $contabancaria,

        ];


        return view('contasbancarias/excluir', $data);

    }

    public function buscaContaBancariaOu404(int $id = null)
    {
        if (!$id || !$contabancaria = $this->contaBancariaModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Conta bancária não encontrada pelo Código informado");

        }

        return $contabancaria;
    }
}
