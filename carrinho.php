<?php
$heading_title = "Carrinho";
if (isset($_COOKIE['id_curso_carrinho']) && !empty($_COOKIE['id_curso_carrinho']) && !isset($_GET['curso'])) {
    header('Location: carrinho.php?curso=' . $_COOKIE['id_curso_carrinho']);
}
if (isset($_GET['curso'])) {
    setcookie('id_curso_carrinho', $_GET['curso'], time() + 60 * 60 * 24 * 365, "/");
}
require_once('includes/header.php');
require_once('includes/heading_title.php');

?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<div class="container p-4">
    <div class="row">
        <div class="col-12">
            <div id="aulasContainer">
                <!-- Linha de conteúdo -->
                <div class="row border rounded p-3 mb-2 conteudo-aula-carrinho" data-id="1">
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
                <div class="row border rounded p-3 mb-2 conteudo-aula-carrinho" data-id="2">
                    <div class="col-md-2 id-aula">
                        #1
                    </div>
                    <div class="col-md-6">
                        Titulo2<br>
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
            <form method="GET" action="" class="mb-4">
                <label for="id_curso_sel" class="form-label">Curso</label>
                <select class="form-select" id="id_curso_sel" name="id_curso_sel" onchange="this.form.submit()">
                    <option value="" disabled selected>Selecione o curso</option>
                    <?php
                    foreach ($cursos as $c) {
                        $selected = (isset($_GET['curso']) && $_GET['curso'] == $c['id']) ? 'selected' : '';
                        echo "<option value='{$c['id']}' $selected>{$c['nome']}</option>";
                    }
                    ?>
                </select>
            </form>
            <?php
            // Verifica se o curso foi selecionado
            if (isset($_GET['curso']) && !empty($_GET['curso'])) {
                require_once('classes/Disciplina_class.php');
                $disciplina = new Disciplina();
                // Verifica se o filtro é numérico e maior que zero
                if (is_numeric($_GET['curso']) && $_GET['curso'] > 0) {
                    $filtroCurso = (int)$_GET['curso'];
                } else {
                    // Se o filtro não for numérico ou for inválido, não filtra
                    $filtroCurso =  null;
                }
                $disciplinas = $disciplina->listar(null, $filtroCurso);
                if (!$disciplinas || count($disciplinas) == 0) {
                    echo '<div class="alert alert-danger" role="alert">Nenhuma disciplina encontrada para o curso selecionado. Entre em contato com o administrador ou coordenador acadêmico!</div>';
                } else {
            ?>
                    <form action="actions/carrinho_concluir.php" method="post">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título do Plano de Aula</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_disciplina" class="form-label">Disciplina</label>
                            <select class="form-select" id="id_disciplina" name="id_disciplina" required>
                                <option value="" disabled selected>Selecione a disciplina</option>
                                <?php
                                foreach ($disciplinas as $d) {
                                    $selected = (isset($_GET['disciplina']) && $_GET['disciplina'] == $d['id']) ? 'selected' : '';
                                    echo "<option value='{$d['id']}' $selected>{$d['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" id="id_curso" name="id_curso" value="<?= $_GET['curso'] ?>">
                        <!-- Concluir *********** -->
                        <div class="mb-3">
                            <button class="btn btn-dark bt-lg w-100 py-3" type="submit">Concluir Plano de Aula</button>
                        </div>
                    </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
</form>
</div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('aulasContainer');

        // Função que salva a ordem atual no localStorage
        function salvarOrdem() {
            const ordem = Array.from(container.children).map(el => el.getAttribute('data-id'));
            localStorage.setItem('ordemAulas', JSON.stringify(ordem));
        }

        // Função que atualiza a numeração
        function atualizarNumeracao() {
            const aulas = container.querySelectorAll('.conteudo-aula-carrinho');
            aulas.forEach((aula, index) => {
                aula.querySelector('.id-aula').textContent = `#${index + 1}`;
            });
        }

        // Função que restaura a ordem do localStorage
        function restaurarOrdem() {
            const ordemSalva = JSON.parse(localStorage.getItem('ordemAulas'));
            if (!ordemSalva) return;

            const elementos = Array.from(container.children);
            ordemSalva.forEach(id => {
                const item = elementos.find(el => el.getAttribute('data-id') === id);
                if (item) container.appendChild(item);
            });

            atualizarNumeracao();
        }

        // Inicializa SortableJS
        Sortable.create(container, {
            animation: 150,
            onEnd: function() {
                atualizarNumeracao();
                salvarOrdem();
            }
        });

        // Restaura ordem ao carregar
        restaurarOrdem();
        <?php
        // Verifica se o curso foi selecionado
        if (isset($_GET['curso']) && !empty($_GET['curso'])) {
        ?>
            // Armazenar as informações dos inputs do carrinho em localStorage
            const tituloInput = document.getElementById('titulo');
            const disciplinaSelect = document.getElementById('id_disciplina');

            const STORAGE_KEY = 'dadosPlanoAula';

            // Tenta restaurar os dados salvos
            const dadosSalvos = JSON.parse(localStorage.getItem(STORAGE_KEY));
            if (dadosSalvos) {
                if (dadosSalvos.titulo) tituloInput.value = dadosSalvos.titulo;
                if (dadosSalvos.id_disciplina) disciplinaSelect.value = dadosSalvos.id_disciplina;
            }

            // Salva sempre que um campo for alterado
            function salvarDados() {
                const dados = {
                    titulo: tituloInput.value,
                    id_disciplina: disciplinaSelect.value
                };
                localStorage.setItem(STORAGE_KEY, JSON.stringify(dados));
            }

            tituloInput.addEventListener('input', salvarDados);
            disciplinaSelect.addEventListener('change', salvarDados);

            // Limpa localStorage ao enviar o formulário
            // const form = tituloInput.closest('form');
            // form.addEventListener('submit', function () {
            //     localStorage.removeItem(STORAGE_KEY);
            // });
        <?php
        }
        ?>
    });
</script>
<?php
require_once('includes/footer.php');
?>