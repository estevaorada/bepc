<?php
require_once('./config.php');
?>
<!-- Rodapé -->
 <section class="mt-3 footer">
   <div class="container">
     <div class="row">
       <div class="col-md-4">
         <img src="static/images/logo.png" alt="bepc." class="mx-auto d-block w-50" />
       </div>
       <div class="col-md-8">
         <p class="fs-4 fw-bold"><?php echo $nome_instituicao; ?></p>
         <p><?php echo strip_tags($descricao_instituicao) ?></p>
       </div>
     </div>
     <div class="row">
       <div class="col-md-12 text-center mt-5">
         <p class="fs-6">&copy <?php echo date("Y"); ?> - Banco de Estratégias Pedagógicas Colaborativo</p>
       </div>
     </div>

   </div>
 </section>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <?php if(isset($_GET['erro']) || isset($_GET['msg'])){
        // Inclui o arquivo de mensagens de erro/sucesso
        require_once('includes/arrays_avisos.php');
        echo "<script>window.history.replaceState(null, '', window.location.pathname);</script>";
    } 
    ?>
 </body>
 </html>