<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoDocumentoModel extends Model
{
    protected $table            = 'tipos_documentos';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'tipo_documento_nome',
        'tipo_documento_descricao',

    ];


    public function tiposDocumentosAtivos()
    {
        $atributos = [
            'tipos_documentos.*'
        ];

        return $this->select($atributos)->findAll();
    }
}
