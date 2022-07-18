<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Categoria;

class Categorias extends BaseController
{

    private $categoriaModel;


    public function __construct()
    {
        $this->categoriaModel = new \App\Models\CategoriaModel();
    }


    public function index()
    {
        $data = [

            'titulo' => 'Categorias',

        ];

        return view('categorias/index', $data);
    }
    
    public function recuperaCategorias()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                'id',
                'nome',
                'descricao',
                'ativo',
                'criado_em',
                // 'atualizado_em',

            ];

            // SELECT EM TODAS AS CATEGPROAS
            $categorias = $this->categoriaModel->select($atributos)
                                                ->orderBy('id', 'DESC')
                                                ->findAll();

            //Receberá o array de objetos de categorias
            $data = [];

            foreach($categorias as $categoria){


                $data[] = [

                    'nome'          => anchor("categorias/editar/$categoria->id", esc($categoria->nome), 'title="Exibir categoria '.esc($categoria->nome).'"'),
                    'descricao'     => esc($categoria->descricao),
                    'ativo'         => esc($categoria->ativo == 1 ? 'Ativo' : 'Inativo' ), 
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }


    // Método: Criar nova categoria
    public function criar()
    {
        
        $categoria = new Categoria();

        $data = [

            'titulo' => "Cadastrar nova categoria",
            'categoria' => $categoria,

        ];

        return view('Categorias/criar', $data);

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

         // Salvando a nova Categoria no Banco de Dados
        $categoria = new Categoria($post);

   
        if($this->categoriaModel->save($categoria)){

            $btnCriar = anchor("categorias/criar", 'Cadastrar mais categorias', ['class' => 'btn btn-primary mt2']);
            session()->setFlashdata('sucesso', "Nova categoria cadastrada e pronta para ser utilizada em seus produtos.<br> $btnCriar");

            $retorno['id'] = $this->categoriaModel->getInsertID();

            //Retornar para o Json
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->categoriaModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);

    }

    public function editar(int $id = null)
    {

        $categoria = $this->buscaCategoriaOu404($id);

        $data = [

            'titulo' => "Editar categoria: $categoria->nome",
            'categoria' => $categoria,

        ];

        return view('Categorias/editar',$data);

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

          $categoria = $this->buscaCategoriaOu404($post['id']);
  
          $categoria->fill($post);
  
          if($categoria->hasChanged() === false)
          {
  
              $retorno['info'] = 'Não há dados para atualizar!';
  
              return $this->response->setJSON($retorno);
  
          }
  
          if($this->categoriaModel->save($categoria)){
  
              session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
  
              //
              return $this->response->setJSON($retorno);
  
          }
  
          //Retornar os erros de validação do formulário
          $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
          $retorno['erros_model'] = $this->categoriaModel->errors();
  
  
          // Retorno para o ajax request
          return $this->response->setJSON($retorno);

    }

    public function excluir(int $id = null)
    {

        $categoria = $this->buscaCategoriaOu404($id);

        if($categoria->deletado_em != null)
        {
            return redirect()->back()->with('info', "A categoria $categoria->nome Já está excluída");
        }

        if($this->request->getMethod() === 'post')
        {
            $this->categoriaModel->delete($id);

            return redirect()->to(site_url("categoria"))->with('sucesso', "$categoria->nome foi excluído com sucesso");
        }

        $data = [

            'titulo' => "Excluir categoria: ".esc($categoria->nome),
            'categoria' => $categoria,

        ];


        return view('categoriaes/excluir', $data);

    }

    public function buscaCategoriaOu404(int $id = null)
    {
        if (!$id || !$categoria = $this->categoriaModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("categoria não encontrado pelo Código informado");

        }

        return $categoria;
    }
}
