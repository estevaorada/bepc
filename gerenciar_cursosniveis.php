<?php
$heading_title = "Gerenciar Cursos e Níveis";
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
            <div class="col-md-8">
                <h2 class="mb-4">Gerenciar Níveis</h2>
                <button type="button" class="btn btn-dark mb-3 float-end" data-bs-toggle="modal" data-bs-target="#cadastroNivelModal">
                    <i class="bi bi-plus-circle-fill"></i> Cadastrar Nível
                </button>
                <table class="table table-hover mb-4">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_null($niveis)) {
                            echo '<div class="alert alert-danger" role="alert">Erro ao carregar níveis</div>';
                        } elseif (empty($niveis)) {
                            echo '<div class="alert alert-warning" role="alert">Nenhum nível encontrado</div>';
                        } else {
                            // Gera a lista de categorias
                            foreach ($niveis as $ni) {
                        ?>
                                <tr>
                                    <th scope="row"><?= $ni['id'] ?></th>
                                    <td><?= $ni['nome'] ?></td>
                                    <td>
                                        <a type="button" class="btn btn-danger me-2" href="actions/nivel_apagar.php?id=<?= $ni['id'] ?>">
                                            <i class="bi bi-x"></i>
                                        </a>
                                        <a type="button" class="btn btn-dark" href="actions/nivel_editar.php?id=<?= $ni['id'] ?>">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <h2 class="mb-4">Gerenciar Cursos</h2>
                <button type="button" class="btn btn-dark mb-3 float-end" data-bs-toggle="modal" data-bs-target="#cadastroCursoModal">
                    <i class="bi bi-plus-circle-fill"></i> Cadastrar Curso
                </button>
                <div class="clearfix"></div>
                <table class="table table-hover mb-4">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Nível</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_null($cursos)) {
                            echo '<div class="alert alert-danger" role="alert">Erro ao carregar cursos</div>';
                        } elseif (empty($cursos)) {
                            echo '<div class="alert alert-warning" role="alert">Nenhum curso encontrado</div>';
                        } else {
                            // Gera a lista de categorias
                            foreach ($cursos as $cu) {
                        ?>
                                <tr>
                                    <th scope="row"><?= $cu['id'] ?></th>
                                    <td><?= $cu['nome'] ?></td>
                                    <td><?= $cu['nivel_nome'] ?></td>
                                    <td>
                                        <a type="button" class="btn btn-danger btn-sm me-2" href="actions/nivel_apagar.php?id=<?= $ni['id'] ?>">
                                            <i class="bi bi-x"></i>
                                        </a>
                                        <a type="button" class="btn btn-dark btn-sm" href="actions/nivel_editar.php?id=<?= $ni['id'] ?>">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <!-- Modal Cadastro Nivel -->
    <div class="modal fade" id="cadastroNivelModal" tabindex="-1" aria-labelledby="cadastroNivelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroNivelModalLabel">Novo Nível</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="actions/nivel_cadastrar.php" method="POST">
                        <div class="mb-3">
                            <label for="nomeNivel" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeNivel" name="nomeNivel" required placeholder="Digite o nome do nível">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark w-100" onclick="document.querySelector('#cadastroNivelModal form').requestSubmit()">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cadastro Curso -->
    <div class="modal fade" id="cadastroCursoModal" tabindex="-1" aria-labelledby="cadastroCursoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroCursoModalLabel">Novo Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="actions/curso_cadastrar.php" method="POST">
                        <div class="mb-3">
                            <label for="nomeCurso" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeCurso" name="nomeCurso" required placeholder="Digite o nome do curso">
                        </div>
                        <div class="mb-3">
                            <label for="nivelCurso" class="form-label">Nível</label>
                            <select class="form-select" id="nivelCurso" name="nivelCurso" required>
                                <option value="" disabled selected>Selecione o nível</option>
                                <?php
                                if (is_null($niveis)) {
                                    echo '<option value="" disabled selected>Falha ao obter níveis</option>';
                                } elseif (empty($niveis)) {
                                    echo '<option value="" disabled selected>Nenhum nível encontrado</option>';
                                } else {
                                    // Gera a lista de categorias
                                    foreach ($niveis as $ni) {
                                ?>
                                        <option value="<?php echo $ni['id'] ?>"><?php echo $ni['nome'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark w-100" onclick="document.querySelector('#cadastroCursoModal form').requestSubmit()">Cadastrar</button>
                </div>
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