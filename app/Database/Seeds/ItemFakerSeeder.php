<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemFakerSeeder extends Seeder
{
    public function run()
    {
        $itemModel = new \App\Models\ItemModel();
        
        // Fakeseeder em PT-BR
        $faker = \Faker\Factory::create('pt-BR');

        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        // geraCodigoInternoItem()
        helper('text');

        $itensPush = [];

        $criarQuantosItens = 5000;

        for($i = 0; $i < $criarQuantosItens; $i++)
        {
            $tipo = $faker->randomElement($array = array('produto', 'servico'));

            $controlaEstoque = $faker->numberBetween(0, 1); // true ou false

            $categoria_id = 1;

            array_push($itensPush, [
                'codigo_interno' => $itemModel->geraCodigoInternoItem(),
                'nome' => $faker->unique()->words(3, true),
                'marca' => ($tipo === 'produto' ? $faker->word : null),
                'modelo' => ($tipo === 'produto' ? $faker->unique()->words(2, true) : null),
                'tipo' => $tipo,
                'preco_custo' => $faker->randomFloat(2,10,100), // Menor que o preço de venda
                'preco_venda' => $faker->randomFloat(2,100,1000), // Maior que o preço de custo
                'estoque' => ($tipo === 'produto' ? $faker->randomDigitNot(0) : null),
                'controla_estoque' => ($tipo === 'produto' ? $controlaEstoque : null),
                'categoria_id' => $categoria_id,
                'ativo' => $controlaEstoque,
                'descricao' => $faker->text(300),
                'criado_em' =>$faker->dateTimeBetween('-2 month', '-1 days')->format('Y-m-d H:i:s'),
                'atualizado_em' =>$faker->dateTimeBetween('-2 month', '-1 days')->format('Y-m-d H:i:s'),

            ]);

        }

        // echo '<pre>';
        // print_r($itensPush);
        // exit;

        $itemModel->skipValidation(true)->insertBatch($itensPush);

        echo "$criarQuantosItens semeados com sucesso!";
    }
}
