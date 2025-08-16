<?php
$heading_title = "Listar aulas";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>


<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php
            require_once('includes/sidemenu_front.php');
            ?>
        </div>
        <div class="col-md-9">
            <div class="container">
                <h5 class="mb-4">📈 Aulas Mais Recentes</h5>
                <div class="row g-4">
                    <?php
                    require_once('classes/Aula_class.php');
                    $aula = new Aula();
                    // Verifica se há filtros aplicados
                    if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
                        $categoria_id = $_GET['categoria'];
                        $aulas = $aula->listar(null, $categoria_id, null);
                    } else if (isset($_GET['curso']) && !empty($_GET['curso'])) {
                        $curso_id = $_GET['curso'];
                        $aulas = $aula->listar(null, null, $curso_id);
                    } else if (isset($_GET['busca']) && !empty($_GET['busca'])) {
                        $busca = $_GET['busca'];
                        $aulas = $aula->buscar($busca);
                        
                    } else {
                        // Listar todas as aulas se nenhum filtro for aplicado
                        $aulas = $aula->listar(NULL, null, null);
                    }
                    if (is_null($aulas)) {
                        echo '<div class="alert alert-danger">Erro ao carregar aulas.</div>';
                    } else {
                        if (empty($aulas)) {
                            echo '<div class="alert alert-warning">Nenhuma aula encontrada.</div>';
                        } else {
                            // Exibe as aulas
                            echo '<div class="lead">Foram encontradas ' . count($aulas) . ' aulas ';
                            // Exibe o nome da categoria ou curso, se aplicável
                            if (isset($categoria_id)) {
                                // Obtém o índice do curso com o id desejado
                                $indice = array_search($categoria_id, array_column($categorias, 'id'));
                                echo 'da categoria: ' . $categorias[$indice]['nome'];
                            } else if (isset($curso_id)) {
                                $indice = array_search($curso_id, array_column($cursos, 'id'));
                                echo 'do curso: ' . $cursos[$indice]['nome'];
                            }
                            echo '</div>';
                            foreach ($aulas as $a) {
                    ?>
                                <!-- Card 1 -->
                                <div class="col-md-4">
                                    <div class="card popular-card">
                                        <div class="card-body">
                                            <h6 class="card-title"> <a href="aula_detalhe.php?id=<?= htmlspecialchars($a['id']) ?>" class="text-dark"><?= htmlspecialchars(htmlspecialchars($a['titulo'])) ?></a></h6>
                                            <p><?= $a['descricao'] . '...' ?></p>
                                            <p class="small"><i class="bi bi-person-fill"></i> <?= $a['usuario_nome'] . " " . $a['usuario_sobrenome'] ?><br>
                                                <i class="bi bi-journal-bookmark-fill"></i> <?= htmlspecialchars($a['disciplina_nome']) ?>
                                            </p>
                                            <div class="d-flex gap-2">
                                                <a href="aula_detalhe.php?id=<?= htmlspecialchars($a['id']) ?>" class="btn btn-sm btn-outline-dark w-100" type="button"><i class="bi bi-three-dots"></i> Detalhes</a>
                                                <a href="actions/carrinho_adicionar.php?id=<?= htmlspecialchars($a['id']) ?>" class="btn btn-sm btn-dark w-100" type="button"><i class="bi bi-cart-plus"></i> Adicionar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
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