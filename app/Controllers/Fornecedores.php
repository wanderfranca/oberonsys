<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Traits\ValidacoesTrait;
use App\Entities\Fornecedor;

class Fornecedores extends BaseController
{

    use ValidacoesTrait;

    private $fornecedorModel;

    public function __construct()
    {
        $this->fornecedorModel = new \App\Models\FornecedorModel();
    }

    public function index()
    {
        $data = [

            'titulo' => 'Fornecedores',

        ];

        return view('Fornecedores/index', $data);
    }

    public function criar()
    {


        $fornecedor = new Fornecedor();

        $data = [

            'titulo' => "Cadastrar novo fornecedor ",
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/criar', $data);


    }

    public function cadastrar()
    {
      
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        if(session()->get('blockCep') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['cep' => 'Informe um CEP válido'];
            
            return $this->response->setJSON($retorno);
        }
        
        // Recupero o post da requisição
        $post = $this->request->getPost();  

        $fornecedor = new Fornecedor($post);

        if($this->fornecedorModel->save($fornecedor)){

            $btnCriar = anchor("Fornecedores/criar", 'Cadastrar mais fornecedores', ['class' => 'btn btn-primary mt2']);
            session()->setFlashdata('sucesso', "Novo fornecedor cadastrado! <br> $btnCriar");

            $retorno['id'] = $this->fornecedorModel->getInsertID();

            //Retornar para o Json
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->fornecedorModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    public function recuperaFornecedores()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                
                'id',
                'razao',
                'cnpj',
                'telefone',
                'ativo',
                'deletado_em',
            ];

            // SELECT EM TODOS OS FornecedorS
            $fornecedores = $this->fornecedorModel->select($atributos)
                                                ->withDeleted(true) //Buscar também os dados deletados
                                                ->orderBy('id', 'DESC')
                                                ->findAll();


            //Receberá o array de objetos de fornecedores
            $data = [];

            foreach($fornecedores as $fornecedor){


                $data[] = [

                    'razao'         => anchor("fornecedores/exibir/$fornecedor->id", esc($fornecedor->razao), 'title="Exibir Fornecedor '.esc($fornecedor->razao).'"'),
                    'cnpj'          => esc($fornecedor->cnpj),
                    'telefone'      => esc($fornecedor->telefone),
                    'ativo'         => $fornecedor->exibeSituacao(),
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    public function exibir(int $id = null)
    {


        $fornecedor = $this->buscaFornecedorOu404($id);

        // dd($fornecedor);

        $data = [

            'titulo' => "Perfil do fornecedor: ".esc($fornecedor->nome),
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/exibir', $data);


    }

    public function editar(int $id = null)
    {
        $fornecedor = $this->buscaFornecedorOu404($id);

        // dd($fornecedor);

        $data = [

            'titulo' => "Editar fornecedor: ".esc($fornecedor->razao),
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/editar', $data);
    }

    public function atualizar()
    {
      
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        if(session()->get('blockCep') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['cep' => 'Informe um CEP válido'];
            
            return $this->response->setJSON($retorno);
        }
        
        // Recupero o post da requisição
        $post = $this->request->getPost();  

        $fornecedor = $this->buscaFornecedorOu404($post['id']);

        $fornecedor->fill($post);

        if($fornecedor->hasChanged() === false)
        {

            $retorno['info'] = 'Não há dados para atualizar!';

            return $this->response->setJSON($retorno);

        }

        if($this->fornecedorModel->save($fornecedor)){

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

            //
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->fornecedorModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    public function excluir(int $id = null)
    {

        $fornecedor = $this->buscaFornecedorOu404($id);

        if($fornecedor->deletado_em != null)
        {
            return redirect()->back()->with('info', "O fornecedor $fornecedor->razao Já está excluído");
        }

        if($this->request->getMethod() === 'post')
        {
            $this->fornecedorModel->delete($id);

            return redirect()->to(site_url("fornecedores"))->with('sucesso', "$fornecedor->razao foi excluído com sucesso");
        }

        $data = [

            'titulo' => "Excluir fornecedor: ".esc($fornecedor->razao),
            'fornecedor' => $fornecedor,

        ];


        return view('Fornecedores/excluir', $data);

    }

    public function desfazerExclusao(int $id = null)
    {


        $fornecedor = $this->buscaFornecedorOu404($id);

        if($fornecedor->deletado_em == null){

            return redirect()->back()->with('info', "Apenas usuários excluídos podem ser recuperados");

        }

        $fornecedor->deletado_em = null;
        $this->fornecedorModel->protect(false)->save($fornecedor);

        
        return redirect()->back()->with('sucesso', "$fornecedor->razao restaurado com sucesso. Fornecedores restaurados a sua base de dados voltam com status inativo, você pode alterar isso quando quiser =D");

    }

    /**
     * Função: consultaCep
     * getGet (Pega o CEP e passa para a func consultaViaCep)
     * Retornando um Json
     * O tratamento está em Traits/Validacoes
     * 
     */
    public function consultaCep()
    {
       if (!$this->request->isAJAX())
       {
            return redirect()->back();
       } 

       
       $cep = $this->request->getGet('cep');

       return $this->response->setJSON($this->consultaViaCep($cep));






    }

    /**
     * Método: que recupera o Fornecedor
     * 
     * @param integer $id
     * @return Exceptions|object
     */

    private function buscaFornecedorOu404(int $id = null)
    {

        if (!$id || !$fornecedor = $this->fornecedorModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Fornecedor não encontrado pelo ID informado");

        }

        return $fornecedor;

    }
}
