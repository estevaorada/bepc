<?php
if (isset($heading_title)) {
?>
    <div class="container-fluid topo-titulo">
        <div class="container ">
            <div class="row mx-1">
                <div class="col-12">
                    <h1 class="display-3"><?= $heading_title ?></h1>
                    <p>Você está logado(a) como: <?php echo htmlspecialchars($_SESSION['dados_usuario']['nome'] . ' ' . $_SESSION['dados_usuario']['sobrenome']); ?></p>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>