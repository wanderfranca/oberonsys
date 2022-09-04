<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormaPagamentoSeeder extends Seeder
{
    public function run()
    {
        $formaPagamentoModel = new \App\Models\FormaPagamentoModel();

        $formas = [
            [
                'nome' => 'Boleto Bancário',
                'descricao' => 'Pagamento com boleto bancário',
                'ativo' => true,
            ],
            [
                'nome' => 'Cortesia',
                'descricao' => 'Destinada apenas às ordens que não geraram valor',
                'ativo' => true,
            ],
            [
                'nome' => 'Cartão de crédito',
                'descricao' => 'Cartão de crédito',
                'ativo' => true,
            ],
            [
                'nome' => 'Cartão de débito',
                'descricao' => 'Cartão de débito',
                'ativo' => true,
            ],
            [
                'nome' => 'Cartão de pix',
                'descricao' => 'Pagamento em pix',
                'ativo' => true,
            ],
            [
                'nome' => 'Dinheiro',
                'descricao' => 'Pagamento em espécie',
                'ativo' => true,
            ],
        ];

        foreach($formas as $forma)
        {
            $formaPagamentoModel->skipValidation(true)->protect(false)->insert($forma);
        }

        echo "Formas de pagamento criadas com sucesso";
    }
}
