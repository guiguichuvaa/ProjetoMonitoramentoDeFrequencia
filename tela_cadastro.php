<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Criar Conta - FrequenCy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #fff9f5; font-family: 'Poppins', sans-serif; }
        .card-auth { border: none; border-radius: 20px; overflow: hidden; }
        
        .card-header-orange {
            background: linear-gradient(135deg, #ff7a1a, #ffb347);
            padding: 25px;
            text-align: center;
            color: white;
        }

        /* Inputs de Quadrado Branco Limpo */
        .form-control {
            background-color: #ffffff !important;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #ff7a1a;
            box-shadow: 0 0 0 0.25rem rgba(255, 122, 26, 0.25);
        }

        /* Correção do Botão Laranja (Baseado na sua imagem) */
        .btn-signup {
            background-color: transparent;
            border: 2px solid #ff7a1a;
            color: #ff7a1a;
            transition: all 0.3s ease;
        }
        .btn-signup:hover {
            background-color: #ff7a1a;
            color: #ffffff !important; /* Garante que o texto fique branco e não suma */
            box-shadow: 0 4px 15px rgba(255, 122, 26, 0.3);
        }

        .link-green { color: #0d8a4f; font-weight: 700; text-decoration: none; }
        .form-check-input:checked {
            background-color: #ff7a1a;
            border-color: #ff7a1a;
        }
    </style>
</head>
<body>
    <div class="container main-content pt-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="text-center mb-4">
                    <img src="image.png" alt="Logo" style="max-width: 160px;">
                </div>
                <div class="card card-auth shadow-lg">
                    <div class="card-header-orange">
                        <h2 class="fs-4 fw-bold mb-0">Criar Conta</h2>
                    </div>
                    <div class="card-body p-4 p-md-5 bg-white">
                        
                        <?php if (isset($_SESSION['mensagem'])): ?>
                            <div class="alert alert-warning alert-dismissible fade show fw-bold text-center" role="alert">
                                <?= $_SESSION['mensagem']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php unset($_SESSION['mensagem']); endif; ?>

                        <form action="cadastro.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary">Nome Completo:</label>
                                <input type="text" class="form-control" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary">E-mail:</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary">Senha:</label>
                                <input type="password" class="form-control" name="senha" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary d-block">Tipo de Conta:</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_usuario" id="col" value="Coletor">
                                        <label class="form-check-label fw-bold text-secondary" for="col">Coletor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_usuario" id="adm" value="Administrador" checked>
                                        <label class="form-check-label fw-bold text-secondary" for="adm">Administrador</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-signup btn-lg rounded-pill fw-bold text-uppercase">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="card-footer border-0 py-3 text-center" style="background-color: #f1fcf5;">
                        <span class="text-muted">Já tem uma conta?</span> 
                        <a href="tela_login.php" class="link-green ms-1">Fazer Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wave-container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#12c95e" fill-opacity="0.9" d="M0,160L80,149.3C160,139,320,117,480,138.7C640,160,800,224,960,229.3C1120,235,1280,181,1360,154.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
            <path fill="#06592a" d="M0,256L80,240C160,224,320,192,480,197.3C640,203,800,245,960,256C1120,267,1280,245,1360,234.7L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>