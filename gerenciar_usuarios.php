<?php
$heading_title = "Gerenciar Usuários";
require_once('includes/header.php');
require_once('includes/heading_title.php');
// Verifica se o usuário é administrador: 
if ($_SESSION['dados_usuario']['id_tipo'] == 1) {
?>


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php require_once('includes/sidemenu.php'); ?>
            </div>
            <div class="col-md-8 mt-3">
                <!-- Botão alinhado à direita acima dos cards -->
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#cadastroUsuarioModal">
                        <i class="bi bi-plus-circle-fill"></i> Cadastrar Usuário
                    </button>
                </div>

                <?php
                require_once('classes/Usuario_class.php');
                $usuario = new Usuario();

                if (isset($_GET['ativo']) && $_GET['ativo'] == 0) {
                    $usuarios = $usuario->listarTodos($_SESSION['dados_usuario']['id_tipo'], 0);
                    $inativo = true;
                } else {
                    $usuarios = $usuario->listarTodos($_SESSION['dados_usuario']['id_tipo'], 1);
                    $inativo = false;
                }

                foreach ($usuarios as $us) {
                    $dataCadastro = date('d/m/Y', strtotime($us['data_cadastro']));
                    $situacao = $us['situacao'] ? 'Ativo' : 'Inativo';
                ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-12 col-md-4">
                                    <strong>ID:</strong> <?= $us['id'] ?>
                                </div>
                                <div class="col-12 col-md-4">
                                    <strong>Nome:</strong> <?= htmlspecialchars($us['nome']) ?>
                                </div>
                                <div class="col-12 col-md-4">
                                    <strong>Sobrenome:</strong> <?= htmlspecialchars($us['sobrenome']) ?>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12 col-md-4">
                                    <strong>Email:</strong> <?= htmlspecialchars($us['email']) ?>
                                </div>
                                <div class="col-12 col-md-4">
                                    <strong>Tipo:</strong> <?= htmlspecialchars($us['tipo_nome']) ?>
                                </div>
                                <div class="col-12 col-md-4">
                                    <strong>Situação:</strong> <?= $situacao ?>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-12 col-md-6">
                                    <strong>Cadastro:</strong> <?= $dataCadastro ?>
                                </div>
                                <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                                    <?php if(!$inativo) { ?>
                                    <?php if($us['id'] != $_SESSION['dados_usuario']['id']) { ?>
                                    <a class="btn btn-danger btn-sm me-2" href="actions/usuario_desativar.php?id=<?= $us['id'] ?>">
                                        <i class="bi bi-x"></i>
                                    </a>
                                    <?php } ?>
                                    <a class="btn btn-dark btn-sm" href="actions/usuario_editar.php?id=<?= $us['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>


                <?php
                if (isset($_GET['ativo']) && $_GET['ativo'] == 0) {
                ?>
                    <a type="button" class="btn btn-success btn-sm float-end" href="gerenciar_usuarios.php">Listar usuários ativos</a>
                <?php
                } else {
                ?>
                    <a type="button" class="btn btn-secondary btn-sm float-end" href="gerenciar_usuarios.php?ativo=0">Listar usuários inativos</a>
                <?php
                }
                ?>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="cadastroUsuarioModal" tabindex="-1" aria-labelledby="cadastroUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroUsuarioModalLabel">Cadastro de Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cadastroForm" method="post" action="actions/usuario_cadastrar.php">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required placeholder="Digite o nome">
                        </div>
                        <div class="mb-3">
                            <label for="sobrenome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" required placeholder="Digite o sobrenome">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Digite o email">
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="senha" name="senha" required placeholder="Digite a senha">
                                <button type="button" class="btn btn-outline-secondary" onclick="gerarSenha()">Gerar Senha</button>
                            </div>
                            <small class="form-text text-muted">Anote essa senha</small>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" required name="tipo">
                                <option value="" disabled selected>Selecione o tipo</option>
                                <option value="1">Coordenador</option>
                                <option value="2">Docente</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark w-100" onclick="document.getElementById('cadastroForm').requestSubmit()">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function gerarSenha() {
            const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
            let senha = '';
            for (let i = 0; i < 12; i++) {
                senha += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
            document.getElementById('senha').value = senha;
        }
    </script>

<?php
} else {
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php require_once('includes/sidemenu.php'); ?>
            </div>
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert">Acesso negado! Você não tem permissão para acessar esta página.</div>
            </div>
        </div>

    </div>

<?php
}
require_once('includes/footer.php');
?>