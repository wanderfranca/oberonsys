<?php

namespace App\Models;

use CodeIgniter\Model;

class ContaBancariaModel extends Model
{
    protected $table            = 'fin_contas_bancarias';
    protected $returnType       = 'App\Entities\ContaBancaria';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'banco_id',
        'banco_finalidade',
        'banco_conta',
        'banco_agencia',
        'banco_tipo',
        'banco_pix1',
        'banco_pix2',
        'banco_telefone',
        'banco_ativo',

    ];

    // Dates
    protected $createdField         = 'cadastrado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

  // Validation
  protected $validationRules = [
    'banco_finalidade'      => 'required|min_length[5]|max_length[90]|is_unique[fin_contas_bancarias.banco_finalidade,id,{id}]',
    'banco_conta'           => 'min_length[3]|max_length[15]|is_unique[fin_contas_bancarias.banco_conta,id,{id}]',
    'banco_tipo'            => 'required',
    'banco_id'              => 'required',

];
    protected $validationMessages = [
        'banco_finalidade' => [
            'required'      => '* Informa a finalidade dessa conta bancária',
            'is_unique'     => '* Outra conta já é utilizado para esta finalidade',
            'min_length'    => '* insira pelo menos 5 caracteres.',
            'max_length'    => '* O máximo permitido é 90 caractéres.',
        ],

        'banco_conta' => [
            'required'      => '* Informa a conta seguida de traço e dígito verificador',
            'is_unique'     => '* Essa conta já foi cadastrada',
            'min_length'    => '* insira pelo menos 3 caracteres.',
            'max_length'    => '* O máximo permitido é 15 caractéres.',
        ],

        'banco_tipo' => [
            'required'      => '* Você esqueceu o tipo de banco',
        ],

    ];

    public function contasBancariasAtivas()
    {
        $atributos = [
            'fin_contas_bancarias.*'
        ];

        return $this->select($atributos)->where('ativo',1)->findAll();
    }

    public function recuperaInstituicoesBancarias(){

        $atributos = [
            'fin_instituicoes_bancarias.*',
            
        ];

        return $this->select($atributos)->findAll();

    }

}
