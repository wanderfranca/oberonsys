<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Ordem extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em'
    ];
}
