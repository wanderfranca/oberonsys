<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FornecedorFakerSeeder extends Seeder
{
    public function run()
    {
        $fornecedorModel = new \App\Models\FornecedorModel();
        
        // Fakeseeder
        $faker = \Faker\Factory::create('pt-BR');

        $faker->addProvider(new \Faker\Provider\pt_BR\Company($faker)); //Para criar CNPJ - PTBR
        $faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($faker)); //Para criar Telefone PTBR

        $criarQuantosFornecedores = 2000;

        $fornecedorPush = [];

        for($w = 0; $w <= $criarQuantosFornecedores; $w++)
        {
            array_push($fornecedorPush, [
                'razao'     =>$faker->unique()->company,
                'cnpj'      =>$faker->unique()->cnpj,
                'ie'        =>$faker->unique()->numberBetween(1000000, 9000000),
                'telefone'  =>$faker->unique()->cellphoneNumber,
                'cep'       =>$faker->unique()->postcode,
                'endereco'  =>$faker->streetName,
                'numero'    =>$faker->buildingNumber,
                'bairro'    =>$faker->city,
                'cidade'    =>$faker->city,
                'cidade'    =>$faker->stateAbbr,
                'ativo'     =>$faker->numberBetween(1, 0),
                'criado_em' =>$faker->dateTimeBetween('-2 month', '-1 days')->format('Y-m-d H:i:s'),
                'atualizado_em' =>$faker->dateTimeBetween('-2 month', '-1 days')->format('Y-m-d H:i:s'),
            ]);
        }

        // echo '<pre>';
        // print_r($fornecedorPush);
        // exit;

        $fornecedorModel->skipValidation(true)->insertBatch($fornecedorPush);

    }
}
