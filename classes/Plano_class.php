<?php
require_once('database/Banco_class.php');

class Plano
{

    public function criarPlano($id_usuario = null, $titulo = null, $id_disciplina = null){
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }
        if (is_null($id_usuario) || is_null($titulo) || is_null($id_disciplina)) {
            return null; // Retorna null se algum parâmetro obrigatório estiver faltando
            
        }
        try {
            $sql = "INSERT INTO planos (id_usuario, titulo, id_disciplina) VALUES (:id_usuario, :titulo, :id_disciplina)";
            $comando = $banco->prepare($sql);
            $comando->execute([
                ':id_usuario' => $id_usuario,
                ':titulo' => $titulo,
                ':id_disciplina' => $id_disciplina
            ]);
            return $banco->lastInsertId(); // Retorna o ID do plano criado
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null; // Retorna null em caso de erro
        }
    }
    /**
     * Método para listar planos de aula
     * @param int|null $id_usuario ID do usuário logado (opcional)
     * @return array Lista de planos de aula
     */
    public function listarPlanos($id_usuario = null)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }
        if (is_null($id_usuario)) {
            return null; // Retorna null se o ID do usuário não for fornecido
        }
        try {
            $sql = "SELECT p.id, p.titulo, p.data_cadastrada, u.nome AS usuario_nome, u.sobrenome AS usuario_sobrenome
                    FROM planos p
                    INNER JOIN usuarios u ON p.id_usuario = u.id
                    WHERE (:id_usuario IS NULL OR p.id_usuario = :id_usuario)
                    ORDER BY p.data_cadastrada DESC";
            $comando = $banco->prepare($sql);
            $comando->execute([':id_usuario' => $id_usuario]);
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null; // Retorna null em caso de erro
        }
    }
    /**
     * Método para obter detalhes de um plano específico
     * @param int $id_plano ID do plano
     * @return array Detalhes do plano
     */
    public function obterPlano($id_plano)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }
        if (is_null($id_plano)) {
            return null; // Retorna null se o ID do plano não for fornecido
        }
        try {
            $sql = "SELECT p.id, p.titulo, p.data_cadastrada, u.nome AS usuario_nome, u.sobrenome AS usuario_sobrenome
                    FROM planos p
                    INNER JOIN usuarios u ON p.id_usuario = u.id
                    WHERE p.id = :id_plano";
            $comando = $banco->prepare($sql);
            $comando->execute([':id_plano' => $id_plano]);
            return $comando->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null; // Retorna null em caso de erro
        }
    }
    /**
     * Método para excluir um plano de aula
     * @param int $id_plano ID do plano a ser excluído
     * @return bool Retorna true se a exclusão for bem-sucedida, false caso contrário
     */
    public function excluirPlano($id_plano)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return false; // Retorna false se não conseguir conectar ao banco
        }
        if (is_null($id_plano)) {
            return false; // Retorna false se o ID do plano não for fornecido
        }
        try {
            $sql = "DELETE FROM planos WHERE id = :id_plano";
            $comando = $banco->prepare($sql);
            $comando->execute([':id_plano' => $id_plano]);
            return true; // Retorna true se a exclusão for bem-sucedida
        } catch (PDOException $e) {
            return false; // Retorna false em caso de erro
        }
    }
    /**
     * Metodo para adicionar uma aula ao plano
     * @param int $id_plano ID do plano
     * @param int $id_aula ID da aula a ser adicionada
     * @return bool Retorna true se a adição for bem-sucedida, false caso contrário
     * 
     */
    public function adicionarAulaAoPlano($id_plano, $id_aula)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return false; // Retorna false se não conseguir conectar ao banco
        }
        if (is_null($id_plano) || is_null($id_aula)) {
            return false; // Retorna false se o ID do plano ou da aula não for fornecido
        }
        try {
            $sql = "INSERT INTO aulas_planos (id_plano, id_aula) VALUES (:id_plano, :id_aula)";
            $comando = $banco->prepare($sql);
            $comando->execute([':id_plano' => $id_plano, ':id_aula' => $id_aula]);
            return true; // Retorna true se a adição for bem-sucedida
        } catch (PDOException $e) {
            return false; // Retorna false em caso de erro
        }
    }
}

?>