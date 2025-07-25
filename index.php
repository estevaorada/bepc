<?php
session_start();
// Verifica se o usuário já está autenticado
if (isset($_SESSION['autenticado'])) {
    // Redireciona para a página de início se estiver autenticado
    header('Location: home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bepc :: Login</title>
    <link href="static/images/favicon.png" rel="icon" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        /* CSS de uso exclusivo da tela de login */
        body {
            min-height: 100vh;
            background: url('static/images/login-bg1.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        .blur-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            backdrop-filter: blur(15px);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .form-control {
            border: 1px solid #000;
        }

        .btn-outline-dark {
            border-color: #000;
            color: #000;
        }

        .btn-outline-dark:hover {
            background-color: #000;
            color: #fff;
        }
    </style>
</head>

<body>
    <!--<div class="blur-bg"></div>-->
    <div class="container d-flex align-items-center justify-content-center vh-100 ">
        <div class="login-container rounded-3 shadow p-4 blur-bg animate__animated animate__fadeInDown">
            <img src="static/images/logo.png" alt="Logotipo Bepc" class="mb-4" />
            <!-- <h3 class="text-center mb-4">Login</h3> -->
            <form action="actions/usuario_logar.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu e-mail">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" id="password" placeholder="Digite sua senha">
                </div>
                <button type="submit" class="btn btn-outline-dark w-100 mt-3">Entrar</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>