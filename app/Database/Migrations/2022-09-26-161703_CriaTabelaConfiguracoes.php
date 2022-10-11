<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaConfiguracoes extends Migration
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
            'razao'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => '150',
                'null'              => true,
            ],
            'codigo_empresa'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '15',
                'null'              => true,
            ],
            'cpf_cnpj'               => [
                'type'              => 'VARCHAR',
                'constraint'        => '30',
                'null'              => true,
            ],
            'cnae'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,

            ],
            'nire'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,
            ],
            'data_nire'             => [
                'type'              => 'DATE',
                'null'              => true,
                'default'           => null,
            ],
            'isento'                => [
                'type'              => 'BOOLEAN', // 0 = NÃO | 1 = ISENTO
            ],
            'ie'                    => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,
            ],
            'im'                    => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,
            ],
            'regime_tributario'     => [
                'type'              => 'ENUM',
                'constraint'        => ['mei', 'simples nacional', 'lucro presumido', 'normal'],
                'default'           => null,
                'null' => true,
            ],
            'cep'                   => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
                'null'              => true,
            ],
            'endereco'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '128',
                'null'              => true,
            ],
            'numero'                => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
                'null'              => true,
            ],
            'bairro'                => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,
            ],
            'complemento'           => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,
            ],
            'cidade'                => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true,
            ],
            'estado'                => [
                'type'              => 'VARCHAR',
                'constraint'        => '5',
                'null'              => true,
            ],
            'telefone1'                => [
                'type'              => 'VARCHAR',
                'constraint'        => '30',
                'null'              => true,
            ],
            'telefone2'                => [
                'type'              => 'VARCHAR',
                'constraint'        => '30',
                'null'              => true,
            ],
            'email'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => '150',
                'null'              => true,
            ],
            'site'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => '150',
                'null'              => true,
            ],
            'logotipo'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '150',
                'null'              => true,
            ],
            'atualizado_por'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
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
        $this->forge->createTable('configuracoes');
    }

    public function down()
    {
        $this->forge->dropTable('configuracoes');
    }
}
