<?php

namespace App\Models;

use CodeIgniter\Model;

class InstituicoesBancariasModel extends Model
{
    protected $table            = 'fin_instituicoes_bancarias';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'id',
        'instituicao_bancaria_nome',
        'instituicao_bancaria_codigo',
        'insituicao_bancaria_ispb',

    ];

    // Dates
    protected $createdField         = 'cadastrado_em';
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';


    public function bancosAll(){

        $atributos = [
            'fin_instituicoes_bancarias.*',
            
        ];

        return $this->select($atributos)->findAll();

    }

}
