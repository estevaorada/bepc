<?php

require_once('database/Banco_class.php');

class Usuario
{
    private $id;
    private $nome;
    private $sobrenome;
    private $id_tipo;
    private $email;
    private $situacao;
    private $data_cadastro;

    /**
     * Cadastra um novo usuário no banco de dados.
     * @param string $nome Nome do usuário
     * @param string $sobrenome Sobrenome do usuário
     * @param int $id_tipo ID do tipo de usuário (referência a usuarios_tipo)
     * @param string $email E-mail do usuário
     * @param string $senha Senha em texto puro
     * @param bool $situacao Situação do usuário (ativo = 1, inativo = 0)
     * @return bool Retorna true se o cadastro for bem-sucedido, false caso contrário
     */

    public function cadastrar($nome, $sobrenome, $id_tipo, $email, $senha, $situacao = 1)
    {
        // Validação de entrada
        if (empty($nome) || empty($sobrenome) || empty($id_tipo) || empty($email) || empty($senha) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Verifica se o id_tipo existe na tabela usuarios_tipo
        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            $sql = "SELECT COUNT(*) FROM usuarios_tipo WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id_tipo]);
            if ($comando->fetchColumn() == 0) {
                return false; // Tipo de usuário inválido
            }

            // Verifica se o e-mail já está cadastrado
            $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$email]);
            if ($comando->fetchColumn() > 0) {
                return false; // E-mail já existe
            }

            // Cadastra o usuário
            $sql = "INSERT INTO usuarios (nome, sobrenome, id_tipo, email, senha, situacao) VALUES (?, ?, ?, ?, ?, ?)";
            $comando = $banco->prepare($sql);
            $hash = password_hash($senha, PASSWORD_BCRYPT);
            $result = $comando->execute([$nome, $sobrenome, $id_tipo, $email, $hash, $situacao ? 1 : 0]);
            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Realiza o login de um usuário.
     * @param string $email E-mail do usuário
     * @param string $senha Senha em texto puro
     * @return array|null Retorna os dados do usuário se o login for bem-sucedido, null caso contrário
     */
    public function logar($email, $senha)
    {
        // Validação de entrada
        if (empty($email) || empty($senha) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 1;
            return null;
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            $sql = "SELECT u.id, u.nome, u.sobrenome, u.id_tipo, u.email, u.senha, u.situacao, u.data_cadastro, t.nome_tipo AS tipo 
            FROM usuarios u
            INNER JOIN usuarios_tipo t ON u.id_tipo = t.id
            WHERE u.email = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$email]);
            $usuario = $comando->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Preenche os atributos da instância
                $this->id = $usuario['id'];
                $this->nome = $usuario['nome'];
                $this->sobrenome = $usuario['sobrenome'];
                $this->id_tipo = $usuario['id_tipo'];
                $this->email = $usuario['email'];
                $this->situacao = $usuario['situacao'];
                $this->data_cadastro = $usuario['data_cadastro'];
                return $usuario;
            }
            return null;
        } catch (PDOException $e) {
            error_log("Erro ao realizar login: " . $e->getMessage());
            return null;
        }
    }

    public function listarTodos($idTipoUsuario, $ativo = 1)
    {
        // Validação de permissão
        if (!is_numeric($idTipoUsuario) || $idTipoUsuario != 1) {
            return null; // Apenas usuários com id_tipo == 1 podem acessar
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            // Consulta com INNER JOIN para trazer o nome do tipo, excluindo a senha
            if ($ativo) {
                $sql = "SELECT u.id, u.nome, u.sobrenome, u.data_cadastro, u.situacao, u.email, u.id_tipo, t.nome_tipo AS tipo_nome 
                    FROM usuarios u 
                    INNER JOIN usuarios_tipo t ON u.id_tipo = t.id
                    WHERE u.situacao = 1";
            } else {
                $sql = "SELECT u.id, u.nome, u.sobrenome, u.data_cadastro, u.situacao, u.email, u.id_tipo, t.nome_tipo AS tipo_nome 
                    FROM usuarios u 
                    INNER JOIN usuarios_tipo t ON u.id_tipo = t.id
                    WHERE u.situacao = 0";
            }
            $comando = $banco->prepare($sql);
            $comando->execute();
            $usuarios = $comando->fetchAll(PDO::FETCH_ASSOC);

            return $usuarios;
        } catch (PDOException $e) {
            error_log("Erro ao listar todos os usuários: " . $e->getMessage());
            return null;
        }
    }

    public function desativar($idTipoUsuario, $id)
    {
        // Validação de entrada
        if (!is_numeric($id) || $id <= 0) {
            return false;
        }

        // Validação de permissão
        if (!is_numeric($idTipoUsuario) || $idTipoUsuario != 1) {
            return null; // Apenas usuários com id_tipo == 1 podem acessar
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o usuário existe
            $sql = "SELECT COUNT(*) FROM usuarios WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Usuário não encontrado
            }

            // Atualiza a situação para 0 (inativo)
            $sql = "UPDATE usuarios SET situacao = 0 WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$id]);

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            error_log("Erro ao ativar usuário: " . $e->getMessage());
            return false;
        }
    }


    /**
     * Modifica os dados pessoais (nome, sobrenome e email) de um usuário.
     * Apenas o próprio usuário ou administradores (id_tipo == 1) podem modificar.
     * @param int $idUsuarioLogado ID do usuário logado
     * @param int $idTipoUsuario Tipo do usuário logado
     * @param int $idUsuarioModificado ID do usuário a ser modificado
     * @param string $nome Novo nome
     * @param string $sobrenome Novo sobrenome
     * @param string $email Novo email
     * @return bool Retorna true se a modificação for bem-sucedida, false caso contrário
     */
    public function modificarDadosPessoais($idUsuarioLogado, $idTipoUsuario, $idUsuarioModificado, $nome, $sobrenome, $email)
    {
        if (
            !is_numeric($idUsuarioLogado) || !is_numeric($idTipoUsuario) || !is_numeric($idUsuarioModificado) ||
            $idUsuarioLogado <= 0 || $idUsuarioModificado <= 0 ||
            empty($nome) || empty($sobrenome) || empty($email) ||
            strlen($nome) > 100 || strlen($sobrenome) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            return false;
        }

        if ($idUsuarioLogado != $idUsuarioModificado && $idTipoUsuario != 1) {
            return false;
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$idUsuarioModificado]);
            if ($comando->fetchColumn() == 0) {
                return false;
            }

            $sql = "UPDATE usuarios SET nome = ?, sobrenome = ?, email = ? WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $sobrenome, $email, $idUsuarioModificado]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao modificar dados pessoais: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Modifica a senha de um usuário. O próprio usuário deve fornecer a senha atual,
     * enquanto administradores (id_tipo == 1) podem modificá-la sem verificação.
     * @param int $idUsuarioLogado ID do usuário logado
     * @param int $idTipoUsuario Tipo do usuário logado
     * @param int $idUsuarioModificado ID do usuário cuja senha será modificada
     * @param string $senhaAtual Senha atual informada (necessária para o próprio usuário)
     * @param string $novaSenha Nova senha a ser definida
     * @return bool Retorna true se a modificação for bem-sucedida, false caso contrário
     */
    public function modificarSenha($idUsuarioLogado, $idTipoUsuario, $idUsuarioModificado, $senhaAtual, $novaSenha)
    {
        // Validação de entrada
        if (
            !is_numeric($idUsuarioLogado) || !is_numeric($idTipoUsuario) || !is_numeric($idUsuarioModificado) ||
            $idUsuarioLogado <= 0 || $idUsuarioModificado <= 0 ||
            empty($novaSenha) || strlen($novaSenha) < 6
        ) {
            return false;
        }

        // Validação de permissão
        if ($idUsuarioLogado != $idUsuarioModificado && $idTipoUsuario != 1) {
            return false; // Apenas o próprio usuário ou administradores podem modificar
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o usuário existe
            $sql = "SELECT senha FROM usuarios WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$idUsuarioModificado]);
            $usuario = $comando->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return false; // Usuário não encontrado
            }

            // Se for o próprio usuário, verifica a senha atual
            if ($idUsuarioLogado == $idUsuarioModificado && (!isset($senhaAtual) || empty($senhaAtual) || !password_verify($senhaAtual, $usuario['senha']))) {
                return false; // Senha atual incorreta
            }

            // Atualiza a senha com hash
            $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$novaSenhaHash, $idUsuarioModificado]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao modificar senha: " . $e->getMessage());
            return false;
        }
    }
    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    public function getIdTipo()
    {
        return $this->id_tipo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }
}
