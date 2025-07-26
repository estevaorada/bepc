<?php

require_once('database/Banco_class.php');

class Carrinho
{


    public function cadastrar($id_usuario, $id_aula)
    {
        // Validação de entrada
        if (empty($id_usuario) || !is_numeric($id_usuario) || !is_numeric($id_aula) || empty($id_aula)) {
            return false;
        }

        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            // Insere no carrinho do usuário
            $sql = "INSERT INTO carrinho (id_usuario, id_aula) VALUES (?, ?)";
            $comando = $banco->prepare($sql);
            $result = $comando->execute([$id_usuario, $id_aula]);

            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao inserir no carrinho: " . $e->getMessage());
            return false;
        }
    }

    public function listar($id_usuario = null)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return null;
        }

        try {
            if (is_null($id_usuario)) {
                return null;
            } else {
                // Lista uma categoria específica por ID
                if (!is_numeric($id_usuario) || $id_usuario <= 0) {
                    return null;
                }
                $sql = "SELECT c.id, c.id_aula AS id_aula, a.titulo, a.descricao FROM carrinho c
                INNER JOIN aulas a
                ON c.id_aula = a.id
                WHERE c.id_usuario = ?";
                $comando = $banco->prepare($sql);
                $comando->execute([$id_usuario]);
                $carrinho = $comando->fetchAll(PDO::FETCH_ASSOC);
                if ($carrinho) {
                    // Remover tags HTML da descrição
                    
                   
                        foreach ($carrinho as &$item) {
                            //print_r($item);
                            $item['descricao'] = substr(strip_tags($item['descricao']), 0, 100);
                        }
                  

                    return $carrinho;
                }
                return null;
            }
        } catch (PDOException $e) {
            error_log("Erro ao listar aulas do carrinho: " . $e->getMessage());
            return null;
        }
    }

    public function limparCarrinho($id_usuario)
    {
        $banco = Banco::conectar();
        if (!$banco) {
            return false;
        }

        try {
            $sql = "DELETE FROM carrinho WHERE id_usuario = ?";
            $comando = $banco->prepare($sql);
            return $comando->execute([$id_usuario]);
        } catch (PDOException $e) {
            error_log("Erro ao limpar carrinho: " . $e->getMessage());
            //echo $e->getMessage();
            return false;
        }
    }
}
