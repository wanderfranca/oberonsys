<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Ordem;
use App\Traits\OrdemTrait;

class Ordens extends BaseController
{
    use OrdemTrait;
    
    private $ordemModel;

    public function __construct()
    {
        $this->ordemModel = new \App\Models\OrdemModel();
    }
    public function index()
    {
        $data = [
            'titulo' => 'ORDENS DE SERVIÇO',
        ];

        return view('Ordens/index', $data);
    }

        // Método: Recuperar Todas as OS
        public function recuperaOrdens()
        {
    
            if(!$this->request->isAJAX()){
                
                return redirect()->back();
            }
    
    
                // SELECT EM TODOS OS ordens
                $ordens = $this->ordemModel->recuperaOrdens();
    
    
                //Receberá o array de objetos de ordens
                $data = [];
    
                foreach($ordens as $ordem){
    
                    $data[] = [
    
                        'codigo'         => anchor("ordens/detalhes/$ordem->codigo", esc($ordem->codigo), 'title="Exibir ordem '.esc($ordem->codigo).'"'),
                        'nome'          => esc($ordem->nome),
                        'cpf'        => esc($ordem->cpf),
                        'criado_em'     => esc(date('d/m/Y', strtotime($ordem->criado_em))),
                        'situacao'     => $ordem->exibeSituacao(),
                    ];
    
                }
    
                $retorno = [
    
                    'data' => $data,
    
                ];
    
                return $this->response->setJSON($retorno);
    
        }

        // Método: Recuperar detalhes da OS
        public function detalhes(string $codigo = null)
        {
            
        }
}
