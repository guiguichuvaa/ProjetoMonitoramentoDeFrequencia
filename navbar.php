<nav class="navbar shadow-sm" style="background-color: #eaf5ee;">
    <div class="container-fluid px-3 px-md-4">
        
        <a class="navbar-brand d-flex align-items-center gap-2" href="painel.php">
            <img style="width: 50px; height: 50px; object-fit: contain;" src="download.png" alt="Logo">
            <div>
                <span class="text-success fw-bold fs-3">Frequen</span><span class="text-warning fw-bold fs-3">Cy</span>
            </div>
        </a>
        
        <button class="navbar-toggler border-0 shadow-sm px-2 py-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" style="background-color: #ffffff;">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #ffffff;">
            
            <?php 
                // Busca inteligente do email do usuário na sessão
                $_SESSION['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : null;
                $emailUsuario = $_SESSION['email'];
                

                // Busca inteligente do nome do usuário na sessão
                $nomeUsuario = 'Usuário';
                if (!empty($_SESSION['nome_usuario'])) {
                    $nomeUsuario = $_SESSION['nome_usuario'];
                } elseif (!empty($_SESSION['nome'])) {
                    $nomeUsuario = $_SESSION['nome'];
                }

                // Busca inteligente do perfil do usuário
                $perfilUsuario = 'Administrador';
                if (!empty($_SESSION['perfil_usuario'])) {
                    $perfilUsuario = $_SESSION['perfil_usuario'];
                }
            ?>

            <div class="offcanvas-header pb-4 pt-4 px-4 d-flex flex-column align-items-center position-relative" style="border-bottom: 1px solid #eaf5ee; z-index: 10; background-color: #ffffff;">
                
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>

                <div class="mb-2 mt-3 shadow-sm rounded-circle" style="width: 85px; height: 85px; overflow: hidden; border: 3px solid #12c95e; background-color: #f0f9f4;">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($nomeUsuario) ?>&background=0d8a4f&color=fff&size=100" alt="Foto de Perfil" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <h5 class="offcanvas-title fw-bold m-0 fs-5 text-center mt-2" id="offcanvasNavbarLabel" style="color: #1c3249;">
                    <?= htmlspecialchars($nomeUsuario); ?>
                </h5>
                <span class="text-success fw-bold mt-1" style="font-size: 0.9rem;">
                    <?= htmlspecialchars(ucfirst($perfilUsuario)); ?>
                </span>
            </div>

            <div class="offcanvas-body d-flex flex-column p-0 position-relative" style="overflow-x: hidden;">
                
                <ul class="navbar-nav flex-grow-1 fs-5 gap-2 px-4 pt-4 position-relative" style="z-index: 10;">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3" href="perfil_usuario.php?email_usuario=<?= urlencode($emailUsuario) ?>" style="color: #1c3249; font-weight: 500;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d8a4f" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289
                            10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg>
                            Meu Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3" href="lista_frequencia.php" style="color: #1c3249; font-weight: 500;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d8a4f" class="bi bi-clipboard-check" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/><path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/></svg>
                            Realizar Frequência
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3" href="lista_alunos.php" style="color: #1c3249; font-weight: 500;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d8a4f" class="bi bi-people" viewBox="0 0 16 16"><path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/></svg>
                            Lista de Alunos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3" href="tela_cadastro_aluno.php" style="color: #1c3249; font-weight: 500;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d8a4f" class="bi bi-person-plus" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/><path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/></svg>
                            Adicionar Aluno
                        </a>
                    </li>
                </ul>
                
                <div class="mt-auto px-4 position-relative" style="z-index: 10; margin-bottom: 130px;">
                    <a class="nav-link fs-6 text-uppercase fw-bold d-flex align-items-center justify-content-center gap-2" href="logout.php" style="color: #dc3545; background-color: #fff0f0; padding: 12px; border-radius: 8px; border: 1px solid #ffdbdb;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg>
                        Sair do Sistema
                    </a>
                </div>

                <div style="position: absolute; bottom: 0; left: 0; width: 100%; z-index: 1; pointer-events: none; line-height: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" style="display: block; width: 100%; height: 130px;">
                        <path fill="#12c95e" fill-opacity="0.9" d="M0,160L80,149.3C160,139,320,117,480,138.7C640,160,800,224,960,229.3C1120,235,1280,181,1360,154.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                    </svg>
                </div>

            </div>
            
        </div>
    </div>
</nav>