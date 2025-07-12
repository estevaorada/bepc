            <nav class="sidebar">
                <ul class="nav flex-column">
                     <li class="nav-item">
                        <a class="nav-link" href="painel.php">
                            <i class="bi bi-person-circle"></i> Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#planosSubmenu" aria-expanded="false">
                            <i class="bi bi-journal"></i> Planos de Aula
                        </a>
                        <ul class="collapse nav flex-column ms-3" id="planosSubmenu">
                            <li class="nav-item">
                                <a class="nav-link" href="planos_listar.php">Meus Planos de Aula</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#aulasSubmenu" aria-expanded="false">
                            <i class="bi bi-journal-bookmark-fill"></i> Aulas
                        </a>
                        <ul class="collapse nav flex-column ms-3" id="aulasSubmenu">
                            <li class="nav-item">
                                <a class="nav-link" href="aulas_minhas.php">Minhas Aulas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="aulas_criar.php">Criar aula</a>
                            </li>
                        </ul>
                    </li>
                    <!-- Configurações (apenas adm) -->
                    <?php if ($_SESSION['dados_usuario']['id_tipo'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#cfgSubmenu" aria-expanded="false">
                            <i class="bi bi-gear-fill"></i> Configurações
                        </a>
                        <ul class="collapse nav flex-column ms-3" id="cfgSubmenu">
                            <li class="nav-item">
                                <a class="nav-link" href="gerenciar_categorias.php">Gerenciar Categorias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="gerenciar_cursosniveis.php">Gerenciar Cursos e Níveis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="gerenciar_disciplinas.php">Gerenciar Disciplinas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="gerenciar_usuarios.php">Gerenciar Usuários</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="sair.php"><i class="bi bi-box-arrow-left"></i> Sair</a>
                    </li>
                </ul>
            </nav>