<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Grupo;

class Grupos extends BaseController
{

    private $grupoModel;

    public function __construct(){
        $this->grupoModel = new \App\Models\GrupoModel();
    }

    public function index(){
        $data = [

            'titulo' => 'Grupos de acesso ao sistema',

        ];

        return view('Grupos/index', $data);
    }


    public function recuperaGrupos(){


        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                
                'id',
                'nome',
                'descricao',
                'exibir',
                'deletado_em',
            ];

            // SELECT EM TODOS OS USUÁRIOS
            $grupos = $this->grupoModel->select($atributos)
                                            ->withDeleted(true) //Buscar também os dados deletados
                                            ->orderBy('id', 'DESC')
                                            ->findAll();


            //Receberá o array de objetos de usuários
            $data = [];

            foreach($grupos as $grupo){

                $data[] = [

                    'nome'      => anchor("grupos/exibir/$grupo->id", esc($grupo->nome), 'title="Exibir grupo '.esc($grupo->nome).'"'),
                    'descricao'     => esc($grupo->descricao),
                    'exibir'     => $grupo->exibeSituacao(),
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    public function criar(){


        $grupo = new Grupo();

        $data = [

            'titulo' => "Criar novo grupo de acesso: ",
            'grupo' => $grupo,

        ];

        return view('Grupos/criar', $data);

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
        $grupo = new Grupo($post);

        if($this->grupoModel->save($grupo)){

            $btnCriar = anchor("Grupos/criar", 'Cadastrar novo grupo de acesso', ['class'=> 'btn btn-primary mt-2']);

            session()->setFlashdata('sucesso', "Dados salvos com sucesso <br> $btnCriar");

            // Retornar o último ID Inserido na tabela
            $retorno['id'] = $this->grupoModel->getInsertId();

            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->grupoModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }  

    public function exibir(int $id = null){


        $grupo = $this->buscaGrupoOu404($id);

        // dd($grupo);

        $data = [

            'titulo' => "Grupo de acesso: ".esc($grupo->nome),
            'grupo' => $grupo,

        ];

        return view('Grupos/exibir', $data);

    }

    public function editar(int $id = null){


        $grupo = $this->buscaGrupoOu404($id);

        if($grupo->id < 3){

            return redirect()
                            ->back()
                            ->with('error', "O grupo <b>".esc($grupo->nome). " </b> não pode ser editado ou excluído, pois trata-se de um grupo de controle interno");
        }

        $data = [

            'titulo' => "Editar o grupo de acesso: ".esc($grupo->nome),
            'grupo' => $grupo,

        ];

        return view('Grupos/editar', $data);

    }

    public function atualizar(){

        if(!$this->request->isAJAX()){
            return redirect()->back();
        }


        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição
        $post = $this->request->getPost();


        //Validamos a existência do Grupo
        $grupo = $this->buscaGrupoOu404($post['id']);


        // GRUPO 1 E 2 (ADMIN E CLIENTES) NÃO PODEM SER EDITADOS 
        if($grupo->id < 3){

            $retorno['erro'] = 'Não é possível editar esse grupo';
            $retorno['erros_model'] = ['grupo' => "O grupo <b class='text-white-50'>".esc($grupo->nome). " </b> não pode ser editado ou excluído, pois trata-se de um grupo de controle interno" ];
            return $this->response->setJSON($retorno);
        }

        
        //Preenchemos os atributos do grupo com os valores do POST
        $grupo->fill($post);
        
        if($grupo->hasChanged() == false){

            $retorno['info'] = 'Não há dados para serem atualizados';
            return $this->response->setJSON($retorno);

        }

        if($this->grupoModel->protect(false)->save($grupo)){

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

            //
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->grupoModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    public function excluir(int $id = null){


        $grupo = $this->buscaGrupoOu404($id);

        if($grupo->id < 3){

            return redirect()
                            ->back()
                            ->with('error', "O grupo <b>".esc($grupo->nome). " </b> não pode ser editado ou excluído, pois trata-se de um grupo de controle interno");
        }

        if($grupo->deletado_em != null ){

            return redirect()->back()->with('info', "Esse grupo já foi excluído");

        }

        if($this->request->getMethod() === 'post'){

            // Exclui o grupo
            $this->grupoModel->delete($grupo->id);

            return redirect()->to(site_url("grupos"))->with('sucesso', 'Grupo <b> '.esc($grupo->nome).' </b> removido com sucesso!');

        }

        $data = [

            'titulo' => "Excluir o grupo: ".esc($grupo->nome),
            'grupo' => $grupo,

        ];

        return view('Grupos/excluir', $data);


    }

    public function desfazerExclusao(int $id = null){

        $grupo = $this->buscaGrupoOu404($id);

        if($grupo->deletado_em == null){

            return redirect()->back()->with('info', "Apenas grupos excluídos podem ser recuperados");
        }

        $grupo->deletado_em = null;
        $this->grupoModel->protect(false)->save($grupo);

        
        return redirect()->back()->with('sucesso', 'Grupo ' .esc($grupo->nome).' recuperado com sucesso!');

    }

    public function permissoes(int $id = null){


        $grupo = $this->buscaGrupoOu404($id);

        // Grupo administrador
        if($grupo->id < 1){

            return redirect()
                            ->back()
                            ->with('info', "Não é necessário atribuir ou remover permissões de acesso para o grupo <b>".esc($grupo->nome). " </b>, pois esse grupo é Super Elevado");
        }

        // Grupo de Clientes
        if($grupo->id < 2){

            return redirect()
                            ->back()
                            ->with('info', "Não é necessário atribuir ou remover permissões de acesso para o grupo <b>".esc($grupo->nome). " </b>, pois esse grupo é controlado automaticamente pelo sistema");
        }

        

        
        $data = [
            'titulo' => "Gerenciar as permissões do grupo acesso: ".esc($grupo->nome),
            'grupo' => $grupo,

        ];

        return view('Grupos/permissoes', $data);

    }

    /**
     * Método que recupera o Grupo de acesso
     * 
     * @param integer $id
     * @return Exceptions|object
     */

    private function buscaGrupoOu404(int $id = null){

        if (!$id || !$grupo = $this->grupoModel->withDeleted(true)->find($id)){

            throw\CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("A Oberon não encontrou o grupo de acesso $id");

        }

        return $grupo;

    }
}
