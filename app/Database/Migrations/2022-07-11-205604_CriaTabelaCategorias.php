<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaCategorias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'categoria_nome'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],

            'categoria_descricao'   => [
                'type'              => 'TEXT',
                'null'              => true,
            ],  

            'ativo'                 => [
                'type'              => 'BOOLEAN',
                'null'              => false,
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
        $this->forge->createTable('categorias');
    }

    public function down()
    {
        $this->forge->dropTable('categorias');
    }
}
