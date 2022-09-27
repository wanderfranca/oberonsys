<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Configuracao extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
    ];
}
