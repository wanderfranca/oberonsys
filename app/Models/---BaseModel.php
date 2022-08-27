<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{

        // Callbacks
        protected $beforeInsert   = ['removeVirgulaValores'];
        protected $beforeUpdate   = ['removeVirgulaValores'];
    
    
        // Função: remover a vírgula dos preços
        protected function removeVirgulaValores(array $data)
        {
            if (isset($data['data']['preco_custo'])) {
    
                $data['data']['preco_custo'] = str_replace(",", "", $data['data']['preco_custo']);
     
            }
                
            if (isset($data['data']['preco_venda'])) {
    
                $data['data']['preco_venda'] = str_replace(",", "", $data['data']['preco_venda']);
     
            }
    
                return $data;
        }

}
