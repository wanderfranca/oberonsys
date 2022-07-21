<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Traits\ValidacoesTrait;
use App\Entities\Cliente;

class Clientes extends BaseController
{

    use ValidacoesTrait;

    private $clienteModel;
    private $usuarioModel;
    private $grupoUsuarioModel;

    public function __construct()
    {
        $this->clienteModel = new \App\Models\ClienteModel();
        $this->usuarioModel = new \App\Models\UsuarioModel();
        $this->grupoUsuarioModel = new \App\Models\GrupoUsuarioModel();
    }

    public function index()
    {
        $data = [

            'titulo' => 'CLIENTES',

        ];

        return view('Clientes/index', $data);
    }

    // Método: Recuperar clientes ativos, inativos e deletados
    public function recuperaClientes()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                
                'id',
                'nome',
                'cpf',
                'email',
                'telefone',
                'deletado_em',
            ];

            // SELECT EM TODOS OS FornecedorS
            $clientes = $this->clienteModel->select($atributos)
                                                ->withDeleted(true) //Buscar também os dados deletados
                                                ->orderBy('id', 'DESC')
                                                ->findAll();


            //Receberá o array de objetos de clientes
            $data = [];

            foreach($clientes as $cliente){


                $data[] = [

                    'nome'         => anchor("clientes/exibir/$cliente->id", esc($cliente->nome), 'title="Exibir cliente '.esc($cliente->nome).'"'),
                    'cpf'          => esc($cliente->cpf),
                    'email'        => esc($cliente->email),
                    'telefone'     => esc($cliente->telefone),
                    'situacao'     => $cliente->exibeSituacao(),
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    // Método: Criar cliente
    public function criar()
    {
        $this->limpaInfoSessao();

        $cliente = new Cliente();

        $data = [

            'titulo' => 'CADASTRAR NOVO CLIENTE',
            'cliente' => $cliente,

        ];

        return view('Clientes/criar', $data);
    }

    // Método: Cadastrar cliente
    public function cadastrar(int $id = null)
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();
  

        // Verificação: Email inválido
        if(session()->get('blockEmail') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['email' => 'Informe um E-mail válido'];
            
            return $this->response->setJSON($retorno);
        }

        // Verificação: Cep inválido
        if(session()->get('blockCep') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['cep' => 'Informe um CEP válido'];
            
            return $this->response->setJSON($retorno);
        }

        // Recupero o post da requisição
        $post = $this->request->getPost();

        $client = new Cliente($post);


        if($this->clienteModel->save($cliente)){

            $this->enviaEmailCriacaoEmailAcesso($cliente);

            /**
             * @todo - criar usuário do cliente
             */
            session()->setFlashdata('sucesso_pause', 'Dados salvos com sucesso! <br><br>Importante: Informe ao cliente o novo e-mail de acesso ao sistema: <p> E-mail: '.$cliente->email.'<p> Um e-mail de notificação foi enviado para o cliente');


            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->clienteModel->errors();

        // Retorno para o ajax request
        return $this->response->setJSON($retorno);



        return view('Clientes/editar', $data);
    }

    // Método: Exibir cliente
    public function exibir(int $id = null)
    {

        $cliente = $this->buscaClienteOu404($id);

        $data = [

            'titulo' => 'CLIENTE: '. esc($cliente->nome),
            'cliente' => $cliente,

        ];

        return view('Clientes/exibir', $data);
    }

    // Método: Editar cliente
    public function editar(int $id = null)
    {

        $cliente = $this->buscaClienteOu404($id);

        $this->limpaInfoSessao();

        $data = [

            'titulo' => 'EDITAR CADASTRO DO CLIENTE: '. esc($cliente->nome),
            'cliente' => $cliente,

        ];

        return view('Clientes/editar', $data);
    }

    // Método: Atualizar cliente
    public function atualizar(int $id = null)
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição
        $post = $this->request->getPost();

        $cliente = $this->buscaClienteOu404($post['id']);


        // Verificação: Email inválido
        if(session()->get('blockEmail') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['email' => 'Informe um E-mail válido'];
            
            return $this->response->setJSON($retorno);
        }

        // Verificação: Cep inválido
        if(session()->get('blockCep') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['cep' => 'Informe um CEP válido'];
            
            return $this->response->setJSON($retorno);
        }

        $cliente->fill($post);

        if($cliente->hasChanged() === false)
        {

            $retorno['info'] = 'Não há dados para atualizar!';

            return $this->response->setJSON($retorno);

        }

        if($this->clienteModel->save($cliente)){

            // Condição: Se houver modificação no E-mail
            if($cliente->hasChanged('email'))
            {
                $this->usuarioModel->atualizaEmailDoCliente($cliente->usuario_id, $cliente->email);
             
                $this->enviaEmailAlteracaoEmailAcesso($cliente);

            session()->setFlashdata('sucesso_pause', 'Dados salvos com sucesso! <br><br>Importante: Informe ao cliente o novo e-mail de acesso ao sistema: <p> E-mail: '.$cliente->email.'<p> Um e-mail de notificação foi enviado para o cliente');
            return $this->response->setJSON($retorno);

            }

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->clienteModel->errors();

        // Retorno para o ajax request
        return $this->response->setJSON($retorno);



        return view('Clientes/editar', $data);
    }

    // Método consultaCep
    public function consultaCep()
    {
        if (!$this->request->isAJAX())
        {
                return redirect()->back();
        } 

        $cep = $this->request->getGet('cep');

        return $this->response->setJSON($this->consultaViaCep($cep));

    }

    // Método consultaCep
    public function consultaEmail()
    {
        if (!$this->request->isAJAX())
        {
            return redirect()->back();
        } 

        $email = $this->request->getGet('email');

        return $this->response->setJSON($this->checkEmail($email));

    }

    /*---------- METODOS PRIVADOS ----------*/


    // Método buscaClienteOu404: buscar cliente
    private function buscaClienteOu404(int $id = null)
    {

        if (!$id || !$cliente = $this->clienteModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("cliente não encontrado pelo ID informado");

        }

        return $cliente;

    }

    // Método enviaEmailAlteracaoEmailAcesso: E-mail para o cliente informando alterações de acesso
    private function enviaEmailAlteracaoEmailAcesso(object $cliente) : void
    {

        $email = service('email');
        
        $email->setFrom('no-replay@oberonsys.com', 'Oberon Sistema');
        $email->setTo($cliente->email);
        $email->setSubject('Novo e-mail de acesso ao sistema');

        $data = [
                    'cliente' => $cliente,
            
                ];

        $mensagem = view('Clientes/email_acesso_alterado', $data);

        $email->setMessage($mensagem);
        $email->send();

    }

    // Remove da sessão as informações que travam formulário em requisições
    public function limpaInfoSessao() : void
    {
        session()->remove('blockCep');
        session()->remove('blockEmail');
    }

    
}