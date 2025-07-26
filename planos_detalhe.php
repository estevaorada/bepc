<?php
$heading_title = "Detalhes: Plano de Aula";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>


<div class="container">
    <div class="row">
            <?php
            if(!isset($_GET['share']) || $_GET['share'] != 1) {
                echo "<div class='col-md-4'>";
                require_once('includes/sidemenu.php');
                echo "</div>";
                echo "<div class='col-md-8'>";
            } else {
                // Se for um compartilhamento, não exibe o menu lateral
                echo "<div class='col-md-12'>";
            }
            ?>
        
            <?php
            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id_plano = intval($_GET['id']);
                require_once('classes/Plano_class.php');
                $plano = new Plano();
                $aulas_plano = $plano->obterAulaPlano($id_plano, $_SESSION['dados_usuario']['id']);
                //print_r($detalhes_plano);
                if (is_null($aulas_plano)) {
                    echo "<p class='text-danger'>Plano não encontrado.</p>";
                } else {
                    echo "<h2 class='mb-4'>Detalhes do Plano de Aula</h2>";
                    // Exibe os detalhes do plano
                    $detalhes_plano = $plano->listarPlanos($_SESSION['dados_usuario']['id'], $id_plano);
                    if (!is_null($detalhes_plano) && count($detalhes_plano) > 0) {
                        $plano_info = $detalhes_plano[0];
                        echo "<p><span class='fw-bold'>Título:</span> {$plano_info['titulo']} <br> ";
                        $dataFormatada = date("d-m-Y", strtotime($plano_info['data_criacao']));
                        echo "<span class='small'><span class='fw-bold'>Criado por:</span> {$plano_info['usuario_nome']} {$plano_info['usuario_sobrenome']} em {$dataFormatada}</span></p>";
                    } else {
                        echo "<p class='text-danger'>Nenhum detalhe encontrado para este plano.</p>";
                    }
                    echo "<h3 class='mt-4'>Aulas:</h3>";
                    foreach($aulas_plano as $aula) {
                        echo "<div class='card mb-3'>";
                        echo "  <div class='card-body'>";
                        echo "    <div class='row align-items-center'>";

                        echo "      <div class='col-md-9'>"; // Coluna de texto
                        echo "        <h5 class='card-title'>{$aula['titulo']}</h5>";
                        $aulaFormatada = substr(strip_tags($aula['descricao']),0, 200);
                        echo "        <p class='card-text small'>{$aulaFormatada}...</p>";
                        echo "      </div>";

                        echo "      <div class='col-md-3 text-end'>"; // Coluna de botões
                        echo "        <a href='aula_detalhe.php?id={$aula['id_aula']}' class='btn btn-outline-dark btn-sm'>Detalhes</a>";
                        echo "      </div>";

                        echo "    </div>";
                        echo "  </div>";
                        echo "</div>";
                    }
                    echo "<hr>";
                    echo "<h5 class='mt-4'><i class='bi bi-share-fill'></i> Compartilhar Plano</h5>";
                    echo "<p>Você pode compartilhar este plano com outros usuários através do link abaixo:</p>";
                    echo "<input type='text' class='form-control' value='https://{$_SERVER['HTTP_HOST']}/planos_detalhe.php?id={$id_plano}&share=1' readonly>";
                }
            }else{
                echo "<p class='text-danger'>ID do plano inválido ou não fornecido.</p>";
            }
            ?>
            
        </div>
    </div>
</div>



<?php
require_once('includes/footer.php');
?>