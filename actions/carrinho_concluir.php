<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}


// lembrar de limpar o localStorage quando concluir o plano de aula (se der certo)

?>