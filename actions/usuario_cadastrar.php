<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

// Importa a classe Categoria
require_once('../classes/Usuario_class.php');

// Valida e sanitiza os dados de entrada
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_SPECIAL_CHARS);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
$id_tipo = filter_input(INPUT_POST, 'tipo', FILTER_VALIDATE_INT);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($nome)) {
    header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_cadastro');
    exit;
}else if (empty($sobrenome)) {
    header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_cadastro');
    exit;
}else if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_cadastro');
    exit;
}else if (empty($senha)) {
    header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_cadastro');
    exit;
}else if (empty($id_tipo) || !in_array($id_tipo, [1, 2])) {
    header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_cadastro');
    exit;
}

try {
    if ($_SESSION['dados_usuario']['id_tipo'] == 1) {
        // Instancia a classe Categoria
        $u = new Usuario();

        // Tenta cadastrar a categoria
        $resultado = $u->cadastrar($nome, $sobrenome, $id_tipo, $email, $senha);

        if ($resultado) {
            // Sucesso no cadastro
            header('Location: ../gerenciar_usuarios.php?msg=cadastro_sucesso');
        } else {
            // Falha no cadastro (ex.: nome duplicado ou erro no banco)
            header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_cadastro');
        }
    }else {
        // Usuário não é administrador
        header('Location: ../home.php?erro=usuario_erro');
    }
} catch (Exception $e) {
    // Loga o erro (em produção, use um sistema de log como Monolog)
    error_log("Erro ao cadastrar categoria: " . $e->getMessage());
    header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_cadastro');
}

exit;
