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

<<<<<<< Updated upstream
=======
    // Método: Criar cliente
    public function criar()
    {
        $this->limpaInfoSessao();

       $cliente = new Cliente();

        $data = [

            'titulo' => 'CADASTRAR NOVO CLIENTE',
            'cliente' => $cliente,


        ];

        dd($data['cliente']);

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

            $this->criaUsuarioParaCliente($cliente);

            // $this->enviaEmailCriacaoEmailAcesso($cliente);

            session()->setFlashdata('sucesso_pause', 'Dados salvos com sucesso! <br><br>Importante: Informe ao cliente os dados de acesso ao sistema: <p><b>E-mail: '.$cliente->email.'<p><p>Senha Inicial: obn1234</b></p><p> Geramos um E-mail de notificação com estes dados de acesso para o cliente</b>');

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
>>>>>>> Stashed changes
    public function exibir(int $id = null)
    {

        $cliente = $this->buscaClienteOu404($id);

        $data = [

            'titulo' => 'CLIENTE: '. esc($cliente->nome),
            'cliente' => $cliente,

        ];

        return view('Clientes/exibir', $data);
    }


    public function editar(int $id = null)
    {

        $cliente = $this->buscaClienteOu404($id);

        $data = [

            'titulo' => 'EDITAR CADASTRO DO CLIENTE: '. esc($cliente->nome),
            'cliente' => $cliente,

        ];

        return view('Clientes/editar', $data);
    }

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

    // [id] => 1000
    // [nome] => Yohanna Isis Saito Sobrinho
    // [cpf] => 636.864.108-85
    // [telefone] => (19) 98577-1193
    // [email] => isis31@faro.com
    // [cep] => 11758-528
    // [endereco] => Miranda Prairie
    // [numero] => 734
    // [complemento] => New Fabríciofurt
    // [bairro] => São Rafael
    // [cidade] => Rio de Janeiro
    // [estado] => RJ

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
             
            /**
             * @todo: Enviar um e-mail para o cliente informando acerca da alteração do e-mail de acesso
             * 
             */

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso! <br><br>Importante: Informe ao cliente o novo e-mail de acesso ao sistema: <p> E-mail: '.$cliente->email.'<p> Um e-mail de notificação foi enviado para o cliente');
            return $this->response->setJSON($retorno);

            /**
             * @todo: Tirar o timer dessa mensagem de sucesso (na verdade criar uma mensagem personalizada para este método assim q houver envio de e-mail)
             * 
             */

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

    public function consultaCep()
    {
       if (!$this->request->isAJAX())
       {
            return redirect()->back();
       } 

       $cep = $this->request->getGet('cep');

       return $this->response->setJSON($this->consultaViaCep($cep));

    }



    /*---------- METODOS PRIVADOS ----------*/

    private function buscaClienteOu404(int $id = null)
    {

        if (!$id || !$cliente = $this->clienteModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("cliente não encontrado pelo ID informado");

        }

        return $cliente;

    }
<<<<<<< Updated upstream
=======

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
    private function limpaInfoSessao() : void
    {
        session()->remove('blockCep');
        session()->remove('blockEmail');
    }

    // Método: Criação do usuário do cliente recém cadastrado
    private function criaUsuarioParaCliente(object $cliente) : void
    {
          // Montagem de dados de Usuário do Cliente
          $usuario = [
            'nome'      => $cliente->nome,
            'email'     => $cliente->email,
            'password'  => 'obn1234',
            'ativo'     => true,
        ];

        // Inserção de dados do cliente na tabela de usuário
        $this->usuarioModel->skipValidation(true)->protect(false)->insert($usuario);

        $grupoUsuario = [
            'grupo_id'      => 2, //Grupo 2 foi destinado aos clientes
            'usuario_id'    => $this->usuarioModel->getInsertID(), // Pegar o último ID inserido e atribuindo ao usuario_id
        ];

        // Inserção de dados do usuário/cliente na tabela de grupos usuários
        $this->grupoUsuarioModel->protect(false)->insert($grupoUsuario);

        // Update na tabela usuario_id, com o valor do id do usuário recém criado
        $this->clienteModel->protect(false)
                    ->where('id', $this->clienteModel->getInsertID())
                    ->set('usuario_id', $this->usuarioModel->getInsertID())
                    ->update();

    }
    
>>>>>>> Stashed changes
}
