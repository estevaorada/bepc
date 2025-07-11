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
      if (is_null($categorias)) {
        echo '<h2>Falha ao carregar </h2>';
      } elseif (empty($categorias)) {
        echo '<li><a class="dropdown-item" href="#">Nenhum curso encontrado</a></li>';
      } else {
        // Gera a lista de categorias
        foreach ($categorias as $cat) {
      ?>
          <a class="btn btn-outline-secondary category-btn" href="aulas_listar.php?curso=<?= $cat['id']; ?>"><?= $cat['nome'] ?></a>
      <?php
        }
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
      <!-- Card 1 -->
      <div class="col-md-3">
        <div class="card popular-card">
          <div class="card-body">
            <h6 class="card-title">Introdução à Matemática Básica</h6>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas voluptatibus praesentium culpa? Consequuntur similique placeat, assumenda...</p>
            <p class="small">Por: Prof. Lucas Silva</p>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-dark w-100" type="button"><i class="bi bi-three-dots"></i> Detalhes</button>
              <button class="btn btn-sm btn-dark w-100" type="button"><i class="bi bi-cart-plus"></i> Adicionar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-3">
        <div class="card popular-card">
          <div class="card-body">
            <h6 class="card-title">Programação com Python</h6>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas voluptatibus praesentium culpa? Consequuntur similique placeat, assumenda...</p>
            <p class="small">Por: Prof. Ana Costa</p>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-dark w-100" type="button"><i class="bi bi-three-dots"></i> Detalhes</button>
              <button class="btn btn-sm btn-dark w-100" type="button"><i class="bi bi-cart-plus"></i> Adicionar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-3">
        <div class="card popular-card">
          <div class="card-body">
            <h6 class="card-title">Fotossíntese e Respiração</h6>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas voluptatibus praesentium culpa? Consequuntur similique placeat, assumenda...</p>
            <p class="small">Por: Prof. Carlos Lima</p>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-dark w-100" type="button"><i class="bi bi-three-dots"></i> Detalhes</button>
              <button class="btn btn-sm btn-dark w-100" type="button"><i class="bi bi-cart-plus"></i> Adicionar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-md-3">
        <div class="card popular-card">
          <div class="card-body">
            <h6 class="card-title">História do Brasil Colonial</h6>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas voluptatibus praesentium culpa? Consequuntur similique placeat, assumenda...</p>
            <p class="small">Por: Prof. João Santos</p>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-dark w-100" type="button"><i class="bi bi-three-dots"></i> Detalhes</button>
              <button class="btn btn-sm btn-dark w-100" type="button"><i class="bi bi-cart-plus"></i> Adicionar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
require_once('includes/footer.php');
?>