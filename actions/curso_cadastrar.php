<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

// Importa a classe Categoria
require_once('../classes/Curso_class.php');

// Valida e sanitiza os dados de entrada
$nomeCurso = filter_input(INPUT_POST, 'nomeCurso', FILTER_SANITIZE_SPECIAL_CHARS);
$nivelCurso = filter_input(INPUT_POST, 'nivelCurso', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($nomeCurso) || empty($nivelCurso)) {
    header('Location: ../gerenciar_cursosniveis.php?msg=erro_nome_vazio');
    exit;
}

try {
    if ($_SESSION['dados_usuario']['id_tipo'] == 1) {
        // Instancia a classe Categoria
        $c = new Curso();

        // Tenta cadastrar a categoria
        $resultado = $c->cadastrar($nomeCurso, $nivelCurso);

        if ($resultado) {
            // Sucesso no cadastro
            header('Location: ../gerenciar_cursosniveis.php?msg=cadastro_sucesso');
        } else {
            // Falha no cadastro (ex.: nome duplicado ou erro no banco)
            header('Location: ../gerenciar_cursosniveis.php?msg=erro_cadastro');
        }
    }else {
        // Usuário não é administrador
        header('Location: ../gerenciar_cursosniveis.php?msg=acesso_negado');
    }
} catch (Exception $e) {
    // Loga o erro (em produção, use um sistema de log como Monolog)
    error_log("Erro ao cadastrar curso: " . $e->getMessage());
    header('Location: ../gerenciar_cursosniveis.php?msg=erro_sistema');
}

exit;
