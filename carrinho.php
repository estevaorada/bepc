<?php
$heading_title = "Carrinho";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<div class="container p-4">
    <div class="row">
        <div class="col-12">
            <div id="aulasContainer">
                <!-- Linha de conteúdo -->
                <div class="row border rounded p-3 mb-2 conteudo-aula-carrinho">
                    <div class="col-md-2 id-aula">
                        #1
                    </div>
                    <div class="col-md-6">
                        Titulo<br>
                        Descrição
                    </div>
                    <div class="col-md-4">
                        Ações
                    </div>
                </div>
                <!-- Linha de conteúdo -->
                <div class="row border rounded p-3 mb-2 conteudo-aula-carrinho">
                    <div class="col-md-2 id-aula">
                        #1
                    </div>
                    <div class="col-md-6">
                        Titulo<br>
                        Descrição
                    </div>
                    <div class="col-md-4">
                        Ações
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row mt-3 justify-content-end">
        <div class="col-md-5 col-sm-12 border rounded p-3">
            <h2 class="text-center mb-3">Concluir Plano de Aula</h2>
            <form action="actions/carrinho_concluir.php" method="post">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título do Plano de Aula</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="curso" class="form-label">Curso</label>
                    <select class="form-select" id="curso" name="id_curso" required>
                        <option value="" disabled selected>Selecione o curso</option>
                        <?php
                        foreach ($cursos as $curso) {
                            echo "<option value='{$curso['id']}'>{$curso['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Concluir *********** -->
                <div class="mb-3">
                    <button class="btn btn-dark bt-lg w-100 py-3" type="submit">Concluir Plano de Aula</button>
                </div>
            </form>
        </div>
    </div>
</div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const aulasContainer = document.getElementById('aulasContainer');
        atualizarNumeracao();
        // Inicializa o Sortable para permitir arrastar e soltar
        Sortable.create(aulasContainer, {
            animation: 150,
            onEnd: function() {
                atualizarNumeracao();
            }
        });

        function atualizarNumeracao() {
            const aulas = document.querySelectorAll('.conteudo-aula-carrinho');
            aulas.forEach((aula, index) => {
                const idAula = aula.querySelector('.id-aula');
                idAula.textContent = `#${index + 1}`;
            });
        }
    });
</script>
<?php
require_once('includes/footer.php');
?>