<?php

namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model
{
    protected $table            = 'eventos';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'contapagar_id',
        'ordem_id',
        'title',
        'start',
        'end',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function recuperaEventos(array $dataGet)
    {
        return $this->where('start >', $dataGet['start'])
                    ->where('end <', $dataGet['end'])
                    ->findAll();
    }

        
    /**
     * Método: Cadastrar o evento que poderá estar atrelado a uma conta_id ou OS_id
     *
     * @param  string $coluna contapagar_id ou ordem_id
     * @param  string $tituloEvento
     * @param  integer $id conta_id ou ordem_id
     * @param  integer $dias Diferença de dia entre o evento e a data atual
     * @return void
     */
    public function cadastraEvento(string $coluna, string $tituloEvento, int $id, int $dias)
    {
        $evento = [
            "$coluna"   => $id,
            "title"     => $tituloEvento,
            "start"     => date("Y-m-d", strtotime("+$dias days", time())),
            "end"       => date("Y-m-d", strtotime("+$dias days", time())),

        ];

        return $this->insert($evento);
    }

    
    /**
     * Método: Atualizar evento que está atrelado a uma conta_id ou ordem_id
     *
     * @param  string $coluna contapagar_id ou ordem_id
     * @param  integer $id conta_id ou ordem_id
     * @param  integer $dias diferença da data atual para a data de vencimento do evento
     * @return void
     */
    public function atualizaEvento(string $coluna, int $id, int $dias)
    {
        return $this->protect(false)
                    ->where($coluna, $id)
                    ->set('start', date("Y-m-d", strtotime("+$dias days", time())))
                    ->set('end', date("Y-m-d", strtotime("+$dias days", time())))
                    ->update();
    }
    
}
