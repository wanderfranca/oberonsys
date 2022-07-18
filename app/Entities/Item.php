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
    
                $icone = '<span class="text-white">Excluído</span> <i class="fa fa-undo"></i> Desfazer';
                
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
                
                $tipoItem = '<i class="fa fa-wrench text-white" aria-hidden="true"></i>&nbsp;Serviço'; 
    
            }

            return $tipoItem;

        }

        public function exibeEstoque()
        {
            return ($this->tipo === 'produto' ? $this->estoque : 'Não se aplica');
        }

        public function recuperaAtributosAlterados() : string
        {
            $atributosAlterados = [];

            if($this->hasChanged('nome'))
            {
                $atributosAlterados['nome'] = "- <b class='text-white'>Nome</b> alterado para $this->nome";
            }
            
            if($this->hasChanged('preco_custo'))
            {
                $atributosAlterados['preco_custo'] = "- <b class='text-white'>Preço de custo</b> foi alterado para $this->preco_custo";
            }

            if($this->hasChanged('preco_venda'))
            {
                $atributosAlterados['preco_venda'] = "- <b class='text-white'>Preço de venda</b> foi alterado para $this->preco_venda";
            }
            
            if($this->hasChanged('preco_venda'))
            {
                $atributosAlterados['estoque'] = "- <b class='text-white'>Quantidade de estoque</b> foi alterado para $this->estoque";
            }

            if($this->hasChanged('descricao'))
            {
                $atributosAlterados['descricao'] = "- <b class='text-white'>Descrição</b> alterada para $this->descricao";
            }

            if($this->hasChanged('marca'))
            {
                $atributosAlterados['marca'] = "- <b class='text-white'>Marca</b> alterada para $this->marca";
            }

            if($this->hasChanged('modelo'))
            {
                $atributosAlterados['modelo'] = "- <b class='text-white'>modelo</b> alterado para $this->modelo";
            }

            if($this->hasChanged('categoria_id'))
            {
                $atributosAlterados['categoria_id'] = "- <b class='text-white'>Categoria</b> foi alterada";
            }

            if($this->hasChanged('ean'))
            {
                $atributosAlterados['ean'] = "- <b class='text-white'>EAN/GETIN </b> foi alterado para $this->ean";
            }

            if($this->hasChanged('codigo_interno'))
            {
                $atributosAlterados['codigo_interno'] = "- <b class='text-white'>Código SKU</b> alterado para $this->codigo_interno";
            }

            if($this->hasChanged('controla_estoque')){

                if($this->controla_estoque === true){
                    $atributosAlterados['controla_estoque'] = "- <b class='text-white'>Controle de estoque foi </b><b class='text-success'> ativado </b>";
               
                } else {
                    $atributosAlterados['controla_estoque'] = "- <b class='text-white'>Controle de estoque foi </b> <b class='text-danger'> desativado </b>";

                }
            }

            if($this->hasChanged('situacao'))
            {
                if($this->situacao === true){
                    $atributosAlterados['situacao'] = "- <b class='text-white'>O item foi </b><b class='text-success'> ativado </b>";
                
                } else {

                        $atributosAlterados['situacao'] = "- <b class='text-white'>O item foi </b><b class='text-danger'> desativado </b>";

                }
            }

            return serialize($atributosAlterados);

        }
}
