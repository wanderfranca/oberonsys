<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Despesas extends Entity
{
    protected $datamap = [];
    protected $dates   = ['criado_em', 'atualizado_em', 'deletado_em'];
    protected $casts   = [];
}
