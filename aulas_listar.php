<?php
$heading_title = "Listar aulas";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>


<div class="container">
    <div class="row">
        <div class="col-md-2">
            Menu Lateral
        </div>
        <div class="col-md-10">
            <div class="container">
                <h5 class="mb-4">📈 Aulas Mais Recentes</h5>
                <div class="row g-4">
                    <?php
                    require_once('classes/Aula_class.php');
                    $aula = new Aula();
                    $aulas = $aula->listar(NULL, null, null);
                    foreach ($aulas as $a) {
                    ?>
                        <!-- Card 1 -->
                        <div class="col-md-4">
                            <div class="card popular-card">
                                <div class="card-body">
                                    <h6 class="card-title"><?= htmlspecialchars(htmlspecialchars($a['titulo'])) ?></h6>
                                    <p><?= $a['descricao'] . '...' ?></p>
                                    <p class="small"><i class="bi bi-person-fill"></i> <?= $a['usuario_nome']." ".$a['usuario_sobrenome'] ?><br>
                                    <i class="bi bi-journal-bookmark-fill"></i> <?= htmlspecialchars($a['disciplina_nome']) ?></p>
                                    <div class="d-flex gap-2">
                                        <a href="aula_detalhe.php?id=<?= htmlspecialchars($a['id']) ?>" class="btn btn-sm btn-outline-dark w-100" type="button"><i class="bi bi-three-dots"></i> Detalhes</a>
                                        <a href="actions/carrinho_adicionar.php?id=<?= htmlspecialchars($a['id']) ?>" class="btn btn-sm btn-dark w-100" type="button"><i class="bi bi-cart-plus"></i> Adicionar</a>
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
    </div>
</div>



<?php
require_once('includes/footer.php');
?>