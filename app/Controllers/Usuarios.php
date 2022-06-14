<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\usuario;

class Usuarios extends BaseController
{
    private $usuarioModel;
    public function __construct() 
    
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }


    public function index()
    {
        $data = [

            'titulo' => 'Usuários do sistema',

        ];

        return view('Usuarios/index', $data);
    }


    public function recuperaUsuarios(){


        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            
            $atributos = [
                
                'id',
                'nome',
                'email',
                'ativo',
                'imagem',

            ];

            $usuarios = $this->usuarioModel->select($atributos)
                                            ->orderBy('id', 'DESC')
                                            ->findAll();


            //Receberá o array de objetos de usuários
            $data = [];

            foreach($usuarios as $usuario){

                $nomeUsuario = esc($usuario->nome);


                $data[] = [

                    'imagem' => $usuario->imagem,
                    'nome' => anchor("usuarios/exibir/$usuario->id", esc($usuario->nome), 'title="Exibir usuário '.$nomeUsuario.'"'),
                    'email' => esc($usuario->email),
                    'ativo' => ($usuario->ativo == true ? '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo' : '<i class="fa fa-lock text-danger"></i>&nbsp;Inativo'),

                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    public function criar(){

        $usuario = new Usuario();

        // dd($usuario);

        $data = [

            'titulo' => "Novo usuário ",
            'usuario' => $usuario,

        ];

        return view('Usuarios/criar', $data);

    }

    public function cadastrar(){

        if(!$this->request->isAJAX()){
            return redirect()->back();
        }


        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição
        $post = $this->request->getPost();

        // Crio novo objeto da entidade Usuário
        $usuario = new Usuario($post);


        if($this->usuarioModel->protect(false)->save($usuario)){

            $btnCriar = anchor("usuarios/criar", 'Cadastrar novo usuário', ['class'=> 'btn btn-primary mt-2']);

            session()->setFlashdata('sucesso', "Dados salvos com sucesso <br> $btnCriar");

            // Retornar o último ID Inserido na tabela
            $retorno['id'] = $this->usuarioModel->getInsertId();

            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->usuarioModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }  

    public function exibir(int $id = null){


        $usuario = $this->buscaUsuarioOu404($id);

        // dd($usuario);

        $data = [

            'titulo' => "Perfil do usuário: ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        return view('Usuarios/exibir', $data);


    }

    public function editar(int $id = null){


        $usuario = $this->buscaUsuarioOu404($id);

          $data = [

            'titulo' => "Editando o usuário ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        return view('Usuarios/editar', $data);

    }

    public function atualizar(){

        if(!$this->request->isAJAX()){
            return redirect()->back();
        }


        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição
        $post = $this->request->getPost();


        //Validamos a existência do ususário
        $usuario = $this->buscaUsuarioOu404($post['id']);

        
        // Se não foi informada a senha, então removemos a captura desse dado do post
        if(empty($post['password'])){
            unset($post['password']);
            unset($post['password_confirmation']);
        }

        //Preenchemos os atributos do usuário com os valores do POST
        $usuario->fill($post);
        
        if($usuario->hasChanged() == false){

            $retorno['info'] = 'Não há dados para serem atualizados';
            return $this->response->setJSON($retorno);

        }

        if($this->usuarioModel->protect(false)->save($usuario)){

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

            //
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->usuarioModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }


    public function editarImagem(int $id = null){


        $usuario = $this->buscaUsuarioOu404($id);

          $data = [

            'titulo' => "Alterar imagem do usuário ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        return view('Usuarios/editar_imagem', $data);

    }

    public function upload(){

        if(!$this->request->isAJAX()){
            return redirect()->back();
        }


        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();



        





        // Recupero o post da requisição
        $post = $this->request->getPost();


        //Validamos a existência do ususário
        $usuario = $this->buscaUsuarioOu404($post['id']);

        
        // Se não foi informada a senha, então removemos a captura desse dado do post
        if(empty($post['password'])){
            unset($post['password']);
            unset($post['password_confirmation']);
        }

        //Preenchemos os atributos do usuário com os valores do POST
        $usuario->fill($post);
        
        if($usuario->hasChanged() == false){

            $retorno['info'] = 'Não há dados para serem atualizados';
            return $this->response->setJSON($retorno);

        }

        if($this->usuarioModel->protect(false)->save($usuario)){

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

            //
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->usuarioModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    /**
     * Método que recupera o usuário
     * 
     * @param integer $id
     * @return Exceptions|object
     */

    private function buscaUsuarioOu404(int $id = null){

        if (!$id || !$usuario = $this->usuarioModel->withDeleted(true)->find($id)){

            throw\CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("A Oberon não encontrou o usuário desejado $id");

        }

        return $usuario;

    }

}
