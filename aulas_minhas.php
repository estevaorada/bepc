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
            <?php
            require_once('classes/Aula_class.php');
            $aula = new Aula();
            $aulas = $aula->listar($_SESSION['dados_usuario']['id'], null, null);
            foreach ($aulas as $a) {
                $dataFormatada = date('d/m/Y', strtotime($a['data_cadastrada']));
            ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 col-md-6">
                                <strong>ID:</strong> <?= $a['id'] ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <strong>Título:</strong> <?= htmlspecialchars($a['titulo']) ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-6">
                                <strong>Disciplina:</strong> <?= htmlspecialchars($a['disciplina_nome']) ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <strong>Conteúdo:</strong> <?= $a['descricao'] ?>...
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6">
                                <strong>Data de Criação:</strong> <?= $dataFormatada ?>
                            </div>
                            <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                                <a href="actions/aula_editar.php?id=<?= $a['id'] ?>" class="btn btn-dark btn-sm me-2">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <a href="actions/aula_apagar.php?id=<?= $a['id'] ?>" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>



<?php
require_once('includes/footer.php');
?>