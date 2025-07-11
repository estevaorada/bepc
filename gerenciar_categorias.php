<?php
require_once('includes/header.php');
$heading_title = "Gerenciar Categorias";
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
                <button type="button" class="btn btn-dark float-end mb-3" data-bs-toggle="modal" data-bs-target="#categoriaModal">
                    <i class="bi bi-plus-circle-fill"></i> Cadastrar Categoria
                </button>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($categorias as $cat) {
                        ?>
                            <tr>
                                <th scope="row"><?= $cat['id'] ?></th>
                                <td><?= $cat['nome'] ?></td>
                                <td><?= $cat['descricao'] ?></td>
                                <td>
                                    <a type="button" class="btn btn-danger me-2" href="actions/categoria_apagar.php?id=<?= $cat['id'] ?>">
                                        <i class="bi bi-x"></i>
                                    </a>
                                    <a type="button" class="btn btn-dark" href="actions/categoria_editar.php?id=<?= $cat['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCategoria" method="post" action="actions/categoria_cadastrar.php">
                    <input type="hidden" name="acao" value="cadastrar_categoria">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoriaModalLabel">Nova Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeCategoria" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" id="nomeCategoria" name="nomeCategoria" placeholder="Digite o nome da categoria" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoCategoria" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricaoCategoria" name="descricaoCategoria" rows="4" placeholder="Digite a descrição da categoria" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark w-100" type="submit">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




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