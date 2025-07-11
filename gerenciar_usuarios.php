<?php
require_once('includes/header.php');
$heading_title = "Gerenciar Usuários";
require_once('includes/heading_title.php');
// Verifica se o usuário é administrador: 
if ($_SESSION['dados_usuario']['id_tipo'] == 1) {
?>


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php require_once('includes/sidemenu.php'); ?>
            </div>
            <div class="col-md-8">
                <button type="button" class="btn btn-dark mb-3 float-end" data-bs-toggle="modal" data-bs-target="#cadastroUsuarioModal">
                    <i class="bi bi-plus-circle-fill"></i> Cadastrar Usuário
                </button>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Data de Cadastro</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once('classes/Usuario_class.php');
                        $usuario = new Usuario();
                        if (isset($_GET['ativo']) && $_GET['ativo'] == 0) {
                            // Listar usuários inativos
                            $usuarios = $usuario->listarTodos($_SESSION['dados_usuario']['id_tipo'], 0);
                        } else {
                            // Listar usuários ativos
                            $usuarios = $usuario->listarTodos($_SESSION['dados_usuario']['id_tipo'], 1);
                        }
                        foreach ($usuarios as $us) {
                        ?>
                            <tr>
                                <th scope="row"><?= $us['id'] ?></th>
                                <td><?= $us['nome'] ?></td>
                                <td><?= $us['sobrenome'] ?></td>
                                <td><?= $us['email'] ?></td>
                                <td><?= $us['tipo_nome'] ?></td>
                                <td><?= $us['situacao'] ? 'Ativo' : 'Inativo' ?></td>
                                <td><?= date('d/m/Y', strtotime($us['data_cadastro'])) ?></td>

                                <td>
                                    <a type="button" class="btn btn-danger me-2" href="actions/usuario_desativar.php?id=<?= $us['id'] ?>">
                                        <i class="bi bi-x"></i>
                                    </a>
                                    <a type="button" class="btn btn-dark" href="actions/usuario_desativar.php?id=<?= $us['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
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