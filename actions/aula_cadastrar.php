<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

// Importa a classe Categoria
require_once('../classes/Aula_class.php');

// Valida e sanitiza os dados de entrada
$id_curso = filter_input(INPUT_POST, 'id_curso', FILTER_SANITIZE_SPECIAL_CHARS);
$id_disciplina = filter_input(INPUT_POST, 'id_disciplina', FILTER_SANITIZE_SPECIAL_CHARS);
$nome_aula = filter_input(INPUT_POST, 'nome_aula', FILTER_SANITIZE_SPECIAL_CHARS);

$allowed_tags = '<p><b><font><u><strike><h1><h2><h3><h4><h5><h6><ol><li><ul><a><div><pre><code><table><tr><td><br>';
$descricao = strip_tags($_POST['descricao'], $allowed_tags);
$descricao = preg_replace('/<(script|iframe)\b[^<]*(?:(?!<\/\1>)<[^<]*)*<\/\1>/i', '', $descricao);
// Remove all attributes except href and target on <a>
$descricao = preg_replace('/<(\"a\")[^>]+href=[\'"]([^\'"]*)[\'"][^>]*target=[\'"]([^\'"]*)[\'"][^>]*>/i', '<a href="$2" target="$3">', $descricao);
$descricao = preg_replace('/\s+(on\w+|style|class|contenteditable|spellcheck)\s*=\s*[\'"][^\'"]*[\'"]/i', '', $descricao);

$observacoes = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
$id_usuario = $_SESSION['dados_usuario']['id'];
$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se os campos obrigatórios estão preenchidos
if (empty($id_curso) || empty($id_disciplina) || empty($nome_aula) || empty($descricao) || empty($id_categoria)) {
    print_r($_POST);
    print("Id curso: $id_curso, Id disciplina: $id_disciplina, Nome aula: $nome_aula, Descrição: $descricao, Observações: $observacoes, Id categoria: $id_categoria");
    //header('Location: ../aulas_minhas.php?msg=erro_nome_vazio');
    exit;
}

try {

    // Instancia a classe Categoria
    $c = new Aula();

    // Tenta cadastrar a categoria
    $resultado = $c->cadastrar(
        $id_usuario,
        $id_disciplina,
        $nome_aula,
        $descricao,
        $observacoes,
        $id_categoria
    );

    if ($resultado) {
        // Sucesso no cadastro
        header('Location: ../aulas_minhas.php?msg=cadastro_sucesso');
    } else {
        // Falha no cadastro (ex.: nome duplicado ou erro no banco)

        //header('Location: ../aulas_minhas.php?msg=erro_cadastro');
    }
} catch (Exception $e) {
    // Loga o erro
    error_log("Erro ao cadastrar categoria: " . $e->getMessage());
    header('Location: ../aulas_minhas.php?msg=erro_sistema');
}

exit;
