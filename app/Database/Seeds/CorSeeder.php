<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CorSeeder extends Seeder
{
    public function run()
    {
        $corModel = new \App\Models\CorModel();

        $cores = [

            [
             'nome' => 'Amarelo',
             'descricao' => 'Descrição da cor teste',
            ],
            [
             'nome' => 'Azul',
             'descricao' => 'Descrição da cor teste',
            ],
            [
             'nome' => 'Verde',
             'descricao' => 'Descrição da cor teste',
            ],
            [
            'nome' => 'Vermelho',
            'descricao' => 'Descrição da cor teste',
            ],
            [
            'nome' => 'Preto',
            'descricao' => 'Descrição da cor teste',
            ],
            [
            'nome' => 'Cinza',
            'descricao' => 'Descrição da cor teste',
            ],
            [
            'nome' => 'Branco',
            'descricao' => 'Descrição da cor teste',
            ],

        ];

        // dd($cores);

        foreach($cores as $cor){
            $corModel ->insert($cor);
        }

        echo 'Cores inseridas com sucesso!';
    }
}
