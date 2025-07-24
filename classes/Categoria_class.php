<?php

require_once('database/Banco_class.php');

class Categoria
{
    private $id;
    private $nome;
    private $descricao;

    /**
     * Cadastra uma nova categoria no banco de dados.
     * @param string $nome Nome da categoria (obrigatório)
     * @param string|null $descricao Descrição da categoria (opcional)
     * @return bool Retorna true se o cadastro for bem-sucedido, false caso contrário
     */
    public function cadastrar($nome, $descricao = null)
    {
        // Validação de entrada
        if (empty($nome) || strlen($nome) > 45) {
            return false; // Nome é obrigatório e não pode exceder 45 caracteres
        }
        if (!is_null($descricao) && strlen($descricao) > 200) {
            return false; // Descrição não pode exceder 200 caracteres
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se o nome da categoria já existe
            $sql = "SELECT COUNT(*) FROM categorias WHERE nome = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome]);
            if ($comando->fetchColumn() > 0) {
                return false; // Categoria com esse nome já existe
            }

            // Cadastra a categoria
            $sql = "INSERT INTO categorias (nome, descricao) VALUES (?, ?)";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $descricao]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar categoria: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lista todas as categorias ou uma categoria específica por ID.
     * @param int|null $id ID da categoria a ser listada (opcional)
     * @return array|null Retorna um array com as categorias ou uma categoria específica, ou null em caso de erro
     */
    public function listar($id = null, $max = null)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            if (is_null($id) && is_null($max)) {
                // Lista todas as categorias
                $sql = "SELECT id, nome, descricao FROM categorias ORDER BY nome ASC";
                $comando = $banco->prepare($sql);
                $comando->execute();
                return $comando->fetchAll(PDO::FETCH_ASSOC);
            }else if(is_null($id) && !is_null($max)){
                // Lista todas as categorias limitando
                $sql = "SELECT id, nome, descricao FROM categorias ORDER BY nome ASC LIMIT ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$max]);
                return $comando->fetchAll(PDO::FETCH_ASSOC);
         
            } else {
                // Lista uma categoria específica por ID
                if (!is_numeric($id) || $id <= 0) {
                    return null;
                }
                $sql = "SELECT id, nome, descricao FROM categorias WHERE id = ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$id]);
                $categoria = $comando->fetch(PDO::FETCH_ASSOC);

                if ($categoria) {
                    $this->id = $categoria['id'];
                    $this->nome = $categoria['nome'];
                    $this->descricao = $categoria['descricao'];
                    return $categoria;
                }
                return null; // Categoria não encontrada
            }
        } catch (PDOException $e) {
            error_log("Erro ao listar categorias: " . $e->getMessage());
            return null;
        }
    }

   public function editar($id, $nome, $descricao = null)
    {
        // Validação de entrada
        if (!is_numeric($id) || $id <= 0 || empty($nome) || strlen($nome) > 45) {
            return false; // ID inválido ou nome inválido
        }
        if (!is_null($descricao) && strlen($descricao) > 200) {
            return false; // Descrição não pode exceder 200 caracteres
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se a categoria existe
            $sql = "SELECT COUNT(*) FROM categorias WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Categoria não encontrada
            }

            // Verifica se o novo nome já está em uso por outra categoria
            $sql = "SELECT COUNT(*) FROM categorias WHERE nome = ? AND id != ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$nome, $id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Nome já em uso por outra categoria
            }

            // Atualiza a categoria
            $sql = "UPDATE categorias SET nome = ?, descricao = ? WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$nome, $descricao, $id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao editar categoria: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove uma categoria do banco de dados.
     * @param int $id ID da categoria a ser removida
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
            // Verifica se a categoria existe
            $sql = "SELECT COUNT(*) FROM categorias WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() == 0) {
                return false; // Categoria não encontrada
            }

            // Verifica se a categoria está vinculada a aulas
            $sql = "SELECT COUNT(*) FROM aulas WHERE id_categoria = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$id]);
            if ($comando->fetchColumn() > 0) {
                return false; // Categoria não pode ser excluída devido a aulas vinculadas
            }

            // Remove a categoria
            $sql = "DELETE FROM categorias WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$id]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao remover categoria: " . $e->getMessage());
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

    public function getDescricao()
    {
        return $this->descricao;
    }
}

?>