<!-- 
                             /`\
                            / : |
                   _.._     | '/
                 /`    \    | /
                |  .-._ '-"` (
                |_/   /   o  o\
                      |  =  () )=
                       \  '--`/
                       / ---<`
                      | ,    \\
                      | |     \\__
                      / ;     |.__)
                     (_/.-.   ;
                    { `|   \_/
                     '-\   / |
                        | /  |
                       /  \  '-.
                       \__|----'
        parabéns jovem, você encontrou o coelho da sorte,
        agora retorne ao seu trabalho.
                   -->
<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    // Redireciona para a página de login se não estiver autenticado
    header('Location: index.php?erro=1');
    exit;
}
require_once('classes/Categoria_class.php');
$categoria = new Categoria();
$categorias = $categoria->listar();

require_once('classes/Curso_class.php');
$curso = new Curso();
$cursos = $curso->listar();

require_once('classes/Nivel_class.php');
$nivel = new Nivel();
$niveis = $nivel->listar();


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>bepc :: <?php echo isset($heading_title) ? $heading_title : "Compartilhe planos de aula" ?></title>
    <link href="static/images/favicon.png" rel="icon" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <img src="static/images/logo.png" alt="bepc Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Início</a>
                    </li>
                    <!-- Dropdown Categorias -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriasDropdown">
                            <?php
                            $categorias = $categoria->listar(null, 10);
                            if (is_null($categorias)) {
                                echo '<li><a class="dropdown-item" href="#">Erro ao carregar categorias</a></li>';
                            } elseif (empty($categorias)) {
                                echo '<li><a class="dropdown-item" href="#">Nenhuma categoria encontrada</a></li>';
                            } else {
                                // Gera a lista de categorias
                                foreach ($categorias as $cat) {
                            ?>
                                    <li><a class="dropdown-item" href="aulas_listar.php?categoria=<?= $cat['id']; ?>"><?= $cat['nome'] ?></a></li>
                            <?php
                                }
                            }
                            ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="aulas_listar.php">Ver todas</a></li>
                        </ul>
                    </li>
                    <!-- Dropdown Cursos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="cursosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cursos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="cursosDropdown">
                            <?php
                            $cursos = $curso->listar(NULL, 10);
                            if (is_null($cursos)) {
                                echo '<li><a class="dropdown-item" href="#">Erro ao carregar cursos</a></li>';
                            } elseif (empty($cursos)) {
                                echo '<li><a class="dropdown-item" href="#">Nenhum curso encontrado</a></li>';
                            } else {
                                // Gera a lista de categorias
                                foreach ($cursos as $cur) {
                            ?>
                                    <li><a class="dropdown-item" href="aulas_listar.php?curso=<?= $cur['id']; ?>"><?= $cur['nome'] ?></a></li>
                            <?php
                                }
                            }
                            ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="aulas_listar.php">Ver todos</a></li>
                        </ul>
                    </li>
                    <!-- Dropdown Níveis -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="niveisDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Níveis
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="niveisDropdown">
                            <?php
                            if (is_null($niveis)) {
                                echo '<li><a class="dropdown-item" href="#">Erro ao carregar niveis</a></li>';
                            } elseif (empty($niveis)) {
                                echo '<li><a class="dropdown-item" href="#">Nenhum nivel encontrado</a></li>';
                            } else {
                                // Gera a lista de categorias
                                foreach ($niveis as $ni) {
                            ?>
                                    <li><a class="dropdown-item" href="cursos_listar.php?nivel=<?= $ni['id']; ?>"><?= $ni['nome'] ?></a></li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex me-2">
                    <input class="form-control me-2" id="busca_topo" name="busca_topo" type="search" placeholder="Buscar aulas..." aria-label="Buscar aulas">
                </form>
                <div class="grupo-botoes mt-2 mt-sm-2 mt-md-0 d-flex align-items-center">
                    <a class="btn btn-outline-secondary me-2" href="aulas_criar.php">+ Criar Aula</a>
                    <a href="carrinho.php" class="btn btn-dark"><i class="bi bi-basket2"></i></a>
                    <!-- Dropdown Usuário -->
                    <div class="dropdown ms-2">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="usuarioDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['dados_usuario']['nome']); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                            <li><a class="dropdown-item" href="painel.php">Perfil</a></li>
                            <li><a class="dropdown-item" href="aulas_minhas.php">Minhas Aulas</a></li>
                            <li><a class="dropdown-item" href="planos_listar.php">Meus Planos de Aula</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="sair.php">Sair</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>