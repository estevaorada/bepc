<?php
$arr_erros = array(
    'login' => 'Usuário ou senha inválidos!',
    'usuario_erro' => 'Você não tem acesso a este recurso.',
    'aula_erro' => 'Erro ao cadastrar aula. Verifique os dados e tente novamente.',
    'carrinho_erro' => 'Erro ao adicionar item ao carrinho. Tente novamente.',
    'carrinho_erro_infos' => 'Preencha todos os campos obrigatórios antes de concluir o carrinho.',
    'categoria_erro' => 'Erro ao cadastrar categoria. Verifique os dados e tente novamente.',
    'curso_erro' => 'Erro ao cadastrar curso. Verifique os dados e tente novamente.',
    'disicplina_erro' => 'Erro ao cadastrar disciplina. Verifique os dados e tente novamente.',
    'nivel_erro' => 'Erro ao cadastrar nível. Verifique os dados e tente novamente.',
    'usuario_erro_cadastro' => 'Erro ao cadastrar usuário. Verifique os dados e tente novamente.',
    'usuario_erro_modificacao' => 'Erro ao modificar dados do usuário. Verifique os dados e tente novamente.',
);
$arr_msg = array(
    'aula_cadastro_sucesso' => 'Aula cadastrada com sucesso!',
    'carrinho_add_ok' => 'Item adicionado ao carrinho com sucesso!',
    'plano_ok' => 'Plano de aula criado com sucesso!',
    'cadastro_sucesso' => 'Cadastro realizado com sucesso!',
    'modificacao_sucesso' => 'Dados pessoais do usuário modificados com sucesso!',
    'senha_modificada_sucesso' => 'Senha modificada com sucesso!',
);


if (isset($_GET['erro']) || isset($_GET['msg'])) {
    $tipo = isset($_GET['erro']) ? 'error' : 'success';
    $mensagem = isset($_GET['erro']) ? $arr_erros[$_GET['erro']] : $arr_msg[$_GET['msg']];
    if (!$mensagem) {
        $mensagem = 'Mensagem não definida.';
    }
    // Exibe a mensagem de erro ou sucesso
    echo '<script>
        Swal.fire({
            title: "' . ($tipo === 'error' ? 'Erro' : 'Sucesso') . '",
            text: "' . $mensagem . '",
            icon: "' . $tipo . '",
            customClass: {
            confirmButton: \'btn btn-outline-dark\',
            cancelButton: \'btn btn-outline-danger\'
            }
        });
    </script>';
?>
<?php } ?>