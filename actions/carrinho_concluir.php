<?php
session_start();


// Verifica se o usuário está autenticado e se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php?msg=0');
    exit;
}

require_once('../classes/Plano_class.php');
$plano = new Plano();
// Obtém os dados do formulário
$id_usuario = $_SESSION['dados_usuario']['id'];
$titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : null;
$id_disciplina = isset($_POST['id_disciplina']) ? $_POST['id_disciplina'] : null ;

// Verifica se os campos obrigatórios estão preenchidos
if (is_null($titulo) || is_null($id_disciplina)) {
    header('Location: ../carrinho.php?erro=carrinho_erro_infos'); // Redireciona com mensagem de erro
    exit;
}
// Cria o plano de aula
$id_plano = $plano->criarPlano($id_usuario, $titulo, $id_disciplina);

if ($id_plano) {
    // Se o plano foi criado com sucesso, adiciona as aulas do carrinho ao plano
    require_once('../classes/Carrinho_class.php');
    // Obtém as aulas do carrinho do usuário
    $carrinho = new Carrinho();
    $carrinho_aulas = $carrinho->listar($id_usuario);
    if ($carrinho_aulas) {
        foreach ($carrinho_aulas as $aula) {
            // Adiciona cada aula do carrinho ao plano
            $plano->adicionarAulaAoPlano($id_plano, $aula['id_aula']);
            //echo "Aula ID: {$aula['id_aula']} adicionada ao plano ID: $id_plano<br>";
        }
        // Limpa o carrinho após concluir o plano
        $carrinho->limparCarrinho($id_usuario);
        // Apagar o localStorage
        echo "<script>localStorage.removeItem('ordemAulas');</script>";
        echo "<script>localStorage.removeItem('dadosPlanoAula');</script>";
        // Apagar o cookie id_curso_carrinho
        setcookie('id_curso_carrinho', '', time() - 3600, '/'); // Expira o cookie
        // Redireciona para a página de sucesso com js pra permitir que o localStorage seja apagado
        echo '<p>Plano de aula criado com sucesso!<br>Aguarde...</p>';
        echo '<script>window.location.href = "../planos_listar.php?msg=plano_ok";</script>"';
        //header('Location: ../planos_listar.php?msg=0');
    }
} else {
    // Se houve um erro ao criar o plano, redireciona com mensagem de erro
    //echo '<script>alert("Erro ao criar o plano de aula. Tente novamente.");</script>';
    header('Location: ../carrinho.php?erro=carrinho_erro_infos');
}

?>