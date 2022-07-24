<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaContasPagar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'fornecedor_id'         => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'despesa_id'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'conta_bancaria_id'     => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'documento_id'          => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'numero_documento'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,
            ],

            'observacao'            => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
            ],
            'valor_conta'           => [
                'type'              => 'decimal',
                'constraint'        => '10,2',
            ],
            'situacao'              => [
                'type'              => 'BOOLEAN', // 0 = em aberto | 1 = paga
            ],

            'data_vencimento'       => [
                'type'              => 'DATE',
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

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('fornecedor_id','fornecedores', 'id');
        $this->forge->addForeignKey('despesa_id','fin_despesas', 'id'); 
        $this->forge->addForeignKey('documento_id','tipos_documentos', 'id');
        $this->forge->addForeignKey('conta_bancaria_id','fin_contas_bancarias', 'id');
        
        $this->forge->createTable('contas_pagar');
    }

    public function down()
    {
        $this->forge->dropTable('contas_pagar');
    }
}
