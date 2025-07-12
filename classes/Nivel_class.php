<?php

require_once('database/Banco_class.php');

class Nivel
{
    private $id;
    private $nome;

    /**
     * Adiciona um novo nível no banco de dados.
     * @param string $nome Nome do nível (obrigatório)
     * @return bool Retorna true se o cadastro for bem-sucedido, false caso contrário
     */
    public function adicionar($nome)
    {
        // Validação de entrada
        if (empty($nome) || strlen($nome) > 45) {
            return false; // Nome é obrigatório e não pode exceder 45 caracteres
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o nome do nível já existe
            $sql = "SELECT COUNT(*) FROM niveis WHERE nome = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome]);
            if ($comando->fetchColumn() > 0) {
                return false; // Nível com esse nome já existe
            }

            // Adiciona o nível
            $sql = "INSERT INTO niveis (nome) VALUES (?)";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao adicionar nível: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lista todos os níveis ou um nível específico por ID.
     * @param int|null $id ID do nível a ser listado (opcional)
     * @return array|null Retorna um array com os níveis ou um nível específico, ou null em caso de erro
     */
    
    public function listar($id = null)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            if (is_null($id)) {
                // Lista todos os níveis
                $sql = "SELECT id, nome FROM niveis ORDER BY nome";
                $comando = $banco->prepare($sql);
                $comando->execute();
                return $comando->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Lista um nível específico por ID
                if (!is_numeric($id) || $id <= 0) {
                    return null;
                }
                $sql = "SELECT id, nome FROM niveis WHERE id = ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$id]);
                $nivel = $comando->fetch(PDO::FETCH_ASSOC);

                if ($nivel) {
                    $this->id = $nivel['id'];
                    $this->nome = $nivel['nome'];
                    return $nivel;
                }
                return null; // Nível não encontrado
            }
        } catch (PDOException $e) {
            error_log("Erro ao listar níveis: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Edita um nível existente no banco de dados.
     * @param int $id ID do nível a ser editado
     * @param string $nome Novo nome do nível (obrigatório)
     * @return bool Retorna true se a edição for bem-sucedida, false caso contrário
     */
    public function editar($id, $nome)
    {
        // Validação de entrada
        if (!is_numeric($id) || $id <= 0 || empty($nome) || strlen($nome) > 45) {
            return false; // ID inválido ou nome inválido
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o nível existe
            $sql = "SELECT COUNT(*) FROM niveis WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Nível não encontrado
            }

            // Verifica se o novo nome já está em uso por outro nível
            $sql = "SELECT COUNT(*) FROM niveis WHERE nome = ? AND id != ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome, $id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Nome já em uso por outro nível
            }

            // Atualiza o nível
            $sql = "UPDATE niveis SET nome = ? WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao editar nível: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove um nível do banco de dados.
     * @param int $id ID do nível a ser removido
     * @return bool Retorna true se a remoção for bem-sucedida, false caso contrário
     */
    public function remover($id)
    {
        // Validação de entrada
        if (!is_numeric($id) || $id <= 0) {
            return false; // ID inválido
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o nível existe
            $sql = "SELECT COUNT(*) FROM niveis WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Nível não encontrado
            }

            // Verifica se o nível está vinculado a cursos
            $sql = "SELECT COUNT(*) FROM cursos WHERE id_nivel = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Nível não pode ser excluído devido a cursos vinculados
            }

            // Remove o nível
            $sql = "DELETE FROM niveis WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao remover nível: " . $e->getMessage());
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
}

?>