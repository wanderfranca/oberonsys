<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaOrdernsResponsaveis extends Migration
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
            'ordem_id'              => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'usuario_abertura_id'   => [ // Pagamos o id do usuário logado
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'usuario_responsavel_id'=> [ // Será preenchido no andamento ou encerramento da OS
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'usuario_encerramento_id'=> [ // Será preenchido no encerramento da OS com o ID do usuário logado
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],


        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ordem_id','ordens', 'id', 'CASCADE', 'CASCADE');        
        $this->forge->addForeignKey('usuario_abertura_id','usuarios', 'id', 'CASCADE', 'CASCADE');        
        $this->forge->addForeignKey('usuario_responsavel_id','usuarios', 'id', 'CASCADE', 'CASCADE');        
        $this->forge->addForeignKey('usuario_encerramento_id','usuarios', 'id', 'CASCADE', 'CASCADE');        
        $this->forge->createTable('ordens_responsaveis');
    }

    public function down()
    {
        $this->forge->dropTable('ordens_responsaveis');
    }
}
