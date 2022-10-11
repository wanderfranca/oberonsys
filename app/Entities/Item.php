<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Item extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em'
    ];

        //Método: Exibir a situação do produto (item)
        public function exibeSituacao()
        {
    
            if($this->deletado_em != null){
                // Item excluído
    
                $icone = '<span class="text-dark">Excluído</span> <i class="fa fa-undo"></i> Desfazer';
                
                $situacao = anchor("itens/desfazerexclusao/$this->id", $icone, ['class'=> 'btn btn-outline-success btn-sm']);
    
                return $situacao;
    
            }
    
            // Se Item for ativo
            if($this->situacao == true){
                
                return '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo'; 
    
            }
    
            // Se Item for Inativo
            if($this->situacao == false){
                
                return '<i class="fa fa-lock text-danger"></i>&nbsp;Inativo'; 
    
            }
    
        }

        public function exibeTipo()
        {
            $tipoItem = "";

            if($this->tipo === 'produto'){
                
                $tipoItem = '<i class="fa fa-archive text-success" aria-hidden="true"></i>&nbsp;Produto';
                    
            }else{
                
                $tipoItem = '<i class="fa fa-wrench text-dark" aria-hidden="true"></i>&nbsp;Serviço'; 
    
            }

            return $tipoItem;

        }

        public function exibeEstoque()
        {
            if($this->estoque < 0)
            {
                return ("<span class='text-danger'> $this->estoque </span>");
            }

            return ($this->tipo === 'produto' ? "<span class='text-success'>$this->estoque </span>" : '-');
        }

        public function recuperaAtributosAlterados() : string
        {
            $atributosAlterados = [];

            if($this->hasChanged('nome'))
            {
                $atributosAlterados['nome'] = "- <b class='text-dark'>Nome</b> alterado para $this->nome";
            }
            
            if($this->hasChanged('preco_custo'))
            {
                $atributosAlterados['preco_custo'] = "- <b class='text-dark'>Preço de custo</b> foi alterado para $this->preco_custo";
            }

            if($this->hasChanged('preco_venda'))
            {
                $atributosAlterados['preco_venda'] = "- <b class='text-dark'>Preço de venda</b> foi alterado para $this->preco_venda";
            }
            
            if($this->hasChanged('preco_venda'))
            {
                $atributosAlterados['estoque'] = "- <b class='text-dark'>Quantidade de estoque</b> foi alterado para $this->estoque";
            }

            if($this->hasChanged('descricao'))
            {
                $atributosAlterados['descricao'] = "- <b class='text-dark'>Descrição</b> alterada para $this->descricao";
            }

            if($this->hasChanged('marca'))
            {
                $atributosAlterados['marca'] = "- <b class='text-dark'>Marca</b> alterada para $this->marca";
            }

            if($this->hasChanged('modelo'))
            {
                $atributosAlterados['modelo'] = "- <b class='text-dark'>modelo</b> alterado para $this->modelo";
            }

            if($this->hasChanged('categoria_id'))
            {
                $atributosAlterados['categoria_id'] = "- <b class='text-dark'>Categoria</b> foi alterada";
            }

            if($this->hasChanged('ean'))
            {
                $atributosAlterados['ean'] = "- <b class='text-dark'>EAN/GETIN </b> foi alterado para $this->ean";
            }

            if($this->hasChanged('codigo_interno'))
            {
                $atributosAlterados['codigo_interno'] = "- <b class='text-dark'>Código SKU</b> alterado para $this->codigo_interno";
            }

            if($this->hasChanged('controla_estoque')){

                if($this->controla_estoque == true){
                    $atributosAlterados['controla_estoque'] = "- <b class='text-dark'>Controle de estoque foi </b><b class='text-success'> ativado </b>";
               
                } else {
                    $atributosAlterados['controla_estoque'] = "- <b class='text-dark'>Controle de estoque foi </b> <b class='text-danger'> desativado </b>";

                }
            }

            if($this->hasChanged('situacao'))
            {
                if($this->situacao == true){
                    $atributosAlterados['situacao'] = "- <b class='text-dark'>O item foi </b><b class='text-success'> ativado </b>";
                
                } else {

                        $atributosAlterados['situacao'] = "- <b class='text-dark'>O item foi </b><b class='text-danger'> desativado </b>";

                }
            }

            return serialize($atributosAlterados);

        }
}
