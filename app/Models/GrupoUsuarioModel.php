<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoUsuarioModel extends Model
{
    protected $table            = 'grupos_usuarios';
    protected $returnType       = 'object';
    protected $allowedFields    = ['grupo_id', 'usuario_id'];


/**
 * Método que recupera o grupo de acesso do usuário informado
 * Utilizado no controller de usuarios
 */
    public function recuperaGruposDoUsuario(int $usuario_id, $qtd_paginacao){

        $atributos = [
            'grupos_usuarios.id AS principal_id',
            'grupos.id AS grupo_id',
            'grupos.nome',
            'grupos.descricao'
        ];

        return $this->select($atributos)
                    ->join('grupos', 'grupos.id = grupos_usuarios.grupo_id')
                    ->join('usuarios', 'usuarios.id = grupos_usuarios.usuario_id')
                    ->where('grupos_usuarios.usuario_id', $usuario_id)
                    ->groupBy('grupos.nome')
                    ->paginate($qtd_paginacao);

    }

}
