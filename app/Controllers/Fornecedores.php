<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Traits\ValidacoesTrait;
use App\Entities\Fornecedor;

class Fornecedores extends BaseController
{

    use ValidacoesTrait;

    private $fornecedorModel;
    private $fornecedorNotaFiscalModel;

    public function __construct()
    {
        $this->fornecedorModel = new \App\Models\FornecedorModel();
        $this->fornecedorNotaFiscalModel = new \App\Models\FornecedorNotaFiscalModel();
    }

    public function index()
    {
        $data = [

            'titulo' => 'Fornecedores',

        ];

        return view('Fornecedores/index', $data);
    }

    public function recuperaFornecedores()
    {

        if(!$this->request->isAJAX()){
            
            return redirect()->back();
        }

            $atributos = [
                
                'id',
                'razao',
                'cnpj',
                'telefone',
                'ativo',
                'deletado_em',
            ];

            // SELECT EM TODOS OS FornecedorS
            $fornecedores = $this->fornecedorModel->select($atributos)
                                                ->withDeleted(true) //Buscar também os dados deletados
                                                ->orderBy('id', 'DESC')
                                                ->findAll();


            //Receberá o array de objetos de fornecedores
            $data = [];

            foreach($fornecedores as $fornecedor){


                $data[] = [

                    'razao'         => anchor("fornecedores/exibir/$fornecedor->id", esc($fornecedor->razao), 'title="Exibir Fornecedor '.esc($fornecedor->razao).'"'),
                    'cnpj'          => esc($fornecedor->cnpj),
                    'telefone'      => esc($fornecedor->telefone),
                    'ativo'         => $fornecedor->exibeSituacao(),
                ];

            }

            $retorno = [

                'data' => $data,

            ];

            return $this->response->setJSON($retorno);

    }

    public function criar()
    {


        $fornecedor = new Fornecedor();

        $data = [

            'titulo' => "Cadastrar novo fornecedor ",
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/criar', $data);


    }

    public function cadastrar()
    {
      
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        if(session()->get('blockCep') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['cep' => 'Informe um CEP válido'];
            
            return $this->response->setJSON($retorno);
        }
        
        // Recupero o post da requisição
        $post = $this->request->getPost();  

        $fornecedor = new Fornecedor($post);

        if($this->fornecedorModel->save($fornecedor)){

            $btnCriar = anchor("Fornecedores/criar", 'Cadastrar mais fornecedores', ['class' => 'btn btn-primary mt2']);
            session()->setFlashdata('sucesso', "Novo fornecedor cadastrado! <br> $btnCriar");

            $retorno['id'] = $this->fornecedorModel->getInsertID();

            //Retornar para o Json
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->fornecedorModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    public function exibir(int $id = null)
    {


        $fornecedor = $this->buscaFornecedorOu404($id);

        // dd($fornecedor);

        $data = [

            'titulo' => "Perfil do fornecedor: ".esc($fornecedor->nome),
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/exibir', $data);


    }

    public function editar(int $id = null)
    {
        $fornecedor = $this->buscaFornecedorOu404($id);

        // dd($fornecedor);

        $data = [

            'titulo' => "Editar fornecedor: ".esc($fornecedor->razao),
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/editar', $data);
    }

    public function atualizar()
    {
      
        if(!$this->request->isAJAX()){
            return redirect()->back();
        }

        // Envio o hash do token do form
        $retorno['token'] = csrf_hash();

        if(session()->get('blockCep') === true)
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['cep' => 'Informe um CEP válido'];
            
            return $this->response->setJSON($retorno);
        }
        
        // Recupero o post da requisição
        $post = $this->request->getPost();  

        $fornecedor = $this->buscaFornecedorOu404($post['id']);

        $fornecedor->fill($post);

        if($fornecedor->hasChanged() === false)
        {

            $retorno['info'] = 'Não há dados para atualizar!';

            return $this->response->setJSON($retorno);

        }

        if($this->fornecedorModel->save($fornecedor)){

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

            //
            return $this->response->setJSON($retorno);

        }

        //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->fornecedorModel->errors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);


    }

    public function excluir(int $id = null)
    {

        $fornecedor = $this->buscaFornecedorOu404($id);

        if($fornecedor->deletado_em != null)
        {
            return redirect()->back()->with('info', "O fornecedor $fornecedor->razao Já está excluído");
        }

        if($this->request->getMethod() === 'post')
        {
            $this->fornecedorModel->delete($id);

            return redirect()->to(site_url("fornecedores"))->with('sucesso', "$fornecedor->razao foi excluído com sucesso");
        }

        $data = [

            'titulo' => "EXCLUIR O FORNECEDOR: ".esc($fornecedor->razao),
            'fornecedor' => $fornecedor,

        ];


        return view('Fornecedores/excluir', $data);

    }

    public function desfazerExclusao(int $id = null)
    {


        $fornecedor = $this->buscaFornecedorOu404($id);

        if($fornecedor->deletado_em == null){

            return redirect()->back()->with('info', "Apenas fornecedores excluídos podem ser recuperados");

        }

        $fornecedor->deletado_em = null;
        $this->fornecedorModel->protect(false)->save($fornecedor);

        
        return redirect()->back()->with('sucesso', "$fornecedor->razao restaurado com sucesso. Fornecedores restaurados a sua base de dados voltam com status inativo, você pode alterar isso quando quiser =D");

    }


    public function notas(int $id = null)
    {


        $fornecedor = $this->buscaFornecedorOu404($id);

        $fornecedor->notas_fiscais = $this->fornecedorNotaFiscalModel->where('fornecedor_id', $fornecedor->id)->paginate(10);
        

        if($fornecedor->notas_fiscais !=null)
        {
            $fornecedor->pager = $this->fornecedorNotaFiscalModel->pager;
        }

        $data = [

            'titulo' => "Notas Fiscais do Fornecedor: ".esc($fornecedor->razao),
            'fornecedor' => $fornecedor,

        ];

        return view('Fornecedores/notas_fiscais', $data);


    }

    public function cadastrarNotaFiscal()
    {
        if (!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        $post = $this->request->getPost();

        // [id] => 2003
        // [valor_nota] => 
        // [data_emissao] => 
        // [descricao_itens] => 

        $valorNota = str_replace([',', '.'], '', $post['valor_nota']);

        if($valorNota < 1)
        {
            $retorno['erro'] = 'Varifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['valor_nota' => 'O valor da nota deve ser maior que zero'];
            return $this->response->setJSON($retorno);

        }

        $validacao = service('validation');

        $regras = [
            'valor_nota' => 'required',
            'data_emissao' => 'required',
            // 'descricao_itens' => 'required',
            'nota_fiscal' => 'uploaded[nota_fiscal]|max_size[nota_fiscal,5120]|ext_in[nota_fiscal,pdf,xml]',
        ];

        $mensagens = [//Errors
            'nota_fiscal'   => [
                'uploaded'  => '* Apenas PDF para Danfe ou XML',
                'ext_in'    => '* Por favor, escolha um arquivo PDF ou XML',
                'max_size'  => '* Tamanho Máx permitido é 5Mb',
            ],


            'data_emissao' => [
                'required' => '* Informe o dia que a nota foi emitida',

            ],
        ];

        $validacao->setRules($regras, $mensagens);

        // Validação: Se estiver fora das regras
        if($validacao->withRequest($this->request)->run() === false){
        
            //Retornar os erros de validação do formulário
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $validacao->getErrors();


        // Retorno para o ajax request
        return $this->response->setJSON($retorno);

        }

        // Recuperar o fonecedor

        $fornecedor = $this->buscaFornecedorOu404($post['id']);

        // Recuperar o arquivo (FILE) da NF
        $notaFiscal = $this->request->getFile('nota_fiscal');

        // Onde está o PDF
        $notaFiscal->store('fornecedores/notas_fiscais');



        // Montage do Array de inserção de Nota Fiscal de Fornecedor
        $nota = [

            'fornecedor_id'     => $fornecedor->id,
            'nota_fiscal'       => $notaFiscal->getName(),
            'descricao_itens'   => $post['descricao_itens'],
            'valor_nota'        => str_replace(',','', $post['valor_nota']),
            'data_emissao'      => $post['data_emissao']

        ];


        $this->fornecedorNotaFiscalModel->insert($nota);

        session()->setFlashdata('sucesso', 'Nota fiscal cadastrada na base de dados do sistema');

        return $this->response->setJSON($retorno);

    }

    public function exibirNota(string $nota = null)
    {
        if($nota === null)
        {
            return redirect()->to(site_url("fornecedores"));
        }

        $this->exibeArquivo('fornecedores/notas_fiscais', $nota);

    }

    public function removeNota(string $nota_fiscal = null)
    {

        if($this->request->getMethod() === 'post')
        {
            $objNota = $this->buscaNotaFiscalOu404($nota_fiscal);

            // Remover nota fiscal - delete na tabela
            $this->fornecedorNotaFiscalModel->delete($objNota->id);

            // Remover arquivo
            $caminhoNotaFiscal = WRITEPATH . "uploads/fornecedores/notas_fiscais/$nota_fiscal";

            if(is_file($caminhoNotaFiscal))
            {
                unlink($caminhoNotaFiscal);
            }

            return redirect()->back()->with("sucesso", "Nota fiscal removida com sucesso!");

            
        }

        return redirect()->back();

    }

    /**
     * Função: consultaCep
     * getGet (Pega o CEP e passa para a func consultaViaCep)
     * Retornando um Json
     * O tratamento está em Traits/Validacoes
     * 
     */
    public function consultaCep()
    {
       if (!$this->request->isAJAX())
       {
            return redirect()->back();
       } 

       
       $cep = $this->request->getGet('cep');

       return $this->response->setJSON($this->consultaViaCep($cep));






    }

    /**
     * Método: que recupera o Fornecedor
     * 
     * @param integer $id
     * @return Exceptions|object
     */

    private function buscaFornecedorOu404(int $id = null)
    {

        if (!$id || !$fornecedor = $this->fornecedorModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Fornecedor não encontrado pelo ID informado");

        }

        return $fornecedor;

    }

    //Método: Recuperar Nota Fiscal do Fornecedor
    private function buscaNotaFiscalOu404(string $nota_fiscal = null)
    {

        if (!$nota_fiscal || !$objNota = $this->fornecedorNotaFiscalModel->where('nota_fiscal', $nota_fiscal)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Nota Fiscal não encontrada");

        }

        return $objNota;

    }
}
