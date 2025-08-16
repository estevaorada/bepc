            <div class="rouded border py-2 px-3" id="sidemenu-front">
                <h5 class="mt-3">Categorias</h5>
                <div class="list-group list-group-flush">
                    <?php
                    if (is_null($categorias)) {
                        echo '<a href="#" class="list-group-item">Erro ao listar categorias</a>';
                    } elseif (empty($categorias)) {
                        echo '<a href="#" class="list-group-item">Nenhuma categoria cadastrada</a>';
                    } else {
                        // Gera a lista de categorias
                        foreach ($categorias as $cat) {
                    ?>
                            <a href="aulas_listar.php?categoria=<?= $cat['id']; ?>" class="list-group-item"><?= $cat['nome'] ?></a>
                    <?php
                        }
                    }
                    ?>
                </div>
                <hr>
                <h5 class="mt-3">Cursos</h5>
                <div class="list-group list-group-flush">
                    <?php
                    $cursos = $curso->listar(NULL, 10);
                    if (is_null($cursos)) {
                        echo '<a href="#" class="list-group-item">Erro ao listar cursos</a>';
                    } elseif (empty($cursos)) {
                        echo '<a href="#" class="list-group-item">Nenhum curso encontrado</a>';
                    } else {
                        // Gera a lista de categorias
                        foreach ($cursos as $cur) {
                    ?>
                            <a href="aulas_listar.php?curso=<?= $cur['id']; ?>" class="list-group-item"><?= $cur['nome'] ?></a>
                    <?php
                        }
                    }
                    ?>
                </div>
                <hr>

            </div>