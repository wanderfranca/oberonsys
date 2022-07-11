<?php

namespace App\Traits;

trait ValidacoesTrait
{
    public function consultaViaCep(string $cep) : array
    {

        $cep = str_replace('-', '', $cep);
        
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        // Abrir a conexão com a URL acima
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Executar a consulta
        $resposta = curl_exec($ch);

        // Tratamento de erro na consulta
        $erro = curl_error($ch);

        $retorno = [];

        if($erro)
        {
            $retorno['erro'] = $erro;
            return $retorno;
        }

        $consulta = json_decode($resposta);

        // Tratamento de CEP Inválido

        if(isset($consulta->erro) && !isset($consulta->cep))
        {

            session()->set('blockCep', true);

            $retorno['erro'] = '<span class="text-danger">Informe um CEP válido</span>';
            return $retorno;
        }

        // Block Cep liberado
        session()->set('blockCep', false);

        // Campos que desejo recuperar e puplar chaves de post do endereço
        $retorno['endereco']   = esc($consulta->logradouro);
        $retorno['bairro']     = esc($consulta->bairro);
        $retorno['cidade']     = esc($consulta->localidade);
        $retorno['estado']     = esc($consulta->uf);

        return $retorno;


    }
}