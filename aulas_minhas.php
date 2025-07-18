<?php
$heading_title = "Minhas aulas";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>


<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php require_once('includes/sidemenu.php'); ?>
        </div>
        <div class="col-md-8">
            <button type="button" class="btn btn-dark mb-3 float-end" onclick="window.location.href='aulas_criar.php'">
                <i class="bi bi-plus-circle-fill"></i> Criar Aula
            </button>
            <div class="clearfix"></div>
            <table class="table table-hover mb-4">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Título</th>
                        <th scope="col">Disciplina</th>
                        <th scope="col">Conteúdo</th>
                        <th scope="col">Data de Criação</th>
                        <th scope="col">Ação</th>
                    </tr>
                    <?php
                    require_once('classes/Aula_class.php');
                    $aula = new Aula();
                    $aulas = $aula->listar($_SESSION['dados_usuario']['id'], null, null);
                    foreach ($aulas as $a) {
                    ?>
                        <tr>
                            <td><?= $a['id'] ?></td>
                            <td><?= htmlspecialchars(htmlspecialchars($a['titulo'])) ?></td>
                            <td><?= htmlspecialchars($a['disciplina_nome']) ?></td>
                            <td><?= $a['descricao'] . '...' ?></td>
                            <td><?= date('d/m/Y', strtotime($a['data_cadastrada'])) ?></td>
                            <td><a type="button" class="btn btn-danger btn-sm me-2" href="actions/aula_apagar.php?id=<?= $a['id'] ?>">
                                    <i class="bi bi-x"></i>
                                </a>
                                <a type="button" class="btn btn-dark btn-sm" href="actions/aula_editar.php?id=<?= $a['id'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </thead>
            </table>
        </div>
    </div>
</div>



<?php
require_once('includes/footer.php');
?>