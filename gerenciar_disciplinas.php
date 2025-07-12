<?php
$heading_title = "Gerenciar Disciplinas";
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
                <!-- Formulário de filtro por curso -->
                <form method="GET" action="" class="mb-3">
                    <div class="input-group">
                        <select name="curso" class="form-select" onchange="this.form.submit()">
                            <option value="">Todas as Disciplinas</option>
                            <?php

                            foreach ($cursos as $c) {
                                $selected = (isset($_GET['curso']) && $_GET['curso'] == $c['id']) ? 'selected' : '';
                                echo "<option value='{$c['id']}' $selected>{$c['nome']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Filtrar</button>
                    </div>
                </form>

                <button type="button" class="btn btn-dark mb-3 float-end" data-bs-toggle="modal" data-bs-target="#cadastroDisciplinaModal">
                    <i class="bi bi-plus-circle-fill"></i> Cadastrar Disciplina
                </button>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once('classes/Disciplina_class.php');
                        $disciplina = new Disciplina();
                        if (isset($_GET['curso']) && is_numeric($_GET['curso']) && $_GET['curso'] > 0) {
                            $filtroCurso = (int)$_GET['curso'];
                        } else {
                            // Se o filtro não for numérico ou for inválido, não filtra
                            $filtroCurso =  null; 
                        }
                        $disciplinas = $disciplina->listar(null, $filtroCurso);
                        if (!$disciplinas) {
                            echo "<tr><td colspan='4' class='text-center'>Nenhuma disciplina encontrada.</td></tr>";
                        } else {


                            foreach ($disciplinas as $d) {
                        ?>
                                <tr>
                                    <th scope="row"><?= $d['id'] ?></th>
                                    <td><?= $d['nome'] ?></td>
                                    <td><?= $d['nome_curso'] ?></td>
                                    <td>
                                        <a type="button" class="btn btn-danger btn-sm me-2" href="actions/disciplina_desativar.php?id=<?= $d['id'] ?>">
                                            <i class="bi bi-x"></i>
                                        </a>
                                        <a type="button" class="btn btn-dark btn-sm" href="actions/disciplina_editar.php?id=<?= $d['id'] ?>">
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

    <!-- Modal -->
    <div class="modal fade" id="cadastroDisciplinaModal" tabindex="-1" aria-labelledby="cadastroDisciplinaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroDisciplinaModalLabel">Cadastro de Disciplina</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cadastroForm" method="post" action="actions/disciplina_cadastrar.php">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeDisciplina" name="nomeDisciplina" required placeholder="Digite o nome da disciplina">
                        </div>
                        <div class="mb-3">
                            <label for="curso" class="form-label">Curso</label>
                            <select class="form-select" id="idCurso" name="idCurso" required>
                                <option value="" disabled selected>Selecione o curso</option>
                                <?php
                                foreach ($cursos as $c) {
                                    echo "<option value='{$c['id']}'>{$c['nome']}</option>";
                                }
                                ?>
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