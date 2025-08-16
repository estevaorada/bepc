<?php
session_start();
// Verifica se o usuário está autenticado e se a requisição é GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

/*
    * Script para apagar uma aula, curso, categoria, disciplina ou nível
apagar.php?tipo=aula&id=1
apagar.php?tipo=curso&id=1
apagar.php?tipo=categoria&id=1
apagar.php?tipo=disciplina&id=1
apagar.php?tipo=nivel&id=1
*/

// Verifica se o tipo e o ID foram fornecidos
if (!isset($_GET['tipo']) || !isset($_GET['id'])) {
    header('Location: index.php?msg=0');
    exit;
}

$tipo = $_GET['tipo'];
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
    header('Location: index.php?msg=0');
    exit;
}
// Importa a classe correspondente ao tipo
switch ($tipo) {
    case 'aula':
        require_once('../classes/Aula_class.php');
        $objeto = new Aula();
        break;
    case 'curso':
        require_once('../classes/Curso_class.php');
        $objeto = new Curso();
        break;
    case 'categoria':
        require_once('../classes/Categoria_class.php');
        $objeto = new Categoria();
        break;
    case 'disciplina':
        require_once('../classes/Disciplina_class.php');
        $objeto = new Disciplina();
        break;
    case 'nivel':
        require_once('../classes/Nivel_class.php');
        $objeto = new Nivel();
        break;
    default:
        header('Location: index.php?msg=0');
        exit;
}

// Continuar...


?>