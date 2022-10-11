<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaContasBancarias extends Migration
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
            'banco_id'              => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'banco_finalidade'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'banco_conta'           => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'banco_agencia'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'banco_pix1'            => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'banco_pix2'            => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'banco_telefone'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '30',
            ],
            'tipo'                  => [
                'type'              => 'ENUM',
                'constraint'        => ['Conta Corrente','Conta Poupança','Conta Digital','Cartão de Crédito'],
                'null' => false,
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
        $this->forge->addForeignKey('banco_id','fin_instituicoes_bancarias', 'id'); 
        $this->forge->createTable('fin_contas_bancarias');
    }

    public function down()
    {
        $this->forge->dropTable('fin_contas_bancarias');
    }
}
