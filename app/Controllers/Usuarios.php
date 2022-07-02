<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\usuario;

class Usuarios extends BaseController
{
    private $usuarioModel;
    private $grupoUsuarioModel;
    private $grupoModel;

    public function __construct() 
    
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
        $this->grupoUsuarioModel = new \App\Models\GrupoUsuarioModel();
        $this->grupoModel = new \App\Models\GrupoModel();
    }


    public function index()
    {
        $data = [

            'titulo' => 'Usuários do sistema',

        ];

        return view('Usuarios/index', $data);
    }

    public function recuperaUsuarios()
    {


        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                
                'id',
                'nome',
                'email',
                'ativo',
                'imagem',
                'deletado_em',
            ];

            // SELECT EM TODOS OS USUÁRIOS
            $usuarios = $this->usuarioModel->select($atributos)
                                            ->withDeleted(true) //Buscar também os dados deletados
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

                    'imagem'    => $usuario->imagem = img($imagem),
                    'nome'      => anchor("usuarios/exibir/$usuario->id", esc($usuario->nome), 'title="Exibir usuário '.$nomeUsuario.'"'),
                    'email'     => esc($usuario->email),
                    'ativo'     => $usuario->exibeSituacao(),
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    public function criar()
    {

        $usuario = new Usuario();

        // dd($usuario);

        $data = [

            'titulo' => "Novo usuário ",
            'usuario' => $usuario,

        ];

        return view('Usuarios/criar', $data);

    }

    public function cadastrar()
    {

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

    public function exibir(int $id = null)
    {


        $usuario = $this->buscaUsuarioOu404($id);

        // dd($usuario);

        $data = [

            'titulo' => "Perfil do usuário: ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        return view('Usuarios/exibir', $data);


    }

    public function editar(int $id = null)
    {


        $usuario = $this->buscaUsuarioOu404($id);

          $data = [

            'titulo' => "Editando o usuário ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        return view('Usuarios/editar', $data);

    }

    public function atualizar()
    {

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

    public function editarImagem(int $id = null)
    {


        $usuario = $this->buscaUsuarioOu404($id);

          $data = [

            'titulo' => "Alterar imagem do usuário ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        return view('Usuarios/editar_imagem', $data);

    }

    public function upload()
    {

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

    public function imagem(string $imagem = null)
    {

        if($imagem != null){

            $this->exibeArquivo('usuarios', $imagem);

        }

    }

    public function excluir(int $id = null)
    {


        $usuario = $this->buscaUsuarioOu404($id);

        if($usuario->deletado_em != null ){

            return redirect()->back()->with('info', "Esse usuário já foi excluído");

        }

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

    public function desfazerExclusao(int $id = null)
    {


        $usuario = $this->buscaUsuarioOu404($id);

        if($usuario->deletado_em == null){

            return redirect()->back()->with('info', "Apenas usuários excluídos podem ser recuperados");

        }

        $usuario->deletado_em = null;
        $this->usuarioModel->protect(false)->save($usuario);

        
        return redirect()->back()->with('sucesso', "$usuario->nome restaurado com sucesso. Usuários restaurados voltam com status inativo, você pode alterar isso quando quiser =D");

    }

    public function grupos(int $id = null)
    {

        //Buscar usuário pelo id
        $usuario = $this->buscaUsuarioOu404($id);

        //Pegar o usuário e recuperar o grupo que o mesmo pertence, 5 itens na lista para paginação
        $usuario->grupos = $this->grupoUsuarioModel->recuperaGruposDoUsuario($usuario->id, 5);
        $usuario->pager = $this->grupoUsuarioModel->pager;

        $data = [

            'titulo' => "Grenciar grupos de acesso do usuário: ".esc($usuario->nome),
            'usuario' => $usuario,

        ];

        /**
         * Verificar se é um cliente
         * Caso seja um cliente: retornar para view de exibição de usuário
         * Mensagem: Não é possível esse usuário a outros grupos ou removê-los pois trata-se de um cliente
         */
        $grupoCliente = 2;
        if(in_array($grupoCliente, array_column($usuario->grupos, 'grupo_id'))){
            return redirect()->to(site_url("usuarios/exibir/$usuario->id"))
                            ->with('info', 'Não é possível esse usuário a outros grupos ou removê-los pois trata-se de um cliente');

        }

        /**
         * Verificar se é um administrador
         * Caso seja um admin: retornar para view de Usuarios/grupos
         * Mensagem: Não é possível esse usuário a outros grupos ou removê-los pois trata-se de um cliente
         */
        $grupoAdmin = 1;
        if(in_array($grupoAdmin, array_column($usuario->grupos, 'grupo_id'))){
            $usuario->full_control = true;
            return view('Usuarios/grupos', $data);

        }

        $usuario->full_control = false;
        
        /**
         * Verificar se o usuário está em algum grupo
         * capturar no array_column o(s) grupo(s) que o usuário está e colocar na variável $gruposExistentes
         * Criar um array temporário "gruposDisponiveis" e dentro dele capturar todos os grupos exceto o 2 (clientes) e os $gruposExistentes
         */

        if(!empty($usuario->grupos)){

            $gruposExistentes = array_column($usuario->grupos, 'grupo_id');
            $data['gruposDisponiveis'] = $this->grupoModel
                                                ->where('id !=', 2)
                                                ->whereNotIn('id', $gruposExistentes)
                                                ->findAll();


        }else {
            //Recuperar todos os grupos, com exceção do grupo ID 2 que é o grupo de clientes
            $data['gruposDisponiveis'] = $this->grupoModel
                                                ->where('id !=', 2)
                                                ->findAll();
        }

        return view('Usuarios/grupos', $data);

    }

    public function salvarGrupos()
    {

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição
        $post = $this->request->getPost();


        //Validamos a existência do ususário
        $usuario = $this->buscaUsuarioOu404($post['id']);

            if(empty($post['grupo_id'])){
            
                //Retornar os erros de validação do formulário
                $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                $retorno['erros_model'] = ['grupo_id' => 'Escolha um ou mais grupos para salvar'];


                // Retorno para o ajax request
                return $this->response->setJSON($retorno);

            }

            if(in_array(2, $post['grupo_id'])){

                //Retornar os erros de validação do formulário
                $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
                $retorno['erros_model'] = ['grupo_id' => 'O grupo de clientes não pode ser atribuído desta forma'];


                // Retorno para o ajax request
                return $this->response->setJSON($retorno);

            }

            // Se o usuário escolher o grupo Administrador, então ignorar outros grupos e add somente o admin
            if(in_array(1, $post['grupo_id'])){

                $grupoAdmin = [
                    'grupo_id' => 1,
                    'usuario_id'=> $usuario->id
                ];

                // ADD o usuário APENAS no grupo Admin
                $this->grupoUsuarioModel->insert($grupoAdmin);
                
                // Depois de inserir no grupo ADMIN -> Remova de todos os grupos diferentes do grupo de ADMIN
                $this->grupoUsuarioModel->where('grupo_id !=', 1)
                                        ->where('usuario_id', $usuario->id)
                                        ->delete();

                session()->setFlashdata('sucesso', 'Dados salvos com sucesso!');
                session()->setFlashdata('info', 'Percebi que o grupo ADMINISTRADORES foi escolhido, portanto, não há necessidade de escolher outros grupos, pois os administradores já possuem acesso total ao sistema');

                return $this->response->setJSON($retorno);


            }

        // Receber as permissões do POST
            $grupoPush = [];

            foreach($post['grupo_id'] as $grupo){

                array_push($grupoPush, [

                    'grupo_id' => $grupo,
                    'usuario_id'=> $usuario->id

                ]);

            }


            $this->grupoUsuarioModel->insertBatch($grupoPush);

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
            return $this->response->setJSON($retorno);


    }

    public function removegrupo(int $principal_id = null)
    {

        if($this->request->getMethod() === 'post'){

            $grupoUsuario = $this->buscaGrupoUsuarioOu404($principal_id);

            if($grupoUsuario->grupo_id == 2){

                return redirect()->to(site_url("usuarios/exibir/$grupoUsuario->usuario_id"))->with("info", "Não é permitida a exclusão do grupo de clientes, pois trata-se de um grupo de controle interno");

            }

            $this->grupoUsuarioModel->delete($principal_id);
            return redirect()->back()->with("sucesso", "Usuário removido do grupo de acesso com sucesso!");

        }

        return redirect()->back();

    }

    /**
     * Método que recupera o usuário
     * 
     * @param integer $id
     * @return Exceptions|object
     */

    private function buscaUsuarioOu404(int $id = null)
    {

        if (!$id || !$usuario = $this->usuarioModel->withDeleted(true)->find($id)){

            throw\CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("A Oberon não encontrou o usuário desejado $id");

        }

        return $usuario;

    }

    
    private function buscaGrupoUsuarioOu404(int $principal_id = null)
    {

        if (!$principal_id || !$grupoUsuario = $this->grupoUsuarioModel->find($principal_id)){

            throw\CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o registro desejado $principal_id");

        }

        return $grupoUsuario;

    }

    private function removeImagemDoFileSystem(string $imagem)
    {

        $caminhoImagem = WRITEPATH . "uploads/usuarios/$imagem";

        if(is_file($caminhoImagem)){

            unlink($caminhoImagem);

        }

    }

    private function manipulaImagem(string $caminhoImagem, int $usuario_id)
    {
        
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
