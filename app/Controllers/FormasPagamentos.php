<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\FormaPagamento;

class FormasPagamentos extends BaseController
{
    private $formaPagamentoModel;


    public function __construct()
    {
        $this->formaPagamentoModel = new \App\Models\FormaPagamentoModel();

    }

    public function index()
    {

        $data = [

            'titulo' => 'FORMAS DE PAGAMENTOS DO SISTEMA',

        ];

        return view('FormasPagamentos/index', $data);

    }

    // Método: Recupera todas as formas a pagar e alimenta o DataTable do index
    public function recuperaFormas()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $formas = $this->formaPagamentoModel->findAll();

            $data = [];

            foreach($formas as $forma){
                $data[] = [
                    'nome' => anchor("formas/exibir/$forma->id", esc($forma->nome), 'title="Abrir forma a pagar' . esc($forma->nome).'"'),
                    'descricao' => esc($forma->descricao),
                    'criado_em' => date('d/m/Y', strtotime($forma->criado_em)),
                    'situacao' => $forma->exibeSituacao(),
                ];
            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    // Método: Rendenrização dos dados da forma de pagamento para exibição na view exibir
    public function exibir(int $id = null)
    {
        $forma = $this->buscaFormaOu404($id);

        $data = [

            'titulo' => 'FORMA DE PAGAMENTO ' . esc($forma->nome),
            'forma' => $forma,

        ];

        return view('FormasPagamentos/exibir', $data);
    }

    // Método: Visualização do form de cadastro de uma nova forma de pagamento
    public function criar()
    {
        $forma = new FormaPagamento();

        $data = [

            'titulo' => 'CRIANDO UMA NOVA FORMA DE PAGAMENTO',
            'forma' => $forma,

        ];

        return view('FormasPagamentos/criar', $data);
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

        // Cria a nova forma de pagamento com os dados do POST
        $forma = new FormaPagamento($post);

        if($this->formaPagamentoModel->protect(false)->save($forma)){
            session()->setFlashdata('sucesso', 'Criado com sucesso.');

            $retorno['id'] = $this->formaPagamentoModel->getInsertID();
            
            return $this->response->setJSON($retorno);
        }

        // Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->formaPagamentoModel->errors();

        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    // Método: Visualização da tela de edição da forma de pagamento
    public function editar(int $id = null)
    {
        $forma = $this->buscaFormaOu404($id);

        if($forma->id < 3)
        {
            return redirect()->to(site_url("formas/exibir/$forma->id"))->with("info", "Esta forma de pagamento não pode ser excluída e nem editada. <br> Em casa de duvidas, entre em contato com o suporte técnico");
        }

        $data = [

            'titulo' => 'EDITANDO A FORMA DE PAGAMENTO ' . esc($forma->nome),
            'forma' => $forma,

        ];

        return view('FormasPagamentos/editar', $data);
    }

    // Método: Atualizar cadastro da forma de pagamento
    public function atualizar()
    {
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }


        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        // Recupero o post da requisição
        $post = $this->request->getPost();

        // Buscar a forma de pagamento por id
        $forma = $this->buscaFormaOu404($post['id']);

        // Defesa: Proibir a atualização da forma de pagamento 1 e 2
        if($forma->id < 3)
        {
            $retorno['erro'] = 'Verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['forma' => "* A forma de pagamento <b class='text-warning'>$forma->nome </b> não pode ser editar ou excluída"];

            return $this->response->setJSON($retorno);
        }

        $forma->fill($post);

        if ($forma->hasChanged() === false)
        {
            $retorno['info'] = 'Não há dados para atualizar';
            return $this->response->setJSON($retorno);
        }

        if($this->formaPagamentoModel->protect(false)->save($forma)){

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
            return $this->response->setJSON($retorno);
        }

        // Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->formaPagamentoModel->errors();

        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

        // Método: Exclusão de forma de pagamento
        public function excluir(int $id = null)
        {
            $forma = $this->buscaFormaOu404($id);
    
            if($forma->id < 3)
            {
                return redirect()->to(site_url("formas/exibir/$forma->id"))->with("atencao", "Esta forma de pagamento não pode ser excluída e nem editada. <br> Em casa de duvidas, entre em contato com o suporte técnico");
            }

            if($this->request->getMethod() === 'post')
            {
                if($forma->id < 3)
                {
                    return redirect()->to(site_url("formas/exibir/$forma->id"))->with("atencao", "Esta forma de pagamento não pode ser excluída e nem editada. <br> Em casa de duvidas, entre em contato com o suporte técnico");
                }

                $this->formaPagamentoModel->delete($forma->id);
                return redirect()->to(site_url("formas"))->with("sucesso", "Forma de pagamento excluída com sucesso");

            }
    
            $data = [
    
                'titulo' => 'EXCLUINDO A FORMA DE PAGAMENTO ' . esc($forma->nome),
                'forma' => $forma,
    
            ];
    
            return view('FormasPagamentos/excluir', $data);
        }

    // Método: Recupera a forma de pagamento
    private function buscaFormaOu404(int $id = null)
    {

        if (!$id || !$forma = $this->formaPagamentoModel->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("forma de pagamento não encontrada");

        }

        return $forma;

    }
}
