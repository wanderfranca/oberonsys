<?php

namespace App\Traits;

trait OrdemTrait
{
    
    /**
     * preparaItensDaOrdem
     * Método: Prepara a exibição dos possíveis itens da ordem do serviço
     * Ternário: ordem->itens = Se itens diferente de vazio "ordemItens" se for vazio NULL
     * @param  object $ordem
     * @return object
     */
    public function preparaItensDaOrdem(object $ordem) : object
    {
        $ordemItemModel = new \App\Models\OrdemItemModel();

        if($ordem->situacao === 'aberta')
        {
            $ordemItens = $ordemItemModel->recuperaItensDaOrdem($ordem->id);

            $ordem->itens = (!empty($ordemItens) ? $ordemItens : null);

            return $ordem;
        }

        if($ordem->itens !== null)
        {
            $ordem->itens = unserialize($ordem->itens);
        }

        return $ordem;

    }

}