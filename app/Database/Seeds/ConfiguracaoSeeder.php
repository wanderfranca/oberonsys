<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfiguracaoSeeder extends Seeder
{
    public function run()
    {
        $configuracaoModel = new \App\Models\ConfiguracaoModel();

        $configs = [
            [
                'razao' => 'Suporte Oberon',
                'codigo_empresa' => '00001',
                'cpf_cnpj' => '14508235578',
                'regime_tributario' => 'indefinido',
            ],
         
        ];

        foreach($configs as $config)
        {
            $configuracaoModel->skipValidation(true)->protect(false)->insert($config);
        }

        echo "Configurações Iniciais criadas com sucesso!";
    }
}
