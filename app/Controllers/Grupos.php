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

    public function exibir(int $id = null){


        $grupo = $this->buscaGrupoOu404($id);

        // dd($grupo);

        $data = [

            'titulo' => "Grupo de acesso: ".esc($grupo->nome),
            'grupo' => $grupo,

        ];

        return view('Grupos/exibir', $data);

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
