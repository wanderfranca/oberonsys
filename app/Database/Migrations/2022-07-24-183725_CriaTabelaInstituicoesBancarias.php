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
            'instituicao_bancaria_nome' => [
                'type'                  => 'VARCHAR',
                'constraint'            => '100',
            ],

            'instituicao_bancaria_codigo' => [
                'type'                  => 'VARCHAR',
                'constraint'            => '10',
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
        $this->forge->createTable('fin_instituicoes_bancarias');
    }

    public function down()
    {
        $this->forge->dropTable('fin_intituicoes_bancarias');
    }
}
