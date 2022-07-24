<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaTiposDeDocumentos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tipo_documento_nome'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],

            'tipo_documento_descricao'  => [
                'type'                  => 'TEXT',
                'null'                  => true,
            ],

            'criado_em'                 => [
                'type'                  => 'DATETIME',
                'null'                  => true,
                'default'               => null,
            ],
            'atualizado_em'       => [
                'type'              => 'DATETIME',
                'null'              => true,
                'default'           => null,
            ],

            'deletado_em'           => [
                'type'              => 'DATETIME',
                'null'              => true,
                'default'           => null,
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tipos_documentos');
    }

    public function down()
    {
        $this->forge->dropTable('tipos_de_documentos');
    }
}
