-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/07/2025 às 21:18
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bepc`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aulas`
--

CREATE TABLE `aulas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `observacoes` text DEFAULT NULL,
  `data_cadastrada` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `id_disciplina` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aulas`
--

INSERT INTO `aulas` (`id`, `titulo`, `descricao`, `observacoes`, `data_cadastrada`, `id_usuario`, `id_disciplina`, `id_categoria`) VALUES
(1, 'Introdução à lógica de programação com C#', '<h3 data-start=\"280\" data-end=\"322\">1. Abertura e Apresentação do Tema</h3><ul data-start=\"323\" data-end=\"591\">\r\n<li data-start=\"323\" data-end=\"390\">\r\n<p data-start=\"325\" data-end=\"390\">O professor cumprimenta os alunos e apresenta o objetivo da aula.</p>\r\n</li>\r\n<li data-start=\"391\" data-end=\"504\">\r\n<p data-start=\"393\" data-end=\"504\">Explica brevemente o que é lógica de programação e a importância dela na construção de sistemas computacionais.</p>\r\n</li>\r\n<li data-start=\"505\" data-end=\"591\">\r\n<p data-start=\"507\" data-end=\"591\">Introduz o C# como a linguagem que será usada nas atividades práticas da disciplina.</p>\r\n</li>\r\n</ul><h3 data-start=\"598\" data-end=\"656\">2. Explicação do Conceito de Lógica de Programação</h3><ul data-start=\"657\" data-end=\"927\">\r\n<li data-start=\"657\" data-end=\"769\">\r\n<p data-start=\"659\" data-end=\"769\">O professor define o conceito de lógica de programação como uma sequência de passos para resolver um problema.</p>\r\n</li>\r\n<li data-start=\"770\" data-end=\"837\">\r\n<p data-start=\"772\" data-end=\"837\">Aponta a relação entre pensamento lógico e solução computacional.</p>\r\n</li>\r\n<li data-start=\"838\" data-end=\"927\">\r\n<p data-start=\"840\" data-end=\"927\">Utiliza exemplos do cotidiano para ilustrar a ideia de algoritmos e sequências lógicas.</p>\r\n</li>\r\n</ul><h3 data-start=\"934\" data-end=\"970\">3. Introdução à Linguagem C#</h3><ul data-start=\"971\" data-end=\"1231\">\r\n<li data-start=\"971\" data-end=\"1120\">\r\n<p data-start=\"973\" data-end=\"1120\">O professor apresenta a linguagem C#, destacando suas principais características (moderna, orientada a objetos, desenvolvida pela Microsoft, etc.).</p>\r\n</li>\r\n<li data-start=\"1121\" data-end=\"1231\">\r\n<p data-start=\"1123\" data-end=\"1231\">Explica como a linguagem será utilizada como ferramenta para aplicar os conceitos de lógica durante o curso.</p>\r\n</li>\r\n</ul><h3 data-start=\"1238\" data-end=\"1279\">4. Estrutura de um Programa em C#</h3><ul data-start=\"1280\" data-end=\"1573\">\r\n<li data-start=\"1280\" data-end=\"1441\">\r\n<p data-start=\"1282\" data-end=\"1441\">O professor descreve como é organizado um programa simples em C#, destacando os principais elementos: diretivas de uso, estrutura de classe e método principal.</p>\r\n</li>\r\n<li data-start=\"1442\" data-end=\"1573\">\r\n<p data-start=\"1444\" data-end=\"1573\">Mostra aos alunos onde o código será escrito e executado (por exemplo, em uma IDE como Visual Studio ou em um compilador online).</p>\r\n</li>\r\n</ul><h3 data-start=\"1580\" data-end=\"1629\">5. Conceito de Variáveis e Tipos de Dados</h3><ul data-start=\"1630\" data-end=\"1920\">\r\n<li data-start=\"1630\" data-end=\"1729\">\r\n<p data-start=\"1632\" data-end=\"1729\">O professor introduz o conceito de variáveis como espaços de memória usados para armazenar dados.</p>\r\n</li>\r\n<li data-start=\"1730\" data-end=\"1840\">\r\n<p data-start=\"1732\" data-end=\"1840\">Explica os principais tipos de dados utilizados em C# (inteiros, números decimais, texto e valores lógicos).</p>\r\n</li>\r\n<li data-start=\"1841\" data-end=\"1920\">\r\n<p data-start=\"1843\" data-end=\"1920\">Enfatiza a importância de escolher o tipo de dado correto para cada situação.</p>\r\n</li>\r\n</ul><h3 data-start=\"1927\" data-end=\"1962\">6. Entrada e Saída de Dados</h3><ul data-start=\"1963\" data-end=\"2206\">\r\n<li data-start=\"1963\" data-end=\"2079\">\r\n<p data-start=\"1965\" data-end=\"2079\">O professor demonstra como o programa pode interagir com o usuário, solicitando informações e exibindo resultados.</p>\r\n</li>\r\n<li data-start=\"2080\" data-end=\"2206\">\r\n<p data-start=\"2082\" data-end=\"2206\">Aborda o conceito de entrada (input) e saída (output) de dados, reforçando sua importância para a comunicação com o usuário.</p>\r\n</li>\r\n</ul><h3 data-start=\"2213\" data-end=\"2251\">7. Conversão de Tipos de Dados</h3><ul data-start=\"2252\" data-end=\"2479\">\r\n<li data-start=\"2252\" data-end=\"2388\">\r\n<p data-start=\"2254\" data-end=\"2388\">O professor orienta os alunos sobre como tratar os dados recebidos como texto e transformá-los em números ou outros tipos apropriados.</p>\r\n</li>\r\n<li data-start=\"2389\" data-end=\"2479\">\r\n<p data-start=\"2391\" data-end=\"2479\">Explica que essa conversão é essencial para permitir operações com os valores recebidos.</p>\r\n</li>\r\n</ul><h3 data-start=\"2486\" data-end=\"2520\">8. Operadores e Expressões</h3><ul data-start=\"2521\" data-end=\"2742\">\r\n<li data-start=\"2521\" data-end=\"2594\">\r\n<p data-start=\"2523\" data-end=\"2594\">O professor apresenta os operadores aritméticos, relacionais e lógicos.</p>\r\n</li>\r\n<li data-start=\"2595\" data-end=\"2742\">\r\n<p data-start=\"2597\" data-end=\"2742\">Explica como essas operações são utilizadas para construir expressões que realizam cálculos, comparações e tomadas de decisão dentro do programa.</p>\r\n</li>\r\n</ul><h3 data-start=\"2749\" data-end=\"2787\">9. Atividade Prática Orientada</h3><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><ul data-start=\"2788\" data-end=\"3136\">\r\n<li data-start=\"2788\" data-end=\"2883\">\r\n<p data-start=\"2790\" data-end=\"2883\">O professor propõe um pequeno desafio de programação para fixação dos conteúdos apresentados.</p>\r\n</li>\r\n<li data-start=\"2884\" data-end=\"3050\">\r\n<p data-start=\"2886\" data-end=\"3050\">Orienta os alunos passo a passo na criação de um programa simples, reforçando os conceitos explicados anteriormente (uso de variáveis, entrada, saída e operadores).</p>\r\n</li>\r\n<li data-start=\"3051\" data-end=\"3136\">\r\n<p data-start=\"3053\" data-end=\"3136\">Dá tempo para os alunos implementarem com apoio e tira dúvidas conforme necessário.</p></li></ul>', 'Sugere-se que seja realizada preferencialmente em um laboratório de informática.', '2025-07-24 14:45:59', 1, 2, 1),
(2, 'Introdução a hardware de computadores', '<h3 data-start=\"379\" data-end=\"421\">1. Abertura e Apresentação do Tema</h3><ul data-start=\"422\" data-end=\"673\">\r\n<li data-start=\"422\" data-end=\"522\">\r\n<p data-start=\"424\" data-end=\"522\">O professor inicia a aula com uma breve saudação e apresenta o tema: Hardware de Computadores.</p>\r\n</li>\r\n<li data-start=\"523\" data-end=\"673\">\r\n<p data-start=\"525\" data-end=\"673\">Explica que o objetivo da aula é entender o que é hardware, quais são seus tipos e como os componentes trabalham juntos em um sistema computacional.</p>\r\n</li>\r\n</ul><h3 data-start=\"680\" data-end=\"715\">2. Conceituação de Hardware</h3><ul data-start=\"716\" data-end=\"973\">\r\n<li data-start=\"716\" data-end=\"835\">\r\n<p data-start=\"718\" data-end=\"835\">O professor define o termo hardware como a parte física do computador – ou seja, tudo aquilo que pode ser tocado.</p>\r\n</li>\r\n<li data-start=\"836\" data-end=\"973\">\r\n<p data-start=\"838\" data-end=\"973\">Diferencia hardware de software, destacando que o hardware é responsável por executar fisicamente as instruções que o software fornece.</p>\r\n</li>\r\n</ul><h3 data-start=\"980\" data-end=\"1032\">3. Classificação dos Componentes de Hardware</h3><ul data-start=\"1033\" data-end=\"1332\">\r\n<li data-start=\"1033\" data-end=\"1240\">\r\n<p data-start=\"1035\" data-end=\"1133\">O professor apresenta a classificação geral dos componentes de hardware em três grupos principais:</p>\r\n<ul data-start=\"1136\" data-end=\"1240\">\r\n<li data-start=\"1136\" data-end=\"1162\">\r\n<p data-start=\"1138\" data-end=\"1162\">Dispositivos de entrada.</p>\r\n</li>\r\n<li data-start=\"1165\" data-end=\"1189\">\r\n<p data-start=\"1167\" data-end=\"1189\">Dispositivos de saída.</p>\r\n</li>\r\n<li data-start=\"1192\" data-end=\"1240\">\r\n<p data-start=\"1194\" data-end=\"1240\">Dispositivos de processamento e armazenamento.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li data-start=\"1241\" data-end=\"1332\">\r\n<p data-start=\"1243\" data-end=\"1332\">Explica a função de cada grupo de forma conceitual, sem ainda citar exemplos específicos.</p>\r\n</li>\r\n</ul><h3 data-start=\"1339\" data-end=\"1397\">4. Explicação da Função dos Principais Componentes</h3><ul data-start=\"1398\" data-end=\"1733\">\r\n<li data-start=\"1398\" data-end=\"1630\">\r\n<p data-start=\"1400\" data-end=\"1499\">O professor descreve o papel dos principais componentes internos e externos de um computador, como:</p>\r\n<ul data-start=\"1502\" data-end=\"1630\">\r\n<li data-start=\"1502\" data-end=\"1543\">\r\n<p data-start=\"1504\" data-end=\"1543\">Unidade Central de Processamento (CPU).</p>\r\n</li>\r\n<li data-start=\"1546\" data-end=\"1578\">\r\n<p data-start=\"1548\" data-end=\"1578\">Memória (RAM e armazenamento).</p>\r\n</li>\r\n<li data-start=\"1581\" data-end=\"1593\">\r\n<p data-start=\"1583\" data-end=\"1593\">Placa-mãe.</p>\r\n</li>\r\n<li data-start=\"1596\" data-end=\"1630\">\r\n<p data-start=\"1598\" data-end=\"1630\">Fontes de energia e periféricos.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li data-start=\"1631\" data-end=\"1733\">\r\n<p data-start=\"1633\" data-end=\"1733\">Enfatiza que todos os componentes trabalham de forma integrada para executar tarefas computacionais.</p>\r\n</li>\r\n</ul><h3 data-start=\"1740\" data-end=\"1798\">5. Apresentação do Fluxo de Dados em um Computador</h3><ul data-start=\"1799\" data-end=\"2059\">\r\n<li data-start=\"1799\" data-end=\"1922\">\r\n<p data-start=\"1801\" data-end=\"1922\">O professor explica como os dados circulam dentro de um computador: da entrada, passando pelo processamento, até a saída.</p>\r\n</li>\r\n<li data-start=\"1923\" data-end=\"2059\">\r\n<p data-start=\"1925\" data-end=\"2059\">Utiliza uma analogia simples (como uma fábrica ou cozinha) para facilitar o entendimento sobre o papel de cada componente nesse fluxo.</p>\r\n</li>\r\n</ul><h3 data-start=\"2066\" data-end=\"2132\">6. Discussão sobre a Importância do Hardware no Desempenho</h3><ul data-start=\"2133\" data-end=\"2355\">\r\n<li data-start=\"2133\" data-end=\"2259\">\r\n<p data-start=\"2135\" data-end=\"2259\">O professor destaca como o desempenho do computador pode ser afetado pelo tipo e pela qualidade dos componentes de hardware.</p>\r\n</li>\r\n<li data-start=\"2260\" data-end=\"2355\">\r\n<p data-start=\"2262\" data-end=\"2355\">Fala brevemente sobre como diferentes aplicações exigem diferentes configurações de hardware.</p>\r\n</li>\r\n</ul><h3 data-start=\"2362\" data-end=\"2433\">7. Atividade Prática (ou Expositiva, se não houver laboratório)</h3><ul data-start=\"2434\" data-end=\"2726\">\r\n<li data-start=\"2434\" data-end=\"2617\">\r\n<p data-start=\"2436\" data-end=\"2501\">O professor propõe uma atividade de identificação de componentes:</p>\r\n<ul data-start=\"2504\" data-end=\"2617\">\r\n<li data-start=\"2504\" data-end=\"2552\">\r\n<p data-start=\"2506\" data-end=\"2552\">Pode ser feita por meio de imagens projetadas.</p>\r\n</li>\r\n<li data-start=\"2555\" data-end=\"2617\">\r\n<p data-start=\"2557\" data-end=\"2617\">Pode envolver manuseio físico (se houver peças disponíveis).</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li data-start=\"2618\" data-end=\"2726\">\r\n<p data-start=\"2620\" data-end=\"2726\">Solicita que os alunos reconheçam os componentes e descrevam suas funções com base na explicação anterior.</p>\r\n</li>\r\n</ul><h3 data-start=\"2733\" data-end=\"2794\">8. Curiosidades ou Tendências Tecnológicas (opcional)</h3><ul data-start=\"2795\" data-end=\"3052\">\r\n<li data-start=\"2795\" data-end=\"2954\">\r\n<p data-start=\"2797\" data-end=\"2954\">O professor pode reservar alguns minutos para apresentar brevemente tendências em hardware, como miniaturização, dispositivos móveis, ou realidade aumentada.</p>\r\n</li>\r\n<li data-start=\"2955\" data-end=\"3052\">\r\n<p data-start=\"2957\" data-end=\"3052\">Estimula os alunos a refletirem sobre como o hardware evolui com o tempo e impacta o cotidiano.</p>\r\n</li>\r\n</ul><h3 data-start=\"3059\" data-end=\"3091\">9. Recapitulação da Aula</h3><ul data-start=\"3092\" data-end=\"3308\">\r\n<li data-start=\"3092\" data-end=\"3259\">\r\n<p data-start=\"3094\" data-end=\"3154\">O professor faz uma revisão dos principais pontos abordados:</p>\r\n<ul data-start=\"3157\" data-end=\"3259\">\r\n<li data-start=\"3157\" data-end=\"3176\">\r\n<p data-start=\"3159\" data-end=\"3176\">O que é hardware.</p>\r\n</li>\r\n<li data-start=\"3179\" data-end=\"3217\">\r\n<p data-start=\"3181\" data-end=\"3217\">Principais categorias e componentes.</p>\r\n</li>\r\n<li data-start=\"3220\" data-end=\"3259\">\r\n<p data-start=\"3222\" data-end=\"3259\">Como os componentes funcionam juntos.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li data-start=\"3260\" data-end=\"3308\">\r\n<p data-start=\"3262\" data-end=\"3308\">Reforça a distinção entre hardware e software.</p>\r\n</li>\r\n</ul><h3 data-start=\"3315\" data-end=\"3359\">10. Encerramento e Tarefa de Fixação</h3><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><ul data-start=\"3360\" data-end=\"3751\">\r\n<li data-start=\"3360\" data-end=\"3411\">\r\n<p data-start=\"3362\" data-end=\"3411\">O professor abre espaço para dúvidas e perguntas.</p>\r\n</li>\r\n<li data-start=\"3412\" data-end=\"3635\">\r\n<p data-start=\"3414\" data-end=\"3455\">Propõe uma atividade simples como tarefa:</p>\r\n<ul data-start=\"3458\" data-end=\"3635\">\r\n<li data-start=\"3458\" data-end=\"3534\">\r\n<p data-start=\"3460\" data-end=\"3534\">Exemplo: montar um diagrama com os componentes de hardware e suas funções.</p>\r\n</li>\r\n<li data-start=\"3537\" data-end=\"3635\">\r\n<p data-start=\"3539\" data-end=\"3635\">Ou: pesquisar as especificações de um computador pessoal ou de uma máquina usada em uma empresa.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li data-start=\"3636\" data-end=\"3751\">\r\n<p data-start=\"3638\" data-end=\"3751\">Informa o conteúdo da próxima aula (por exemplo, introdução ao software ou funcionamento do sistema operacional).</p></li></ul>', 'Sugere-se que aconteça em um laboratório de hardware, com equipamentos (kit morto) adequados.', '2025-07-24 14:50:40', 1, 3, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `aulas_planos`
--

CREATE TABLE `aulas_planos` (
  `id` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_plano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `carrinho`
--

INSERT INTO `carrinho` (`id`, `id_usuario`, `id_aula`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES
(1, 'Lógica de Programação', 'Aulas relacionadas a conceitos básicos de lógica de programação, como tipos primitivos de variáveis, estruturas condicionais, laços de repetição, funções e algoritmos.'),
(2, 'Gestão de Pessoas', 'Aulas sobre os principais conceitos e práticas da gestão de pessoas, incluindo liderança, motivação, trabalho em equipe, comunicação, avaliação de desempenho e desenvolvimento de talentos.'),
(3, 'Gestão de Projetos de TI', 'Aulas voltadas para o planejamento, execução e controle de projetos na área de tecnologia da informação.'),
(4, 'Manutenção de Computadores', 'Aulas referentes a manutenção de computadores.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `id_nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `id_nivel`) VALUES
(1, 'Técnico em Informática', 1),
(2, 'Ciência da Computação', 3),
(3, 'Técnico em Recursos Humanos', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplinas`
--

CREATE TABLE `disciplinas` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `disciplinas`
--

INSERT INTO `disciplinas` (`id`, `nome`, `id_curso`) VALUES
(1, 'Lógica de Programação', 2),
(2, 'Programação Orientada a Objetos', 1),
(3, 'Manutenção de Hardware', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `niveis`
--

CREATE TABLE `niveis` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `niveis`
--

INSERT INTO `niveis` (`id`, `nome`) VALUES
(1, 'Técnico'),
(2, 'Livre'),
(3, 'Graduação'),
(4, 'Extensão');

-- --------------------------------------------------------

--
-- Estrutura para tabela `planos`
--

CREATE TABLE `planos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_disciplina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `sobrenome` varchar(250) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `situacao` tinyint(4) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `id_tipo`, `email`, `senha`, `situacao`, `data_cadastro`) VALUES
(1, 'Estevao', 'Rada Oliveira', 1, 'e@e.com', '$2y$10$Lv81JkxYAXyI61iVCa1qJOHO.u3uzPVzpGQKGJcSqixzjqE6G.uB.', 1, '2025-07-24 14:13:19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_tipo`
--

CREATE TABLE `usuarios_tipo` (
  `id` int(11) NOT NULL,
  `nome_tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios_tipo`
--

INSERT INTO `usuarios_tipo` (`id`, `nome_tipo`) VALUES
(1, 'Coordenador'),
(2, 'Docente');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_idx` (`id_usuario`),
  ADD KEY `categorias_idx` (`id_categoria`),
  ADD KEY `disciplina_idx` (`id_disciplina`);

--
-- Índices de tabela `aulas_planos`
--
ALTER TABLE `aulas_planos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aula_idx` (`id_aula`),
  ADD KEY `plano_idx` (`id_plano`);

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_idx` (`id_usuario`),
  ADD KEY `aula_idx` (`id_aula`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nivel_idx` (`id_nivel`);

--
-- Índices de tabela `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_idx` (`id_curso`);

--
-- Índices de tabela `niveis`
--
ALTER TABLE `niveis`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_idx` (`id_usuario`),
  ADD KEY `disciplina_idx` (`id_disciplina`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_idx` (`id_tipo`);

--
-- Índices de tabela `usuarios_tipo`
--
ALTER TABLE `usuarios_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_tipo_UNIQUE` (`nome_tipo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `aulas_planos`
--
ALTER TABLE `aulas_planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `disciplinas`
--
ALTER TABLE `disciplinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `niveis`
--
ALTER TABLE `niveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios_tipo`
--
ALTER TABLE `usuarios_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aulas`
--
ALTER TABLE `aulas`
  ADD CONSTRAINT `categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `disciplina` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplinas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `aulas_planos`
--
ALTER TABLE `aulas_planos`
  ADD CONSTRAINT `aula_fk_aulasplanos` FOREIGN KEY (`id_aula`) REFERENCES `aulas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `plano_fk_aulasplanos` FOREIGN KEY (`id_plano`) REFERENCES `planos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `aula_fk_carriho` FOREIGN KEY (`id_aula`) REFERENCES `aulas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_fk_carrinho` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `nivel` FOREIGN KEY (`id_nivel`) REFERENCES `niveis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD CONSTRAINT `curso` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `planos`
--
ALTER TABLE `planos`
  ADD CONSTRAINT `disciplina_fk_planos` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplinas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_fk_planos` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `tipo` FOREIGN KEY (`id_tipo`) REFERENCES `usuarios_tipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
