<?php
require_once('includes/header.php');
$heading_title = "Gerenciar Cursos e Níveis";
require_once('includes/heading_title.php');
// Verifica se o usuário é administrador: 
if($_SESSION['dados_usuario']['id_tipo'] == 1) {
?>


<div class="container">
    <div class="row">
        <div class="col-md-4">
         <?php   require_once('includes/sidemenu.php'); ?>
        </div>
        <div class="col-md-6">
            Conteudo
        </div>
    </div>

</div>

<?php
}else{
?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
         <?php   require_once('includes/sidemenu.php'); ?>
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