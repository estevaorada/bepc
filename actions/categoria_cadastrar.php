<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

// Importa a classe Categoria
require_once('../classes/Categoria_class.php');

// Valida e sanitiza os dados de entrada
$nomeCategoria = filter_input(INPUT_POST, 'nomeCategoria', FILTER_SANITIZE_SPECIAL_CHARS);
$descricaoCategoria = filter_input(INPUT_POST, 'descricaoCategoria', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($nomeCategoria)) {
    header('Location: ../gerenciar_categorias.php?erro=categoria_erro');
    exit;
}

try {
    if ($_SESSION['dados_usuario']['id_tipo'] == 1) {
        // Instancia a classe Categoria
        $c = new Categoria();

        // Tenta cadastrar a categoria
        $resultado = $c->cadastrar($nomeCategoria, $descricaoCategoria);

        if ($resultado) {
            // Sucesso no cadastro
            header('Location: ../gerenciar_categorias.php?msg=cadastro_sucesso');
        } else {
            // Falha no cadastro (ex.: nome duplicado ou erro no banco)
            header('Location: ../gerenciar_categorias.php?erro=categoria_erro');
        }
    }else {
        // Usuário não é administrador
        header('Location: ../gerenciar_categorias.php?erro=usuario_erro');
    }
} catch (Exception $e) {
    // Loga o erro (em produção, use um sistema de log como Monolog)
    error_log("Erro ao cadastrar categoria: " . $e->getMessage());
    header('Location: ../gerenciar_categorias.php?erro=categoria_erro');
}

exit;
