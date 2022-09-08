<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Ordem;
use App\Traits\OrdemTrait;

class Ordens extends BaseController
{
    use OrdemTrait;
    
    private $ordemModel;
    private $transacaoModel;

    public function __construct()
    {
        $this->ordemModel = new \App\Models\OrdemModel();
        $this->transacaoModel = new \App\Models\TransacaoModel();
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
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);
        
        //OrdemTrait com a unserialize dos itens ou NULL
        $this->preparaItensDaOrdem($ordem);

        //Verificar se possui transação
        $transacao = $this->transacaoModel->where('ordem_id', $ordem->id)->first();

        // Se a OS possui uma transação por boleto
        if($transacao !== null)
        {
            $ordem->transacao = $transacao;
        }

        $data = [
            'titulo' => "DETALHES DA OS - $ordem->codigo",
            'ordem' => $ordem,
        ];

        return view('Ordens/detalhes', $data);
    }

    // Método: Recuperar detalhes da OS
    public function editar(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);
        

        if($ordem->situacao === 'encerrada')
        {
            return redirect()->back()->with("info", "Esta O.S não pode ser editada, pois está " . ucfirst($ordem->situaca));
        }


        $data = [
            'titulo' => "EDITAR O.S - $ordem->codigo",
            'ordem' => $ordem,
        ];

        return view('Ordens/editar', $data);
    }

       

        
}
