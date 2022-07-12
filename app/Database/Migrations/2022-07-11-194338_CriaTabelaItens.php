<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaItens extends Migration
{
    public function up()
    {
        $this->forge->addField([
        'id'                        => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'codigo_interno'       => [
                'type'             => 'VARCHAR',
                'constraint'       => '20',
                'unique'           => true,
            ],

            'ean'       => [
                'type'             => 'VARCHAR',
                'constraint'       => '20',
            ],

            'nome'           => [
                'type'              => 'VARCHAR',
                'constraint'        => '240',
                'unique'            => true,  

            ],

            'marca'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,  

            ],

            'modelo'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,  

            ],

            'preco_custo'       => [
                'type'              => 'DECIMAL',
                'constraint'        => '10,2',
                'null' => true,
            ],

            'preco_venda'       => [
                'type'              => 'DECIMAL',
                'constraint'        => '10,2',
                'null' => false,
            ],

            'estoque'       => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null' => true,
            ],

            'controla_estoque'      => [
                'type'              => 'BOOLEAN',
                'null' => true,
            ],

            'estoque'       => [
                'type'              => 'ENUM',
                'constraint'        => ['produto', 'servico'],
                'null' => false,
            ],

            'categoria_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],

            'ativo'       => [
                'type'              => 'BOOLEAN',
                'null' => false,
            ],

            'descricao'             => [
                'type'              => 'TEXT',
                'null' => false,
            ],

            'imagem'       => [
                'type'       => 'VARCHAR',
                'constraint' => '240',
                'null'      => true,
                'default'   => null,
            ],

            'criado_em'         => [
                'type'          => 'DATETIME',
                'null'          => true,
                'default'       => null,
            ],
            'atualizado_em'     => [
                'type'          => 'DATETIME',
                'null'          => true,
                'default'   => null,
            ],
            'deletado_em'       => [
                'type'       => 'DATETIME',
                'null'      => true,
                'default'   => null,
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('categoria_id','categorias', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('itens');
    }

    public function down()
    {
        $this->forge->dropTable('itens');
    }
}
