<?php

namespace App\Libraries;

class Token
{
    private $token;

    /**
     * Método construtor da clarro Token
     * Exemplos de uso: $token = new Token($token); Já tem um token e precisa do hash desse token
     *                  $token = new Token(); Gerar um novo token para enviar a recuperação de senha
     * 
     */

public function __construct(string $token = null)
{
        if($token == null)
        {
            $this->token = bin2hex(random_bytes(16));
        
        }else {

            $this->token = $token;
            
        }

    }

    // Método: Retornar o valor do token
    public function getValue() : string
    {
        return $this->token;
    }

    public function getHash() : string
    {
        return hash_hmac("sha256", $this->token, getenv('KEY_RECUPERCAO_SENHA'));
    }
}