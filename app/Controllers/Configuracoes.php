<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Configuracao;
use App\Models\ConfiguracaoModel;

class Configuracoes extends BaseController
{
    
    private $configuracaoModel;

    public function __construct()
    {
       $this->configuracaoModel = new \App\Models\ConfiguracaoModel();

    }

    public function index()
    {
        $configuracao = $this->buscaConfiguracaoOu404(1);

        
        $data = [
            'titulo' => 'Configurações Gerais',
            'configs' => $configuracao,
        ];

        return view("Configuracoes/index", $data);

    }

    private function buscaConfiguracaoOu404(int $id = null)
    {
        
        $id = 1;

        if (!$id || !$configuracao = $this->configuracaoModel->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Empresa não encontrada pelo ID informado");

        }

        return $configuracao;

    }
}
