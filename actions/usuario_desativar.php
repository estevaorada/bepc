<?php

session_start();
print_r($_SESSION);
// Verifica se o usuário está autenticado e se a requisição é GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    //header('Location: ../index.php?erro=login');
    echo 'erro login';
    exit;
}

// Verifica se o usuário tem permissão para desativar usuários
if (!isset($_SESSION['dados_usuario']['id_tipo']) || $_SESSION['dados_usuario']['id_tipo'] != 1) {
    echo 'erro id';
    
    //header('Location: ../index.php?erro=usuario_erro');
    exit;
}

// Verifica se o ID do usuário a ser desativado foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    //header('Location: ../index.php?erro=erro');
    echo 'erro id param';
    exit;
}

$id_usuario = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id_usuario) {
    echo 'erro id invalid';
    //header('Location: ../index.php?erro=erro');
    exit;
}

require_once('../classes/Usuario_class.php');
$usuario = new Usuario();
$resultado = $usuario->desativar($_SESSION['dados_usuario']['id_tipo'], $id_usuario);
print_r($resultado);

if ($resultado) {
    header('Location: ../gerenciar_usuarios.php?msg=usuario_desativado');
    exit;
} else {
    //header('Location: ../gerenciar_usuarios.php?erro=usuario_erro_desativar');
    exit;
}


?>