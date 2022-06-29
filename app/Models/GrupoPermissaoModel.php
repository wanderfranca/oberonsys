<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoPermissaoModel extends Model
{
    protected $table            = 'grupos_permissoes';
    protected $returnType       = 'object';
    protected $allowedFields    = ['grupo_id', 'permissao_id'];


    
    public function recuperaPermissoesDoGrupo(int $grupo_id, int $quantidade_paginacao){

        // Array de dados que serão recuperados do banco de dados
        $atributos = [
            'grupos_permissoes.id AS principal_id',
            'grupos.id AS grupo_id',
            'permissoes.id AS permissao_id',
            'permissoes.nome',
        ];

        return $this->select($atributos)
                    ->join('grupos', 'grupos.id = grupos_permissoes.grupo_id') //Join entre grupo.id da tabela Grupos = grupo_id da tabela Grupos_Permissoes
                    ->join('permissoes', 'permissoes.id = grupos_permissoes.permissao_id') //Join entre permissoes.id da tabela permissões = permissão_id da tabela Grupos_Permissoes
                    ->where('grupos_permissoes.grupo_id', $grupo_id) //WHERE grupo_id = $grupo_id que vem como parâmetro
                    ->groupBy('permissoes.nome') //Agrupe todos os registros pelos nomes das permissões
                    ->paginate($quantidade_paginacao); //Façao paginate pelo valor da informação definida no parâmetro
    }

}
