<?php

require_once('database/Banco_class.php');

class Disciplina
{
    private $id;
    private $nome;
    private $id_curso;

    /**
     * Cadastra uma nova disciplina no banco de dados.
     * @param string $nome Nome da disciplina (obrigatório)
     * @param int $id_curso ID do curso associado à disciplina (obrigatório)
     * @return bool Retorna true se o cadastro for bem-sucedido, false caso contrário
     */
    public function cadastrar($nome, $id_curso)
    {
        // Validação de entrada
        if (empty($nome) || strlen($nome) > 45 || !is_numeric($id_curso) || $id_curso <= 0) {
            return false; // Nome é obrigatório e não pode exceder 45 caracteres; id_curso deve ser válido
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o id_curso existe na tabela cursos
            $sql = "SELECT COUNT(*) FROM cursos WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id_curso]);
            if ($comando->fetchColumn() == 0) {
                return false; // Curso não encontrado
            }

            // Verifica se o nome da disciplina já existe para o curso
            $sql = "SELECT COUNT(*) FROM disciplinas WHERE nome = ? AND id_curso = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome, $id_curso]);
            if ($comando->fetchColumn() > 0) {
                return false; // Disciplina com esse nome já existe para o curso
            }

            // Cadastra a disciplina
            $sql = "INSERT INTO disciplinas (nome, id_curso) VALUES (?, ?)";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $id_curso]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar disciplina: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lista todas as disciplinas, disciplinas por id_curso ou uma disciplina específica por ID.
     * @param int|null $id ID da disciplina a ser listada (opcional)
     * @param int|null $id_curso ID do curso para filtrar disciplinas (opcional)
     * @return array|null Retorna um array com as disciplinas ou uma disciplina específica, ou null em caso de erro
     */
    public function listar($id = null, $id_curso = null)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            if (!is_null($id)) {
                // Lista uma disciplina específica por ID
                if (!is_numeric($id) || $id <= 0) {
                    return null;
                }
                $sql = "SELECT id, nome, id_curso FROM disciplinas WHERE id = ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$id]);
                $disciplina = $comando->fetch(PDO::FETCH_ASSOC);

                if ($disciplina) {
                    $this->id = $disciplina['id'];
                    $this->nome = $disciplina['nome'];
                    $this->id_curso = $disciplina['id_curso'];
                    return $disciplina;
                }
                return null; // Disciplina não encontrada
            } elseif (!is_null($id_curso)) {
                // Lista disciplinas filtradas por id_curso
                if (!is_numeric($id_curso) || $id_curso <= 0) {
                    return null;
                }
                $sql = "SELECT id, nome, id_curso FROM disciplinas WHERE id_curso = ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$id_curso]);
                return $comando->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Lista todas as disciplinas
                $sql = "SELECT id, nome, id_curso FROM disciplinas";
                $comando = $banco->prepare($sql);
                $comando->execute();
                return $comando->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            error_log("Erro ao listar disciplinas: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Edita uma disciplina existente no banco de dados.
     * @param int $id ID da disciplina a ser editada
     * @param string $nome Novo nome da disciplina (obrigatório)
     * @param int $id_curso Novo ID do curso associado à disciplina (obrigatório)
     * @return bool Retorna true se a edição for bem-sucedida, false caso contrário
     */
    public function editar($id, $nome, $id_curso)
    {
        // Validação de entrada
        if (!is_numeric($id) || $id <= 0 || empty($nome) || strlen($nome) > 45 || !is_numeric($id_curso) || $id_curso <= 0) {
            return false; // ID inválido, nome inválido ou id_curso inválido
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se a disciplina existe
            $sql = "SELECT COUNT(*) FROM disciplinas WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Disciplina não encontrada
            }

            // Verifica se o id_curso existe na tabela cursos
            $sql = "SELECT COUNT(*) FROM cursos WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id_curso]);
            if ($comando->fetchColumn() == 0) {
                return false; // Curso não encontrado
            }

            // Verifica se o novo nome já está em uso por outra disciplina no mesmo curso
            $sql = "SELECT COUNT(*) FROM disciplinas WHERE nome = ? AND id_curso = ? AND id != ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome, $id_curso, $id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Nome já em uso por outra disciplina no mesmo curso
            }

            // Atualiza a disciplina
            $sql = "UPDATE disciplinas SET nome = ?, id_curso = ? WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $id_curso, $id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao editar disciplina: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove uma disciplina do banco de dados.
     * @param int $id ID da disciplina a ser removida
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
            // Verifica se a disciplina existe
            $sql = "SELECT COUNT(*) FROM disciplinas WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Disciplina não encontrada
            }

            // Verifica se a disciplina está vinculada a aulas
            $sql = "SELECT COUNT(*) FROM aulas WHERE id_disciplina = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Disciplina não pode ser excluída devido a aulas vinculadas
            }

            // Remove a disciplina
            $sql = "DELETE FROM disciplinas WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao remover disciplina: " . $e->getMessage());
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

    public function getIdCurso()
    {
        return $this->id_curso;
    }
}

?>