<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaDespesas extends Migration
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
            'despesa_nome'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],

            'despesa_descricao'  => [
                'type'           => 'TEXT',
                'null'           => true,
            ],

            'criado_em'             => [
                'type'              => 'DATETIME',
                'null'              => true,
                'default'           => null,
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
        $this->forge->createTable('fin_despesas');
    }

    public function down()
    {
        $this->forge->dropTable('fin_despesas');
    }
}
