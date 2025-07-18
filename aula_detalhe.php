<?php
$heading_title = "Detalhes";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>


<div class="container">
    <div class="row mb-4">
        <?php if (isset($_GET['id'])) { ?>
            <div class="col-md-9">
                <?php
                require_once('classes/Aula_class.php');
                $aula = new Aula();
                $id_aula = (int)$_GET['id'];
                $aulas = $aula->listar($_SESSION['dados_usuario']['id'], null, null, $id_aula);
                if (count($aulas) > 0) {
                ?>
                    <h1 class="mb-3">Aula: <?= htmlspecialchars($aulas[0]['titulo']) ?></h1>
                    <p><strong>Disciplina:</strong> <?= htmlspecialchars($aulas[0]['disciplina_nome']) ?></p>
                    <p>
                    <h2>Descrição: </h2>
                    </p>
                    <p><?= $aulas[0]['descricao'] ?></p>
                    <p>
                    <h2>Observações: </h2>
                    </p>
                    <p><?= $aulas[0]['observacoes'] ?></p>
                    <hr>
                    </hr>
                     <p><strong>Data de Criação:</strong> <?= date('d/m/Y', strtotime($aulas[0]['data_cadastrada'])) ?></p>



                <?php } else { ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Erro!</strong> Aula não encontrada ou ID inválido.
                    </div>
                <?php } ?>
            </div>
            <?php
            if (count($aulas) > 0) {
            ?>
                <div class="col-md-3">
                    <div class="rounded border p-3">
                        <p><strong>Categoria:</strong> <?= htmlspecialchars($aulas[0]['categoria_nome']) ?><br>
                        <strong>Por:</strong> <?= htmlspecialchars($aulas[0]['usuario_nome'] . ' ' . $aulas[0]['usuario_sobrenome']) ?></p>
                        <a href ="actions/carrinho_adicionar.php?id=<?=$id_aula ?>" class="btn btn-lg btn-dark w-100 py-3"><i class="bi bi-cart-plus-fill"></i> Adicionar</a>
                    </div>
                    
                </div>
            <?php
            }
            ?>
        <?php } else { ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <strong>Erro!</strong> Aula não encontrada ou ID inválido.
                </div>
            </div>
        <?php } ?>
    </div>
</div>



<?php
require_once('includes/footer.php');
?>