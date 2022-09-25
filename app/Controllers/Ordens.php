<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Ordem;
use App\Traits\OrdemTrait;
use Dompdf\Dompdf;

class Ordens extends BaseController
{
    use OrdemTrait;
    
    private $ordemModel;
    private $transacaoModel;
    private $clienteModel;
    private $ordemResponsavelModel;
    private $usuarioModel;

    public function __construct()
    {
        $this->ordemModel = new \App\Models\OrdemModel();
        $this->transacaoModel = new \App\Models\TransacaoModel();
        $this->clienteModel = new \App\Models\ClienteModel();
        $this->ordemResponsavelModel = new \App\Models\OrdemResponsavelModel();
        $this->usuarioModel = new \App\Models\UsuarioModel();
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

    // Método: Cadastrar nova ordem de serviço
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
            'titulo' => "Editar ordem de serviço TAG: $ordem->codigo",
            'ordem' => $ordem,
        ];

        return view('Ordens/editar', $data);
    }

    // Método: Atualizar OS
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

             // Verificação: Se na sessão houver 'ordem-encerrar'
             if(session()->has('ordem-encerrar'))
             {   
                session()->setFlashdata('sucesso', 'Agora já é possível encerrar esta Ordem de Serviço');              
                 $retorno['redirect'] = "ordens/encerrar/$ordem->codigo";
                 return $this->response->setJSON($retorno);
             }

            session()->setFlashdata('sucesso', 'Dados atualizados com sucesso!');

            return $this->response->setJSON($retorno);
        }

        $retorno['erro'] = 'Por favor verifique os erros abaixo';
        $retorno['erros_model'] = $this->ordemModel->errors();

        return $this->response->setJSON($retorno);
    
 
    }

    // Método: Recuperar Excluir Ordem de Serviço
    public function excluir(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);


        // Ordem já excluída
        if($ordem->deletado_em != null)
        {
            return redirect()->back()->with('info', "A ordem $ordem->codigo Já encontra-se excluída");
        }

        // Situações que serão permitidas para exclusão
        $situacoesPermitidas = [

            'encerrada',
            'cancelada'
        ];

        // Bloqueador de situações
        if(!in_array($ordem->situacao, $situacoesPermitidas))
        {
            return redirect()->back()->with('info', "Apenas ordens encerradas ou canceladas podem ser excluídas");
        }

        if($this->request->getMethod() === 'post')
        {
            $this->ordemModel->delete($ordem->id);

            return redirect()->to(site_url('ordens'))->with('sucesso', "Ordem de serviço $ordem->codigo excluída com sucesso");

        }
       
        $data = [
            'titulo' => "Excluindo a Ordem de Serviço: $ordem->codigo",
            'ordem' => $ordem,
        ];

        return view('Ordens/excluir', $data);
    }

    // Método: Recuperar detalhes da OS
    public function responsavel(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);
        

        if($ordem->situacao === 'encerrada')
        {
            return redirect()->back()->with("info", "Esta O.S não pode ser editada, pois está " . ucfirst($ordem->situaca));
        }


        $data = [
            'titulo' => "Definindo o responsável técnico - TAG: $ordem->codigo",
            'ordem' => $ordem,
        ];

        return view('Ordens/responsavel', $data);
    }

    // Método: Buscar os responsáveis da OS usando termo
    public function buscaResponsaveis()
    {

        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        
        $termo = $this->request->getGet('termo');

        $responsaveis = $this->usuarioModel->recuperaResponsaveisParaOrdem($termo);

        return $this->response->setJSON($responsaveis);
    }

    public function definirResponsavel()
    {
        if(!$this->request->isAJAX())
        {
            return redirect()->back();
        }

        // Enviar o token do Form
        $retorno['token'] = csrf_hash();

        $validacao = service('validation');

        $regras = [
            'usuario_responsavel_id' => 'required|greater_than[0]',
        ];

        $mensagens = [//Errors
            'usuario_responsavel_id' => [
                'required' => 'Pesquise e insira um responsável técnico',
                'greater_than' => 'Você precisa informar um técnico responsável',
            ],
        ];

        $validacao->setRules($regras, $mensagens);

        if($validacao->withRequest($this->request)->run() === false){
        
            // Retorno de validações
        $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $validacao->getErrors();

            return $this->response->setJSON($retorno);

        }

        $post = $this->request->getPost();

        //Validação: Existência da Ordem
        $ordem = $this->ordemModel->buscaOrdemOu404($post['codigo']);

        // Validação: Se a situação da OS for encerrada
        if($ordem->situacao === 'encerrada')
        {
            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['situacao' => "Esta O.S não pode ser editada pois encontra-se ".ucfirst($ordem->situacao)];
            
            return $this->response->setJSON($retorno);
        }

        //Validação: Existência do usuarioResponsavel
        $usuarioResponsavel = $this->buscaUsuarioOu404($post['usuario_responsavel_id']);
        
        if($this->ordemResponsavelModel->defineUsuarioResponsavel($ordem->id, $usuarioResponsavel->id)) //$usuarioResponsavel->id está sinalizando um erro inexistente
        {
            // Verificação: Se na sessão houver 'ordem-encerrar'
            if(session()->has('ordem-encerrar'))
            {
                session()->setFlashdata('sucesso', 'Agora já é possível encerrar esta Ordem de Serviço');
                
                $retorno['redirect'] = "ordens/encerrar/$ordem->codigo";
                return $this->response->setJSON($retorno);
            }

            session()->setFlashdata('sucesso', 'O técnico responsável foi atribuído a Ordem de Serviço');

            $retorno['redirect'] = "ordens/responsavel/$ordem->codigo";
            return $this->response->setJSON($retorno);

        }
            // Retorno de validações
            $retorno['erro'] = 'Por favor verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = $this->ordemResponsavelModel->errors();

            return $this->response->setJSON($retorno);

    }

    // Método: Gerar PDF da OS
    public function gerarPdf(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);

        $this->preparaItensDaOrdem($ordem);

        $data = [
            'titulo' => "Imprimir Ordem de Serviço: - $ordem->codigo",
            'ordem' => $ordem,
        ];

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view("Ordens/ordem_pdf", $data));
        // (Optional) Setup the paper size and orientation
        // Landscap = Horizontal portrait = Vertical (em pé)
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("Detalhes-$ordem->codigo.pdf", ["Attachment"=> false]); // Exibir no navegador

    }

    // Método: Enviar E-mail da OS
    public function email(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);
        
        //OrdemTrait com a unserialize dos itens ou NULL
        $this->preparaItensDaOrdem($ordem);

        if($ordem->situacao === 'aberta')
        {
            $this->enviaOrdemEmAndamenteParaCliente($ordem);
        } else 
            {
                $this->enviaOrdemEncerradaParaCliente($ordem);
            }

        return redirect()->to(site_url("ordens/detalhes/$ordem->codigo"))->with('sucesso', "O.S enviada para o e-mail do cliente.");

    }

    // Método: Encerrar OS
    public function encerrar(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);

        if($ordem->situacao !== 'aberta')
        {
            return redirect()->back()->with('atencao', 'Apenas Ordens em Aberto podem ser Encerradas');
        }

        /**
         * Definir na sessão uma chave 'ordem-encerrar'
         * Usar a chave definada 
         * Para redireiconar para o encerramento, bem como para o parecer técnico
         */
        session()->set('ordem-encerrar', $ordem->codigo);

        // VERIFICAÇÃO: PARECER TÉCNICO === NULL ou VAZIA
        if($ordem->parecer_tecnico === null || empty($ordem->parecer_tecnico))
        {
            return redirect()->to(site_url("ordens/editar/$ordem->codigo"))->with('atencao', 'Por favor, informe o parecer (laudo) técnico da Ordem de Serviço');
        }

        // VERIFICAÇÃO: Se a OS NÃO tiver um responsável técnico
        if(!$this->ordemTemResponsavel($ordem->id))
        {
            return redirect()->to(site_url("ordens/responsavel/$ordem->codigo"))->with('atencao', 'Defina um responsável técnico antes de encerrar a Ordem de Serviço');
        }


        $this->preparaItensDaOrdem($ordem);

        $data = [
            'titulo' => "Encerrar a Ordem de Serviço - $ordem->codigo",
            'ordem' => $ordem,
        ];

        return view("ordens/encerrar", $data);

    }

    // Método: Desfazer exclusão
    public function desfazerExclusao(string $codigo = null)
    {
        $ordem = $this->ordemModel->buscaOrdemOu404($codigo);

        if($ordem->deletado_em == null){

            return redirect()->back()->with('info', "Apenas ordens excluídas podem ser recuperados");

        }

        $ordem->deletado_em = null;
        $this->ordemModel->protect(false)->save($ordem);

        
        return redirect()->back()->with('sucesso', "$ordem->codigo recuperada com sucesso!");

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

        // Definir os dados iniciais, pois ainda não estão sendo buscados no BD
        $ordem->situacao = 'Aberta';
        $ordem->criado_em = date('Y/m/d H:i');

        $this->enviaOrdemEmAndamenteParaCliente($ordem);

    }

    private function enviaOrdemEmAndamenteParaCliente(object $ordem) : void
    {
        $email = service('email');
        
        $email->setFrom('no-replay@oberonsys.com', 'Oberon Sistema');

        if(isset($ordem->cliente))
        {
            $emailCliente = $ordem->cliente->email;
        
        } else 
            {
                $emailCliente = $ordem->email;
            }

        $email->setTo($emailCliente);
        $email->setSubject("Serviço $ordem->codigo em andamento");

        $data = [
                    'ordem' => $ordem,
            
                ];

        $mensagem = view('Ordens/ordem_andamento_email', $data);

        $email->setMessage($mensagem);
        $email->send();
    }

    private function enviaOrdemEncerradaParaCliente(object $ordem) : void
    {
        $email = service('email');
        
        $email->setFrom('no-replay@oberonsys.com', 'Oberon Sistema');

        if(isset($ordem->cliente))
        {
            $emailCliente = $ordem->cliente->email;
        
        } else 
            {
                $emailCliente = $ordem->email;
            }

        $email->setTo($emailCliente);

        if(isset($ordem->transacao))
        {
            $tituloEmail = "O.S $ordem->codigo encerrada com Boleto Bancário";
        
        }else
            {
                $tituloEmail = "O.S $ordem->codigo encerrada";
            }

        $email->setSubject($tituloEmail);

        $data = [
                    'ordem' => $ordem,
            
                ];

        $mensagem = view('Ordens/ordem_encerrada_email', $data);

        $email->setMessage($mensagem);
        $email->send();
    }
    
    /**
     * buscaUsuarioResponsavelOu404
     * Método privado: Buscar usuário responsável e trazer o ID e Nome no objeto
     * @param  int $usuario_responsavel_id
     * @return array
     */
    private function buscaUsuarioOu404(int $usuario_responsavel_id = null)
    {

        if (!$usuario_responsavel_id || !$usuarioResponsavel = $this->usuarioModel
                                                                    ->select('id, nome')
                                                                    ->where('ativo', true)
                                                                    ->find($usuario_responsavel_id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuário não encontrado");

        }

        return $usuarioResponsavel;

    }

    // Verificar se a OS tem um responsável técnico
    private function ordemTemResponsavel(int $ordem_id) : bool
    {
        if($this->ordemResponsavelModel->where('ordem_id', $ordem_id)->where('usuario_responsavel_id', null)->first())
        {
            return false;
        }

        return true;
    }
        
}
