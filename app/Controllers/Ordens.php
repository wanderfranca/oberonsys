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
    private $clienteModel;
    private $ordemResponsavelModel;

    public function __construct()
    {
        $this->ordemModel = new \App\Models\OrdemModel();
        $this->transacaoModel = new \App\Models\TransacaoModel();
        $this->clienteModel = new \App\Models\ClienteModel();
        $this->ordemResponsavelModel = new \App\Models\OrdemResponsavelModel();
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

    public function criar()
    {

        $ordem = new Ordem();

        $ordem->codigo = $this->ordemModel->geraCodigoOrdem();

        $data = [
            'titulo' => 'ABRIR UMA NOVA O.S',
            'ordem' => $ordem,
        ];

        return view('Ordens/criar', $data);
    }

    public function cadastrar()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        //Hash do token do form
        $retorno['token'] = csrf_hash();

        // Recuperar o post vindo do formulário
        $post = $this->request->getPost();


        // Preencher o objeto CENTRAL com os dados que vêm do post
        $ordem = new Ordem($post);

        if($this->ordemModel->save($ordem))
        {
            //finalizaCadastroDaOrdem
            $this->inicializaOrdem($ordem);

            session()->setFlashdata('sucesso', 'O.S aberta com sucesso!');

            $retorno['codigo'] = $ordem->codigo;

            return $this->response->setJSON($retorno);
        }

        $retorno['erro'] = 'Por favor verifique os erros abaixo';
        $retorno['erros_model'] = $this->ordemModel->errors();

        return $this->response->setJSON($retorno);
      
    }

    /**
     * Método: Busca Clientes via selectize utilizando Ajax Request
     * Com este método, evitamos de carregar todos os clientes no módulo
     * @return response
     */
    public function buscaClientes()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        $atributos = [
            'id',
            'CONCAT(nome, " - CPF: ", cpf) AS nome',
            'cpf',
        ];

        $termo = $this->request->getGet('termo');

        $clientes = $this->clienteModel->select($atributos)
                                              ->asArray()
                                              ->like('nome', $termo)
                                              ->orLike('cpf', $termo)
                                              ->orderby('nome', 'ASC')
                                              ->findAll();
    
        return $this->response->setJSON($clientes);
                                                

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
            'titulo' => "EDITAR ORDEM - $ordem->codigo",
            'ordem' => $ordem,
        ];

        return view('Ordens/editar', $data);
    }

    public function atualizar()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        //Hash do token do form
        $retorno['token'] = csrf_hash();

        // Recuperar o post vindo do formulário
        $post = $this->request->getPost();

        // Buscar a ordem pelo código e popular a variável
        $ordem = $this->ordemModel->buscaOrdemOu404($post['codigo']);

        if($ordem->situacao === 'encerrada')
        {
            $retorno['erro'] = 'Por favor verifique os erros abaixo';
            $retorno['erros_model'] = ["situacao" => "Esta ordem não pode ser editada, pois encontra-se ".ucfirst($ordem->situacao)];
            return $this->response->setJSON($retorno);
        }

        
        // Preencher o objeto CENTRAL com os dados que vêm do post
        $ordem->fill($post);

        // Verificar se houve mudança nos dados DB X POST
        if($ordem->hasChanged() === false)
        {
            $retorno['info'] = 'Não há dados para atualizar';
            return $this->response->setJSON($retorno);
        }  

        if($this->ordemModel->save($ordem))
        {
            session()->setFlashdata('sucesso', 'Dados atualizados com sucesso!');

            return $this->response->setJSON($retorno);
        }

        $retorno['erro'] = 'Por favor verifique os erros abaixo';
        $retorno['erros_model'] = $this->ordemModel->errors();

        return $this->response->setJSON($retorno);
    
 
    }
    
    private function inicializaOrdem(object $ordem) : void
    {
        $ordemAbertura = [
            'ordem_id' => $this->ordemModel->getInsertID(), //Ultimo id inserido
            'usuario_abertura_id' => usuario_logado()->id
        ];

        // Inserir na tabela de responsáveis
        $this->ordemResponsavelModel->insert($ordemAbertura);
        
        // Recuperar cliente
        $ordem->cliente = $this->clienteModel->select('nome, email')->find($ordem->cliente_id);

        /**
         * @todo: Enviar e-mail para o cliente com a OS recém criada
         */
    }
        
}
