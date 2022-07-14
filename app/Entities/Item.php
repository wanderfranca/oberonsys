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
}
