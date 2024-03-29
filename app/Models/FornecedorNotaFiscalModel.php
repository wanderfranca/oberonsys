<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedorNotaFiscalModel extends Model
{
    protected $table            = 'fornecedores_nota_fiscal';

    protected $returnType       = 'object';
    protected $allowedFields    = [
        'fornecedor_id',
        'valor_nota',
        'descricao_itens',
        'nota_fiscal',
        'data_emissao',

    ];

    // Validação é feita no controller

}
