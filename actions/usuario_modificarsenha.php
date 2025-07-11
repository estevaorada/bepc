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
$senhaAtual = filter_input(INPUT_POST, 'senhaAtual', FILTER_SANITIZE_SPECIAL_CHARS);
$novaSenha = filter_input(INPUT_POST, 'novaSenha', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($senhaAtual)) {
    header('Location: ../painel.php?msg=erro_senha_atual_vazia');
    exit;
} elseif (empty($novaSenha) || strlen($novaSenha) < 6) {
    header('Location: ../painel.php?msg=erro_nova_senha_invalida');
    exit;
} elseif ($novaSenha !== filter_input(INPUT_POST, 'repetirNovaSenha', FILTER_SANITIZE_SPECIAL_CHARS)) {
    header('Location: ../painel.php?msg=erro_senha_nao_confere');
    exit;
}

try {
    // Instancia a classe Usuario
    $u = new Usuario();

    // Obtém os dados do usuário logado da sessão
    $idUsuarioLogado = isset($_SESSION['dados_usuario']['id']) ? $_SESSION['dados_usuario']['id'] : 0;
    $idTipoUsuario = isset($_SESSION['dados_usuario']['id_tipo']) ? $_SESSION['dados_usuario']['id_tipo'] : 0;

    // Modifica a senha do próprio usuário
    $resultado = $u->modificarSenha($idUsuarioLogado, $idTipoUsuario, $idUsuarioLogado, $senhaAtual, $novaSenha);

    if ($resultado) {
        // Sucesso na modificação
        header('Location: ../painel.php?msg=senha_modificada_sucesso');
    } else {
        // Falha na modificação (ex.: permissão negada ou senha atual incorreta)
        header('Location: ../painel.php?msg=erro_modificacao_senha');
    }
} catch (Exception $e) {
    // Loga o erro (em produção, use um sistema de log como Monolog)
    error_log("Erro ao modificar senha: " . $e->getMessage());
    header('Location: ../painel.php?msg=erro_sistema');
}

exit;
?>