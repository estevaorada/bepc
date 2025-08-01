<?php
session_start();

// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

// Importa a classe Usuario
require_once('../classes/Usuario_class.php');

// Valida e sanitiza os dados de entrada
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($nome)) {
    header('Location: ../painel.php?erro=usuario_erro_modificacao');
    exit;
} elseif (empty($sobrenome)) {
    header('Location: ../painel.php?erro=usuario_erro_modificacao');
    exit;
} elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../painel.php?erro=usuario_erro_modificacao');
    exit;
}

try {
    // Instancia a classe Usuario
    $u = new Usuario();

    // Obtém os dados do usuário logado da sessão
    $idUsuarioLogado = isset($_SESSION['dados_usuario']['id']) ? $_SESSION['dados_usuario']['id'] : 0;
    $idTipoUsuario = isset($_SESSION['dados_usuario']['id_tipo']) ? $_SESSION['dados_usuario']['id_tipo'] : 0;

    // Modifica os dados pessoais do próprio usuário
    $resultado = $u->modificarDadosPessoais($idUsuarioLogado, $idTipoUsuario, $idUsuarioLogado, $nome, $sobrenome, $email);

    if ($resultado) {
        // Sucesso na modificação
        $_SESSION['dados_usuario']['nome'] = $nome;
        $_SESSION['dados_usuario']['sobrenome'] = $sobrenome;
        $_SESSION['dados_usuario']['email'] = $email;
        header('Location: ../painel.php?msg=modificacao_sucesso');
    } else {
        // Falha na modificação (ex.: permissão negada ou erro no banco)
        header('Location: ../painel.php?erro=usuario_erro_modificacao');
    }
} catch (Exception $e) {
    // Loga o erro (em produção, use um sistema de log como Monolog)
    error_log("Erro ao modificar dados pessoais: " . $e->getMessage());
    header('Location: ../painel.php?erro=usuario_erro_modificacao');
}

exit;
?>