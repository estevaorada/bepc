<?php
require_once('includes/header.php');
?>

<!-- Hero -->
<section class="hero">
  <div class="container">
    <h1 class="display-5 fw-bold">Descubra e Compartilhe<br>Planos de Aula Incríveis</h1>
    <p class="lead">Uma plataforma colaborativa onde educadores criam, descobrem e compartilham aulas de qualidade para inspirar o aprendizado.</p>
    <!-- <button class="btn btn-light mt-3">Criar Primeira Aula</button> -->
  </div>
</section>

<!-- Estatísticas
  <section class="py-5 text-center">
    <div class="container">
      <div class="row">
        <div class="col"><h4>250+</h4><p>Aulas Cadastradas</p></div>
        <div class="col"><h4>50+</h4><p>Educadores Ativos</p></div>
        <div class="col"><h4>1.2k+</h4><p>Planos Criados</p></div>
      </div>
    </div>
  </section> -->

<!-- Categorias -->
<section class="py-4 bg-light text-center">
  <div class="container">
    <h5 class="mb-3">Explore por Categoria</h5>
    <div>
      <?php
      $categorias = $categoria->listar(null, 10);
      if (is_null($categorias)) {
        echo '<h2>Falha ao carregar </h2>';
      } elseif (empty($categorias)) {
        echo '<li><a class="dropdown-item" href="#">Nenhuma categoria encontrada</a></li>';
      } else {
        // Gera a lista de categorias
        foreach ($categorias as $cat) {
      ?>
          <a class="btn btn-outline-secondary category-btn" href="aulas_listar.php?categoria=<?= $cat['id']; ?>"><?= $cat['nome'] ?></a>
        <?php
        }
        ?>
        <a class="btn btn-dark category-btn" href="aulas_listar.php">Ver mais...</a>
      <?php
      }
      ?>
    </div>
  </div>
</section>

<!-- Aulas Populares -->
<section class="py-5">
  <div class="container">
    <h5 class="mb-4">📈 Aulas Mais Recentes</h5>
    <div class="row g-4">
      <?php
      require_once('classes/Aula_class.php');
      $aula = new Aula();
      $aulas = $aula->listar(null, null, null);
      foreach ($aulas as $a) {
      ?>

        <div class="col-md-3">
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
      ?>
    </div>
  </div>
</section>
<?php
require_once('includes/footer.php');
?>