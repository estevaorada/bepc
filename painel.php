<?php
require_once('includes/header.php');
$heading_title = "Perfil";
require_once('includes/heading_title.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php require_once('includes/sidemenu.php'); ?>
        </div>
        <div class="col-md-8">
            <img src="static/images/user-icon.png" alt="<?php echo htmlspecialchars($_SESSION['dados_usuario']['nome']); ?>" class="img-fluid mx-auto d-block mb-3 user-icon">
            <h5 class="display-5 text-center"> Olá, <?php echo htmlspecialchars($_SESSION['dados_usuario']['nome']); ?> <?php echo htmlspecialchars($_SESSION['dados_usuario']['sobrenome']); ?></h5>
            <p class="text-center">Bem-vindo ao seu painel de controle!<br> Aqui você pode gerenciar suas aulas, planos de aula e acessar as configurações do sistema.</p>
            <p class="text-center">Você está logado como: <strong><?php echo htmlspecialchars($_SESSION['dados_usuario']['email']); ?></strong><br>
                Tipo de usuário: <strong><?php echo htmlspecialchars($_SESSION['dados_usuario']['tipo']); ?></strong></p>

            <div class="container mt-3">
                <div class="border rounded p-4">
                    <h3 class="mb-4">Alterar Dados</h3>
                    <form method="post" action="actions/usuario_modificardados.php">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" value="<?php echo htmlspecialchars($_SESSION['dados_usuario']['nome']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="sobrenome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Digite o sobrenome" value="<?php echo htmlspecialchars($_SESSION['dados_usuario']['sobrenome']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Digite o email" value="<?php echo htmlspecialchars($_SESSION['dados_usuario']['email']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Modificar</button>
                    </form>
                </div>
            </div>

            <div class="container mt-3">
                <div class="border rounded p-4">
                    <h3 class="mb-4">Alterar Senha</h3>
                    <form id="alterarSenhaForm" onsubmit="validarFormulario(event)" method="post" action="actions/usuario_modificarsenha.php">
                        <div class="mb-3">
                            <label for="senhaAtual" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control" id="senhaAtual" name="senhaAtual" required placeholder="Digite a senha atual">
                        </div>
                        <div class="mb-3">
                            <label for="novaSenha" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="novaSenha" name="novaSenha" required placeholder="Digite a nova senha">
                            <div id="senhaForca" class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="repetirNovaSenha" class="form-label">Repita a Nova Senha</label>
                            <input type="password" class="form-control" id="repetirNovaSenha" name="repetirNovaSenha" required placeholder="Repita a nova senha">
                            <div id="senhaMatch" class="form-text text-danger"></div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Modificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

    <script>
        function validarFormulario(event) {
            event.preventDefault();
            const novaSenha = document.getElementById('novaSenha').value;
            const repetirNovaSenha = document.getElementById('repetirNovaSenha').value;
            const senhaForca = document.getElementById('senhaForca');
            const senhaMatch = document.getElementById('senhaMatch');

            // Limpa mensagens de erro
            senhaForca.textContent = '';
            senhaMatch.textContent = '';

            // Validação da força da senha
            const regex = /^(?=.*[a-zA-Z])(?=.*[!@#$%^&*()]).{6,}$/;
            if (!regex.test(novaSenha)) {
                senhaForca.textContent = 'A senha deve ter no mínimo 6 caracteres e incluir pelo menos um caractere especial (!@#$%^&*()).';
                return;
            }

            // Validação de correspondência das senhas
            if (novaSenha !== repetirNovaSenha) {
                senhaMatch.textContent = 'As senhas não coincidem.';
                return;
            }

            // Se passar nas validações, prosseguir com o envio do formulário
            document.getElementById('alterarSenhaForm').submit()
        }

        // Validação em tempo real para a força da senha
        document.getElementById('novaSenha').addEventListener('input', function () {
            const novaSenha = this.value;
            const senhaForca = document.getElementById('senhaForca');
            const regex = /^(?=.*[a-zA-Z])(?=.*[!@#$%^&*()]).{6,}$/;
            if (novaSenha && !regex.test(novaSenha)) {
                senhaForca.textContent = 'A senha deve ter no mínimo 6 caracteres e incluir pelo menos um caractere especial (!@#$%^&*()).';
            } else {
                senhaForca.textContent = '';
            }
        });

        // Validação em tempo real para correspondência das senhas
        document.getElementById('repetirNovaSenha').addEventListener('input', function () {
            const novaSenha = document.getElementById('novaSenha').value;
            const repetirNovaSenha = this.value;
            const senhaMatch = document.getElementById('senhaMatch');
            if (repetirNovaSenha && novaSenha !== repetirNovaSenha) {
                senhaMatch.textContent = 'As senhas não coincidem.';
            } else {
                senhaMatch.textContent = '';
            }
        });
    </script>

<?php
require_once('includes/footer.php');
?>