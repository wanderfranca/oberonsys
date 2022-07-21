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
}
