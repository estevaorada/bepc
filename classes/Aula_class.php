<?php
require_once('database/Banco_class.php');

class Aula
{
    private $id;
    private $id_usuario;
    private $id_disciplina;
    private $titulo;
    private $data_cadastrada;
    private $descricao;
    private $observacoes;
    private $id_categoria;

    /**
     * Lista aulas com filtros opcionais por id_usuario, id_disciplina ou id_curso.
     * @param int|null $idUsuario Filtro por ID do usuário
     * @param int|null $idDisciplina Filtro por ID da disciplina
     * @param int|null $idCurso Filtro por ID do curso
     * @return array|null Retorna um array com as aulas ou null em caso de erro
     */
    public function listar($idUsuario = null, $idDisciplina = null, $idCurso = null, $idAula = null)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            if ($idAula == null) {
            $sql = "SELECT a.id, a.titulo, a.id_usuario, a.id_disciplina, a.data_cadastrada, SUBSTRING(a.descricao,1,300) AS 'descricao', a.id_categoria, a.observacoes,
                           u.nome AS usuario_nome, u.sobrenome AS 'usuario_sobrenome' , d.nome AS disciplina_nome, c.nome AS categoria_nome
                    FROM aulas a
                    INNER JOIN usuarios u ON a.id_usuario = u.id
                    INNER JOIN disciplinas d ON a.id_disciplina = d.id
                    INNER JOIN categorias c ON a.id_categoria = c.id
                    WHERE (:idUsuario IS NULL OR a.id_usuario = :idUsuario1)
                    AND (:idDisciplina IS NULL OR a.id_disciplina = :idDisciplina1)
                    AND (:idAula IS NULL OR a.id = :idAula1)";
            } else {
            $sql = "SELECT a.id, a.titulo, a.id_usuario, a.id_disciplina, a.data_cadastrada, a.descricao, a.id_categoria, a.observacoes,
                           u.nome AS usuario_nome, u.sobrenome AS 'usuario_sobrenome' , d.nome AS disciplina_nome, c.nome AS categoria_nome
                    FROM aulas a
                    INNER JOIN usuarios u ON a.id_usuario = u.id
                    INNER JOIN disciplinas d ON a.id_disciplina = d.id
                    INNER JOIN categorias c ON a.id_categoria = c.id
                    WHERE (:idUsuario IS NULL OR a.id_usuario = :idUsuario1)
                    AND (:idDisciplina IS NULL OR a.id_disciplina = :idDisciplina1)
                    AND (:idAula IS NULL OR a.id = :idAula1)";
            }
            $comando = $banco->prepare($sql);

            $comando->execute([
                ':idUsuario' => $idUsuario,
                ':idDisciplina' => $idDisciplina,
                ':idUsuario1' => $idUsuario,
                ':idDisciplina1' => $idDisciplina,
                ':idAula1' => $idAula,
                'idAula' => $idAula
            ]);
            $aulas = $comando->fetchAll(PDO::FETCH_ASSOC);
            if ($idAula == null) {
                // Remover tags HTML da descrição
                foreach ($aulas as &$item) {
                    $item['descricao'] = substr(strip_tags($item['descricao']), 0, 100);
                }
            }
            return $aulas;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            error_log("Erro ao listar aulas: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Apaga uma aula específica.
     * Apenas administradores (id_tipo == 1) ou o criador da aula podem apagar.
     * @param int $idAula ID da aula a ser apagada
     * @param int $idUsuarioLogado ID do usuário logado
     * @param int $idTipoUsuario Tipo do usuário logado
     * @return bool Retorna true se a exclusão for bem-sucedida, false caso contrário
     */
    public function apagar($idAula, $idUsuarioLogado, $idTipoUsuario)
    {
        if (!is_numeric($idAula) || $idAula <= 0 || !is_numeric($idUsuarioLogado) || !is_numeric($idTipoUsuario)) {
            return false;
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            $sql = "SELECT id_usuario FROM aulas WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$idAula]);
            $aula = $comando->fetch(PDO::FETCH_ASSOC);

            if (!$aula) {
                return false;
            }

            if ($idTipoUsuario != 1 && $aula['id_usuario'] != $idUsuarioLogado) {
                return false;
            }

            $sql = "DELETE FROM aulas WHERE id = ?";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$idAula]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao apagar aula: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Edita uma aula específica.
     * Apenas administradores (id_tipo == 1) ou o criador da aula podem editar.
     * @param int $idAula ID da aula a ser editada
     * @param int $idUsuarioLogado ID do usuário logado
     * @param int $idTipoUsuario Tipo do usuário logado
     * @param string $dataAula Nova data da aula
     * @param string $conteudo Novo conteúdo da aula
     * @return bool Retorna true se a edição for bem-sucedida, false caso contrário
     */
    public function editar($idAula, $idUsuarioLogado, $idTipoUsuario, $dataAula, $conteudo)
    {
        // implementar!
    }

    /**
     * Cadastra uma nova aula.
     * @param int $idUsuarioLogado ID do usuário logado que está cadastrando
     * @param int $idDisciplina ID da disciplina
     * @param int $idCurso ID do curso
     * @param string $dataAula Data da aula
     * @param string $conteudo Conteúdo da aula
     * @return bool Retorna true se o cadastro for bem-sucedido, false caso contrário
     */
    public function cadastrar($idUsuarioLogado, $idDisciplina, $titulo, $descricao, $observacoes, $idCategoria)
    {
        if (
            !is_numeric($idUsuarioLogado) || !is_numeric($idDisciplina) || !is_numeric($idCategoria) ||
            $idUsuarioLogado <= 0 || $idDisciplina <= 0 || empty($titulo) || empty($descricao)
        ) {
            return false;
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Verifica se a disciplina e o curso existem (opcional, pode ser ajustado)
            $sql = "SELECT COUNT(*) FROM disciplinas WHERE id = ?";
            $comando = $banco->prepare($sql);
            $comando->execute([$idDisciplina]);
            if ($comando->fetchColumn() == 0) return false;
            // Insere a nova aula
            $sql = "INSERT INTO aulas (titulo, descricao, observacoes, id_usuario, id_disciplina, id_categoria) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([
                $titulo,
                $descricao,
                $observacoes,
                $idUsuarioLogado,
                $idDisciplina,
                $idCategoria
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar aula: " . $e->getMessage());
            echo 1;
            return false;
        }
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getIdDisciplina()
    {
        return $this->id_disciplina;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDataCadastrada()
    {
        return $this->data_cadastrada;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }
    public function getObservacoes()
    {
        return $this->observacoes;
    }
    public function getIdCategoria()
    {
        return $this->id_categoria;
    }
}
