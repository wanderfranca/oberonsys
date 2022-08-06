<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Despesa;

class Despesas extends BaseController
{

    private $despesaModel;


    public function __construct()
    {
        $this->despesaModel = new \App\Models\DespesaModel();
    }


    public function index()
    {
        $data = [

            'titulo' => 'despesas',

        ];

        return view('despesas/index', $data);
    }
    
    public function recuperadespesas()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                'id',
                'despesa_nome',
                'despesa_descricao',

            ];

            // SELECT EM TODAS AS CATEGPROAS
            $despesas = $this->despesaModel->select($atributos)
                                                ->orderBy('id', 'DESC')
                                                ->findAll();

            //Receberá o array de objetos de despesas
            $data = [];

            foreach($despesas as $despesa){


                $data[] = [

                    'despesa_nome'          => anchor("despesas/editar/$despesa->id", esc($despesa->despesa_nome), 'title="Exibir despesa '.esc($despesa->despesa_nome).'"'),
                    'despesa_descricao'     => esc($despesa->despesa_descricao),
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }


    // Método: Criar nova despesa
    public function criar()
    {
        
        $despesa = new Despesa();

        $data = [

            'titulo' => "CADASTRAR DESPESA",
            'despesa' => $despesa,

        ];

        return view('despesas/criar', $data);

    }

    public function cadastrar()
    {
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição AJAX
        $post = $this->request->getPost();  

         // Salvando a nova despesa no Banco de Dados
        $despesa = new Despesa($post);

   
        if($this->despesaModel->save($despesa)){

            $btnCriar = anchor("despesas/criar", 'Cadastrar mais despesas', ['class' => 'btn btn-primary mt2']);
            session()->setFlashdata('sucesso', "Nova despesa cadastrada e pronta para ser utilizada em suas contas.<br> $btnCriar");

            $retorno['id'] = $this->despesaModel->getInsertID();

            //Retornar para o Json
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->despesaModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);

    }

    public function editar(int $id = null)
    {

        $despesa = $this->buscadespesaOu404($id);

        $data = [

            'titulo' => "EDITAR DESPESA: $despesa->despesa_nome",
            'despesa' => $despesa,

        ];

        return view('despesas/editar',$data);

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

          $despesa = $this->buscaDespesaOu404($post['id']);
  
          $despesa->fill($post);
  
          if($despesa->hasChanged() === false)
          {
  
              $retorno['info'] = 'Não há dados para atualizar!';
  
              return $this->response->setJSON($retorno);
  
          }
  
          if($this->despesaModel->save($despesa)){
  
              session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
  
              //
              return $this->response->setJSON($retorno);
  
          }
  
          //Retornar os erros de validação do formulário
          $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
          $retorno['erros_model'] = $this->despesaModel->errors();
  
  
          // Retorno para o ajax request
          return $this->response->setJSON($retorno);

    }

    public function excluir(int $id = null)
    {

        $despesa = $this->buscadespesaOu404($id);

        if($despesa->deletado_em != null)
        {
            return redirect()->back()->with('info', "A despesa $despesa->despesa_nome Já está excluída");
        }

        if($this->request->getMethod() === 'post')
        {
            $this->despesaModel->delete($id);

            return redirect()->to(site_url("despesas"))->with('sucesso', "$despesa->despesa_nome foi excluído com sucesso");
        }

        $data = [

            'titulo' => "EXCLUIR DESPESA: ".esc($despesa->despesa_nome),
            'despesa' => $despesa,

        ];


        return view('despesaes/excluir', $data);

    }

    public function buscaDespesaOu404(int $id = null)
    {
        if (!$id || !$despesa = $this->despesaModel->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("despesa não encontrada pelo Código informado");

        }

        return $despesa;
    }
}
