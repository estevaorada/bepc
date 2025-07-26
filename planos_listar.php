<?php
$heading_title = "Meus Planos";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>


<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php require_once('includes/sidemenu.php'); ?>
        </div>
        <div class="col-md-8">
            <h2 class="mb-4">Meus Planos de Aula</h2>
            <?php
            require_once('classes/Plano_class.php');
            $plano = new Plano();
            $planos = $plano->listarPlanos($_SESSION['dados_usuario']['id']);

            if (is_null($planos)) {
                echo "<p class='text-danger'>Nenhum plano encontrado.</p>";
            } else {
                foreach ($planos as $p) {
                    echo "<div class='card mb-3'>";
                    echo "  <div class='card-body'>";
                    echo "    <div class='row align-items-center'>";

                    echo "      <div class='col-md-9'>"; // Coluna de texto
                    echo "        <h5 class='card-title'>{$p['titulo']}</h5>";
                    $dataFormatada = date("d-m-Y H:i", strtotime($p['data_criacao']));
                    echo "        <p class='card-text small'>Criado por: {$p['usuario_nome']} {$p['usuario_sobrenome']} em {$dataFormatada}</p>";
                    echo "      </div>";

                    echo "      <div class='col-md-3 text-end'>"; // Coluna de botões
                    echo "        <a href='planos_detalhe.php?id={$p['id']}' class='btn btn-outline-dark btn-sm me-2'>Detalhes</a>";
                    echo "        <a href='actions/plano_excluir.php?id={$p['id']}' class='btn btn-outline-danger btn-sm'>Excluir</a>";
                    echo "      </div>";

                    echo "    </div>";
                    echo "  </div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
</div>



<?php
require_once('includes/footer.php');
?>