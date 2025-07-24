<?php

require_once('database/Banco_class.php');

class Curso
{
    private $id;
    private $nome;
    private $id_nivel;

    /**
     * Cadastra um novo curso no banco de dados.
     * @param string $nome Nome do curso (obrigatório)
     * @param int $id_nivel ID do nível associado ao curso (obrigatório)
     * @return bool Retorna true se o cadastro for bem-sucedido, false caso contrário
     */
    public function cadastrar($nome, $id_nivel)
    {
        // Validação de entrada
        if (empty($nome) || strlen($nome) > 45 || !is_numeric($id_nivel) || $id_nivel <= 0) {
            return false; // Nome é obrigatório e não pode exceder 45 caracteres; id_nivel deve ser válido
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o id_nivel existe na tabela niveis
            $sql = "SELECT COUNT(*) FROM niveis WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id_nivel]);
            if ($comando->fetchColumn() == 0) {
                return false; // Nível não encontrado
            }

            // Verifica se o nome do curso já existe
            $sql = "SELECT COUNT(*) FROM cursos WHERE nome = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome]);
            if ($comando->fetchColumn() > 0) {
                return false; // Curso com esse nome já existe
            }

            // Cadastra o curso
            $sql = "INSERT INTO cursos (nome, id_nivel) VALUES (?, ?)";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $id_nivel]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar curso: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lista todos os cursos ou um curso específico por ID.
     * @param int|null $id ID do curso a ser listado (opcional)
     * @return array|null Retorna um array com os cursos ou um curso específico, ou null em caso de erro
     */
    public function listar($id = null, $max = null)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            if (is_null($id) && is_null($max)) {
                // Lista todos os cursos
                $sql = "SELECT c.id, c.nome, c.id_nivel, n.nome AS 'nivel_nome' FROM cursos c 
                INNER JOIN niveis n ON c.id_nivel = n.id 
                ORDER BY c.nome ASC";
                $comando = $banco->prepare($sql);
                $comando->execute();
                return $comando->fetchAll(PDO::FETCH_ASSOC);
            }else if(is_null($id) && !is_null($max)){
                // Lista todas as categorias limitando
                $sql = "SELECT c.id, c.nome, c.id_nivel, n.nome AS 'nivel_nome' FROM cursos c 
                INNER JOIN niveis n ON c.id_nivel = n.id 
                ORDER BY c.nome ASC LIMIT ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$max]);
                return $comando->fetchAll(PDO::FETCH_ASSOC);
         
            } else {
                // Lista um curso específico por ID
                if (!is_numeric($id) || $id <= 0) {
                    return null;
                }
                $sql = "SELECT id, nome, id_nivel FROM cursos WHERE id = ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$id]);
                $curso = $comando->fetch(PDO::FETCH_ASSOC);

                if ($curso) {
                    $this->id = $curso['id'];
                    $this->nome = $curso['nome'];
                    $this->id_nivel = $curso['id_nivel'];
                    return $curso;
                }
                return null; // Curso não encontrado
            }
        } catch (PDOException $e) {
            error_log("Erro ao listar cursos: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Edita um curso existente no banco de dados.
     * @param int $id ID do curso a ser editado
     * @param string $nome Novo nome do curso (obrigatório)
     * @param int $id_nivel Novo ID do nível associado ao curso (obrigatório)
     * @return bool Retorna true se a edição for bem-sucedida, false caso contrário
     */
    public function editar($id, $nome, $id_nivel)
    {
        // Validação de entrada
        if (!is_numeric($id) || $id <= 0 || empty($nome) || strlen($nome) > 45 || !is_numeric($id_nivel) || $id_nivel <= 0) {
            return false; // ID inválido, nome inválido ou id_nivel inválido
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o curso existe
            $sql = "SELECT COUNT(*) FROM cursos WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Curso não encontrado
            }

            // Verifica se o id_nivel existe na tabela niveis
            $sql = "SELECT COUNT(*) FROM niveis WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id_nivel]);
            if ($comando->fetchColumn() == 0) {
                return false; // Nível não encontrado
            }

            // Verifica se o novo nome já está em uso por outro curso
            $sql = "SELECT COUNT(*) FROM cursos WHERE nome = ? AND id != ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome, $id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Nome já em uso por outro curso
            }

            // Atualiza o curso
            $sql = "UPDATE cursos SET nome = ?, id_nivel = ? WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $id_nivel, $id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao editar curso: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove um curso do banco de dados.
     * @param int $id ID do curso a ser removido
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
            // Verifica se o curso existe
            $sql = "SELECT COUNT(*) FROM cursos WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Curso não encontrado
            }

            // Verifica se o curso está vinculado a disciplinas
            $sql = "SELECT COUNT(*) FROM disciplinas WHERE id_curso = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Curso não pode ser excluído devido a disciplinas vinculadas
            }

            // Remove o curso
            $sql = "DELETE FROM cursos WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao remover curso: " . $e->getMessage());
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

    public function getIdNivel()
    {
        return $this->id_nivel;
    }
}

?>