<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

// Importa a classe Categoria
require_once('../classes/Carrinho_class.php');

// Valida e sanitiza os dados de entrada
$id_aula = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($id_aula)) {
    header('Location: ../home.php?msg=id_vazio');
    exit;
}

try {

    // Instancia a classe Carrinho
    $c = new Carrinho();

    // Tenta inserir no carrinho
    $resultado = $c->cadastrar($_SESSION['dados_usuario']['id'], $id_aula);

    if ($resultado) {
        // Sucesso na inserção
        header('Location: ../carrinho.php?msg=add_ok');
    } else {
        // Falha na inserção
        header('Location: ../carrinho.php?msg=falha_add');
    }
} catch (Exception $e) {
    // Loga o erro (em produção, use um sistema de log como Monolog)
    error_log("Erro ao inserir no carrinho: " . $e->getMessage());
    header('Location: ../carrinho.php?msg=falha_add');
}

exit;
