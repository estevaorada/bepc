<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    require_once('../classes/Usuario_class.php');
    $u = new Usuario();

    $resultado = $u->Logar($_POST['email'], $_POST['senha']);
    // Verificar se existem linhas no resultado:
    if(!is_null($resultado)){
        session_start();
        //print_r($resultado);
        $_SESSION['autenticado'] = true;
        // Criar a sessão com os dados vindos do BD:
        $_SESSION['dados_usuario'] = $resultado;
        //print_r($_SESSION['dados_usuario']);
        // Redirecionar:
        header("Location: ../index.php");
        exit();
    }else{
        //echo "Usuário ou senha inválidos!";
        header('Location: ../index.php?erro=0');
        exit();
    }
}else{
    echo "A página deve ser carregada por POST!";
}
?>