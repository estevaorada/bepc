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
            return null;
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            $sql = "SELECT id, nome, sobrenome, id_tipo, email, senha, situacao, data_cadastro FROM usuarios WHERE email = ?";
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

    public function desativar($id)
    {
        // Validação de entrada
        if (!is_numeric($id) || $id <= 0) {
            return false;
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

            // Atualiza a situação para 1 (inativo)
            $sql = "UPDATE usuarios SET situacao = 0 WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao ativar usuário: " . $e->getMessage());
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

?>