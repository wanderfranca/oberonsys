<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GrupoTempSeeder extends Seeder
{
    public function run()
    {

        $grupoModel = new \App\Models\GrupoModel();

        $grupos = [

            [
                'nome' => 'Administradores',
                'descricao'=> 'Grupo de usuários com acesso total ao sistema',
                'exibir' => false,
            ],
            [
                'nome' => 'Clientes',
                'descricao' => 'Grupo de usuários com permissão apenas de visualizar suas ordens de serviços',
                'exibir' => false,
            ],
            [
                'nome' => 'Atendentes',
                'descricao' => 'Grupo de usuários com permissão para realizar atendimentos aos clientes',
                'exibir' => false,
            ],

        ];

        foreach ($grupos as $grupo){
            $grupoModel->skipValidation(true)->insert($grupo);
        }

        echo "Grupos criados com sucesso!";
    }
}
