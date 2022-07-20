<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClienteFakerSeeder extends Seeder
{
    public function run()
    {
        $clienteModel = new \App\Models\ClienteModel();
        $usuarioModel = new \App\Models\UsuarioModel();
        $grupoUsuarioModel = new \App\Models\GrupoUsuarioModel();


        // Fakeseeder
        $faker = \Faker\Factory::create('pt-BR');

        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker)); //Para criar CPF - PTBR
        $faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($faker)); //Para criar Telefone PTBR

        $criarQuantosClientes = 1000;

        for($i = 0; $i < $criarQuantosClientes; $i++)
        {
            $nomeGerado = $faker->unique()->name;
            $emailGerado = $faker->unique()->email;

            $cliente = [
                'nome'          => $nomeGerado,
                'cpf'           => $faker->unique()->cpf,
                'telefone'      => $faker->cellphoneNumber,
                'email'         => $emailGerado,
                'cep'           => $faker->postcode,
                'endereco'      => $faker->streetName,
                'numero'        => $faker->buildingNumber,
                'bairro'        => $faker->city,
                'complemento'   => $faker->city,
                'cidade'        => $faker->city,
                'estado'        => $faker->stateAbbr,
            ];

            $clienteModel->skipValidation(true)->insert($cliente);

            /**
             * Fluxo: Criar cliente e usuário do cliente
             * 1 - Primeiro monte todo FakeSeeder com os dados do cliente
             * 2 - Crie o array $usuario populando chave e valor com os campos da tabela usuário inserindo os dados do cliente fake
             * 3 - Faça a inserção dos dados na tabela de usuário
             * 4 - Crie o array $grupoUsuario e popule-o chave e valor do grupo 2 (clientes) e usuario_id com o ultimo id inserido em usuarioModel
             * 5 - Faça a inserção na tabela de grupousuarios
             * 6 - Update na coluna "usuario_id" com o ultimo
             */

            // Montagem de dados de Usuário do Cliente
            $usuario = [
                'nome'      => $nomeGerado,
                'email'     => $emailGerado,
                'password'  => '123456',
                'ativo'     => true,
            ];

            // Inserção de dados do cliente na tabela de usuário
            $usuarioModel->skipValidation(true)->protect(false)->insert($usuario);

            $grupoUsuario = [
                'grupo_id'      => 2, //Grupo 2 foi destinado aos clientes
                'usuario_id'    => $usuarioModel->getInsertID(), // Pegar o último ID inserido e atribuindo ao usuario_id
            ];

            // Inserção de dados do usuário/cliente na tabela de grupos usuários
            $grupoUsuarioModel->protect(false)->insert($grupoUsuario);

            // Update na tabela usuario_id, com o valor do id do usuário recém criado
            $clienteModel->protect(false)
                        ->where('id', $clienteModel->getInsertID())
                        ->set('usuario_id', $usuarioModel->getInsertID())
                        ->update();

        }

        echo "$criarQuantosClientes clientes carregados com sucesso!";

    }
}
