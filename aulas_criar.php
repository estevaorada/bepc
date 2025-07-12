<?php
$heading_title = "Criar aula";
require_once('includes/header.php');
require_once('includes/heading_title.php');
?>

<!-- RayEditor CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/yeole-rohan/ray-editor@main/ray-editor.css">


<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php require_once('includes/sidemenu.php'); ?>
        </div>
        <div class="col-md-8">
            <h3 class="mb-4">Cadastro de Aula</h3>
            <form method="GET" action="" class="mb-4">
                <label for="curso" class="form-label">Curso</label>
                <select name="curso" class="form-select" id="id_curso_sel" name="id_curso_sel" onchange="this.form.submit()">
                    <option value="" disabled selected>Selecione a disciplina</option>
                    <?php
                    foreach ($cursos as $c) {
                        $selected = (isset($_GET['curso']) && $_GET['curso'] == $c['id']) ? 'selected' : '';
                        echo "<option value='{$c['id']}' $selected>{$c['nome']}</option>";
                    }
                    ?>
                </select>
            </form>
            <form id="cadastroAulaForm" method="post" action="actions/aula_cadastrar.php">
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
                        <input type="hidden" id="id_curso" name="id_curso" value="<?= $_GET['curso'] ?>">
                        <div class="mb-3 mt-1">
                            <label for="disciplina" class="form-label">Disciplina</label>
                            <select class="form-select" id="disciplina" name="id_disciplina" required>
                                <option value="" disabled selected>Selecione a disciplina</option>
                                <?php
                                foreach ($disciplinas as $d) {
                                    echo "<option value='{$d['id']}' $selected>{$d['nome']}</option>";
                                }
                                ?>

                            </select>
                        </div>
                         <div class="mb-3 mt-1">
                            <label for="id_categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="id_categoria" name="id_categoria" required>
                                <option value="" disabled selected>Selecione uma categoria</option>
                                <?php
                                foreach ($categorias as $cat) {
                                    echo "<option value='{$cat['id']}' $selected>{$cat['nome']}</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tituloAula" class="form-label">Título da Aula</label>
                            <input type="text" class="form-control" id="nome_aula" name="nome_aula" required placeholder="Digite o título da aula">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <div id="editor"></div>
                            <input type="hidden" id="editor_conteudo" name="descricao">
                        </div>
                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control" id="observacoes" name="observacoes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg w-100">Cadastrar Aula</button>
                <?php
                    }
                }
                ?>
            </form>
        </div>
    </div>
</div>

<!-- RayEditor JS -->
<script src='https://cdn.jsdelivr.net/gh/yeole-rohan/ray-editor@main/ray-editor.js'></script>
<script>
    const editor = new RayEditor('editor', {
        bold: true,
        italic: true,
        underline: true,
        strikethrough: true,
        undo: true,
        headings: true,
        orderedList: true,
        unorderedList: true,
        codeBlock: true,
        link: true,
        table: true,
        textAlignment: true
    });
    document.getElementById('ray-editor-watermark').innerHTML = '<a href="https://rohanyeole.com/ray-editor/" target="_blank">RayEditor</a>';
    document.querySelector('#cadastroAulaForm').addEventListener('submit', function(event) {
        event.preventDefault();
        alert('Aula cadastrada com sucesso!');
        document.getElementById('editor_conteudo').value = document.querySelector('#editor .ray-editor-content').innerHTML;
        alert('Conteúdo da aula: ' + document.getElementById('editor_conteudo').value);
        this.submit();
    });
</script>



<?php
require_once('includes/footer.php');
?>