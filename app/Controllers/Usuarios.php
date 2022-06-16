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
                                            ->withDeleted(true)
                                            ->orderBy('id', 'DESC')
                                            ->findAll();


            //Receberá o array de objetos de usuários
            $data = [];

            foreach($usuarios as $usuario){

                $nomeUsuario = esc($usuario->nome);

                //Caminho da imagem do usuário
                if($usuario->imagem != null){

                    $imagem = [
                        'src' => site_url("usuarios/imagem/$usuario->imagem"),
                        'class' => 'rounded-circle img-fluid',
                        'alt' => esc($usuario->nome),
                        'width'=> '50',
                    ];


                } else {

                    $imagem = [
                        'src' => site_url("recursos/img/usuario_sem_imagem.png"),
                        'class' => 'rounded-circle img-fluid',
                        'alt' => '',
                        'width'=> '50',

                    ];
                }


                $data[] = [

                    'imagem' => $usuario->imagem = img($imagem),
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

        $validacao = service('validation');

        $regras = [
            'imagem' => 'uploaded[imagem]|max_size[imagem,2048]|ext_in[imagem,png,jpg,jpeg,webp,gif]',
        ];

        $mensagens = [//Errors
            'imagem' => [
                'uploaded' => 'Por favor, escolha uma imagem',
                'ext_in' => 'Por favor, escolha uma imagem png, jpg, jpeg, webp ou gif',
                'max_size' => 'Tamanho Máx permitido é 2048kb',
            ],
        ];

        $validacao->setRules($regras, $mensagens);

        if($validacao->withRequest($this->request)->run() == false){
        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $validacao->getErrors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);

        }

        
        // Recupero o post da requisição
        $post = $this->request->getPost();


        //Validamos a existência do ususário
        $usuario = $this->buscaUsuarioOu404($post['id']);

        // Recuperar a imagem que veio no post
        $imagem = $this->request->getFile('imagem');

        list($largura, $altura) = getimagesize($imagem->getPathname());

        if($largura < "300" || $altura < "300" ){

            $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['dimensao' => 'A imagem não pode ser menor do que 300 x 300 pixels'];

        }

            // LOCAL DE ARMAZENAMENTO DA IMAGEM - STORE
        $caminhoImagem = $imagem->store('usuarios');

        // C:\xampp\htdocs\oberonsys\writable\uploads/usuarios/$imagem
        $caminhoImagem = WRITEPATH . "uploads/$caminhoImagem";

        // MANIPULAÇÃO DE IMAGEM
        $this->manipulaImagem($caminhoImagem, $usuario->id);

        
        //Atualizar a tabela de usuário no banco de dados

        $imagemAntiga = $usuario->imagem; // Recuperar a possível imagem antiga

        $usuario->imagem = $imagem->getName();

        $this->usuarioModel->save($usuario);


        if($imagemAntiga != null){
            $this->removeImagemDoFileSystem($imagemAntiga);

        }


        session()->setFlashdata('sucesso', 'Imagem atualizada com suceso!');




        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    public function imagem(string $imagem = null){

        if($imagem != null){

            $this->exibeArquivo('usuarios', $imagem);

        }

    }

    public function excluir(int $id = null){


        $usuario = $this->buscaUsuarioOu404($id);

        if($this->request->getMethod() === 'post'){

            $this->usuarioModel->delete($usuario->id);

            if($usuario->imagem != null){

                $this->removeImagemDoFileSystem($usuario->imagem);

            }

            $usuario->imagem = null;
            $usuario->ativo = false;
            $this->usuarioModel->protect(false)->save($usuario);

            return redirect()->to(site_url("usuarios"))->with('sucesso', "Usuário $usuario->nome removido com sucesso!");

        }

        $data = [

            'titulo' => "Excluir usuário: ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        return view('Usuarios/excluir', $data);


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

    private function removeImagemDoFileSystem(string $imagem){

        $caminhoImagem = WRITEPATH . "uploads/usuarios/$imagem";

        if(is_file($caminhoImagem)){

            unlink($caminhoImagem);

        }

    }

    private function manipulaImagem(string $caminhoImagem, int $usuario_id){
        
        //Redimensionar a imagem 300 x 300 para ficar no centro
        service('image')
        ->withFile($caminhoImagem)
        ->fit(300, 300, 'center')
        ->save($caminhoImagem);


        $anoAtual = date('Y');
        
        // Adicionar uma marca d'água de texto
        \Config\Services::image('imagick')
            ->withFile($caminhoImagem)
            ->text("Oberon $anoAtual - User-ID $usuario_id", 
            [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => false,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 10,
            ])
            ->save($caminhoImagem);
    }

}
