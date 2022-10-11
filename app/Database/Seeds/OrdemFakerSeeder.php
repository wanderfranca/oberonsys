<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrdemFakerSeeder extends Seeder
{
    public function run()
    {
        $clienteModel = new \App\Models\ClienteModel();
        $ordemModel = new \App\Models\OrdemModel();
        $ordemResponsavelModel = new \App\Models\OrdemResponsavelModel();

        // Recuperar apenas os ids dos clientes
        $clientes = $clienteModel->select('id')->findAll();

        $clientesIDs = array_column($clientes, 'id');

        $faker = \Faker\Factory::create('pt-BR');

        helper('text');

        for($i = 0; $i < count($clientesIDs); $i++)
        {
            $ordem = [
                'cliente_id' => $faker->randomElement($clientesIDs),
                'codigo' => $ordemModel->geraCodigoOrdem(),
                'situacao' => 'aberta',
                'equipamento' => $faker->name(),
                'defeito' => $faker->realText(),
            ];
            
            // Insert da fake ordem
             $ordemModel->skipValidation(true)->insert($ordem);

             $ordemResponsavel = [

                'ordem_id' => $ordemModel->getInsertID(),
                'usuario_abertura_id' => 894,

             ];

             // Cadastrar o usuário responsável pela abertura da OS
             $ordemResponsavelModel->skipValidation(true)->insert($ordemResponsavel);

        }

        echo count($clientesIDs). ' Ordens criadas com sucesso!';

    }
}
