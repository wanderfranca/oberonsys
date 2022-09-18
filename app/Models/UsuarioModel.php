<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Token;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [

        'nome',
        'email',
        'password',
        'reset_hash',
        'reset_expira_em',
        'imagem',
        //campo ativo não - pois existe a manipulação de formulário

    ];

    // Dados
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'nome'                  => 'required|min_length[3]|max_length[125]',
        'email'                 => 'required|valid_email|min_length[5]|max_length[230]|is_unique[usuarios.email,id,{id}]',
        'password'              => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];
    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatório.',
            'min_length' => 'O campo nome precisa ter pelo menos 3 caracteres.',
            'max_length' => 'O campo nome ultrapassou 125 caracteres.',
        ],
        'email' => [
            'required' => 'O campo E-mail é obrigatório.',
            'min_length' => 'O campo E-mail precisa ter pelo menos 5 caracteres.',
            'max_length' => 'O campo E-mail ultrapassou 230 caracteres.',
            'is_unique' => 'Este e-mail já está sendo utilizado por outro usuário.',
        ],
        'password_confirmation' => [
            'required_with' => 'Por favor, cofirme sua senha.',
            'matches' => 'As senhas precisam combinar',
        ],
    ];

    // Callbacks
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];


    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']); 
            unset($data['data']['password_confirmation']); 
        }

            return $data;
    }

    // Método: Recupera usuário por e-mail
    public function buscaUsuarioPorEmail(string $email)
    {
        // Retornar apenas usuário ativo - não excluídos
        return $this->where('email', $email)->where('deletado_em', null)->first();
    }

    //Método: Recupera as permissões do usuário logado
    public function recuperaPermissoesDoUsuarioLogado(int $usuario_id)
    {

        $atributos = [
            // 'usuarios.id',
            // 'usuarios.nome AS usuario',
            // 'grupos_usuarios.*',
            'permissoes.nome AS permissao'
        ];

        return $this->select($atributos)
                    ->asArray()
                    ->join('grupos_usuarios', 'grupos_usuarios.usuario_id = usuarios.id')
                    ->join('grupos_permissoes', 'grupos_permissoes.grupo_id = grupos_usuarios.grupo_id')
                    ->join('permissoes', 'permissoes.id = grupos_permissoes.permissao_id')
                    ->where('usuarios.id', $usuario_id)
                    ->groupBy('permissoes.nome')
                    ->findAll();

    }

    // Método: Recupera o usuário de acordo com o hash do token
    public function buscaUsuarioParaRedefinirSenha(string $token)
    {
        $token = new Token($token);

        $tokenHash = $token->getHash();

        $usuario = $this->where('reset_hash', $tokenHash)
                        ->where('deletado_em', null)
                        ->first();

        if($usuario === null)
        {
            return null;
        }

        // Verificação: Se o token ainda é válido
        if($usuario->reset_expira_em < date('Y-m-d H:i:s'))
        {

            return null;

        }

        return $usuario;

    }

    /**
     * Método: Atualiza o e-mail do usuário de acordo com o e-mail do cliente
     * Utilizar no momento de atualizar os dados do cliente
     */
    public function atualizaEmailDoCliente(int $usuario_id, string $email)
    {
        return $this->protect(false)
                    ->where('id', $usuario_id)
                    ->set('email', $email)
                    ->update();
    }
    
    /**
     * recuperaResponsaveisParaOrdem
     * Método: Recupera no banco de dados os usuários cadastrados que são técnicos
     * Joins: Trazer apenas usuários que estão em grupos
     * Where: Usuários ativos
     * Where: Grupos Marcodos para Exibição técnica
     * Where: Usuários com o ID DIFERENTE de 2 (garantindo que não traga clientes (id == 2))
     * Where: Grupos deletado_em NULL (Garantindo que não traga grupo deletado)
     * Where: Usuários deletado_em NULL (Garantindo que não traga usuário deletado)
     * @param sting $termo = O termo será pesquisado pelo usuário, passara pelo controller e chegará aqui
     * @return null|array
     */
    public function recuperaResponsaveisParaOrdem(string $termo = null)
    {

        if($termo === null)
        {
            return [];
        }

        $atributos = [
            'usuarios.id',
            'usuarios.nome',
        ];

        $responsaveis = $this->select($atributos)
                    ->join('grupos_usuarios', 'grupos_usuarios.usuario_id = usuarios.id')
                    ->join('grupos', 'grupos.id = grupos_usuarios.grupo_id')
                    ->like('usuarios.nome', $termo)
                    ->where('usuarios.ativo', true)
                    ->where('grupos.exibir', true)
                    ->where('grupos.id !=', 2)
                    ->where('grupos.deletado_em', null)
                    ->where('usuarios.deletado_em', null)
                    ->groupBy('usuarios.nome')
                    ->findAll();

            if($responsaveis === null)
            {
                return [];
            }

        return $responsaveis;
    }

    

}
