<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Despesa extends Entity
{
    protected $datamap = [];
    protected $dates   = ['criado_em', 'atualizado_em',];
    protected $casts   = [];
}
