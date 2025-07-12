<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

// Importa a classe Categoria
require_once('../classes/Disciplina_class.php');

// Valida e sanitiza os dados de entrada
$nomeDisciplina = filter_input(INPUT_POST, 'nomeDisciplina', FILTER_SANITIZE_SPECIAL_CHARS);
$idCurso = filter_input(INPUT_POST, 'idCurso', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($nomeDisciplina) || empty($idCurso)) {
    header('Location: ../gerenciar_disciplinas.php?msg=erro_nome_vazio');
    exit;
}

try {
    if ($_SESSION['dados_usuario']['id_tipo'] == 1) {
        // Instancia a classe Categoria
        $d = new Disciplina();

        // Tenta cadastrar a categoria
        $resultado = $d->cadastrar($nomeDisciplina, $idCurso);

        if ($resultado) {
            // Sucesso no cadastro
            header('Location: ../gerenciar_disciplinas.php?msg=cadastro_sucesso');
        } else {
            // Falha no cadastro (ex.: nome duplicado ou erro no banco)
            header('Location: ../gerenciar_disciplinas.php?msg=erro_cadastro');
        }
    }else {
        // Usuário não é administrador
        header('Location: ../gerenciar_disciplinas.php?msg=acesso_negado');
    }
} catch (Exception $e) {
    // Loga o erro (em produção, use um sistema de log como Monolog)
    error_log("Erro ao cadastrar disciplina: " . $e->getMessage());
    header('Location: ../gerenciar_disciplinas.php?msg=erro_sistema');
}

exit;
