<?php
/* Arquivo de configuração do sistema */
/* Neste arquivo você irá configurar as variáveis do sistema, como:
 * - Informações do banco de dados
 * - Informações da instituição
 */

// Informações do banco de dados:
$servidor = "localhost"; // Servidor do banco de dados
$usuario = "root"; // Usuário do banco de dados
$senha = ""; // Senha do banco de dados
$banco = "bepc"; // Nome do banco de dados

// Informações da instituição:
$nome_instituicao = "Centro Universitário Teresa DÁvila"; // Nome da instituição
$descricao_instituicao = "Localizado no Vale do Paraíba na cidade de Lorena, o Centro Universitário Teresa DÁvila recebe alunos de várias regiões como Sul de Minas, Sul Fluminense e Litoral Norte e tem nos alunos formados o maior exemplo de qualidade do seu ensino: profissionais em cargos estratégicos na educação e em empresas da região, do Brasil e de vários países do Mundo."; // Descrição da instituição


// Não modifique as configurações abaixo.
define('DB_NOME', $banco);
define('DB_SERVIDOR', $servidor);
define('DB_USUARIO', $usuario);
define('DB_SENHA', $senha);

?>