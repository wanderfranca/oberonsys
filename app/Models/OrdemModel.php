<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdemModel extends Model
{
    protected $table            = 'ordens';
    protected $returnType       = 'App\Entities\Ordem';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'cliente_id',
        'codigo',
        'forma_pagamento',
        'situacao',
        'itens',
        'valor_produtos',
        'valor_servicos',
        'valor_desconto',
        'valor_ordem',
        'equipamento',
        'defeito',
        'observacoes',
        'parecer_tecnico',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'cliente_id' => 'required',
        'codigo' => 'required|max_length[29]|is_unique[ordens.codigo,id,{id}]',
        'equipamento' => 'required|max_length[145]',
    ];
    protected $validationMessages = [
        'cliente_id' => [
            'required' => '* Informe quem é o cliente',
        ],
        'codigo' => [
            'required' => '* Informe o código da OS',
            'max_length' => '* O máximo de caracteres é 29',
            'is_unique' => '* Já existe uma ordem com esse código',
        ],
        'equipamento' => [
            'required' => '* o equipamento',
        ],

    ];

    public function recuperaOrdens()
    {
        $atributos = [
            'ordens.codigo',
            'ordens.criado_em',
            'ordens.situacao',
            'clientes.nome',
            'clientes.cpf',
        ];

        return $this->select($atributos)
                    ->join('clientes', 'clientes.id = ordens.cliente_id')
                    ->orderBy('ordens.id', 'DESC')
                    ->withDeleted(true)
                    ->findAll();
    }

    
    /**
     * buscaOrdemOu404
     * Método: Buscar uma ordem de serviço
     * @param  string|null $codigo
     * @return object|PageNotFoundException
     */
    public function buscaOrdemOu404($codigo)
    {
        if($codigo === null)
            {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ordem de serviço não encontrada");
            }

            $atributos = [
                'ordens.*',
                // Usuário que abriu
                'u_aber.id AS usuario_abertura_id', // ID do Usuário que abriu a OS
                'u_aber.nome AS usuario_abertura', // Nome do Usuário que abriu a OS
                // Usuário responsável
                'u_res.id AS usuario_responsavel_id', // ID do Usuário que trabalhou na OS
                'u_res.nome AS usuario_responsavel', // Nome do Usuário que trabalhou na OS
                // Usuário que encerrou
                'u_ence.id AS usuario_encerramento_id', // ID do Usuário que fechou a OS
                'u_ence.nome AS usuario_encerramento', // ID do Usuário que fechou a OS
                //Clientes
                'clientes.usuario_id AS cliente_usuario_id', // Para o acesso do cliente ao sistema
                'clientes.nome',
                'clientes.cpf', // Obrigatório (gerencianet)
                'clientes.telefone', // Obrigatório (gerencianet)
                'clientes.email', // Obrigatório (gerencianet)
            ];

            $ordem = $this->select($atributos)
                            ->join('ordens_responsaveis', 'ordens_responsaveis.ordem_id = ordens.id')
                            ->join('clientes', 'clientes.id = ordens.cliente_id')
                            ->join('usuarios AS u_cliente', 'u_cliente.id = clientes.usuario_id')
                            ->join('usuarios AS u_aber', 'u_aber.id = ordens_responsaveis.usuario_abertura_id')
                            ->join('usuarios AS u_res', 'u_res.id = ordens_responsaveis.usuario_responsavel_id', 'LEFT')
                            ->join('usuarios AS u_ence', 'u_ence.id = ordens_responsaveis.usuario_encerramento_id', 'LEFT')
                            ->where('ordens.codigo', $codigo)
                            ->withDeleted(true)
                            ->first();

            if($ordem === null)
            {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ordem de serviço não encontrada");
            }

            return $ordem;
    }

    /**
     * Método: Gerar código (protocolo de atendimento) da OS automaticamente
     * Formato: Ano + Mês + Dia + hora + minuto + 2 caracter alfanum maisculos aleatórios
     */
    public function geraCodigoOrdem() : string
    {
        do{

            $codigo = 'OS' . date('YmdHis') . strtoupper(random_string('alnum', 2));

            $this->select('codigo')->where('codigo', $codigo);

         }while($this->countAllResults() > 1);

        return $codigo;
    }
}
