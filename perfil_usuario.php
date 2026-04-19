<?php
session_start();
include('conexao.php');
include('verifica_login.php');

if (isset($_GET['email_usuario'])) {
    $email_usuario = mysqli_real_escape_string($conexao, $_GET['email_usuario']);
    $query = "SELECT nome_usuario, email_usuario, perfil_usuario FROM usuario WHERE email_usuario = '$email_usuario'";
    $result = mysqli_query($conexao, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
    } else {
        echo "Usuário não encontrado."; exit;
    }
} else {
    echo "Email não fornecido."; exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - FrequenCy</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        /* O display: block anula o flexbox do style.css que estava quebrando a navbar */
        body { background-color: #f0f9f4; font-family: 'Poppins', sans-serif; display: block; margin: 0; }
        
        .conteudo-perfil { margin: 4vh auto 50px; width: 95%; max-width: 900px; }
        .dash-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); }
        
        .avatar-grande { 
            width: 100px; height: 100px; 
            background: linear-gradient(135deg, #0d8a4f, #12c95e); 
            color: white; border-radius: 50%; display: flex; 
            align-items: center; justify-content: center; 
            font-size: 2.5rem; font-weight: 700; margin: 0 auto 15px; 
        }
        
        .info-label { font-size: 0.85rem; color: #6c757d; font-weight: 600; text-transform: uppercase; }
        .info-value { font-size: 1.1rem; color: #2d3436; font-weight: 500; }
        
        .btn-outline-green { border: 2px solid #0d8a4f; color: #0d8a4f; font-weight: 600; border-radius: 50px; transition: 0.3s; }
        .btn-outline-green:hover { background: #0d8a4f; color: white; }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="conteudo-perfil">
        
        <div class="dash-card p-4 text-center mb-4 position-relative overflow-hidden">
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg, #0d8a4f, #ff7a1a);"></div>
            <div class="avatar-grande"><?= strtoupper(substr($usuario['nome_usuario'], 0, 1)); ?></div>
            <h3 class="fw-bold text-dark mb-1"><?= $usuario['nome_usuario']; ?></h3>
            <p class="text-muted mb-0"><?= htmlspecialchars(ucfirst($usuario['perfil_usuario'])); ?></p>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="dash-card p-4 h-100">
                    <h5 class="fw-bold mb-4 border-start border-warning border-4 ps-2">Dados da Conta</h5>
                    
                    <div class="info-label">Nome Completo</div>
                    <div class="info-value mb-3"><?= $usuario['nome_usuario']; ?></div>

                    <div class="info-label">E-mail</div>
                    <div class="info-value mb-3"><?= $usuario['email_usuario']; ?></div>

                    <div class="info-label">Status</div>
                    <div class="info-value"><span class="badge bg-success-subtle text-success rounded-pill px-3">Ativo</span></div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="dash-card p-4 h-100 d-flex flex-column justify-content-center text-center">
                    <h5 class="fw-bold mb-4">Ações</h5>
                    <div class="d-grid gap-3">
                        <a href="lista_usuario.php" class="btn btn-outline-green py-2">Lista de Usuários</a>
                        <a href="tela_edita_usuario.php?email_usuario=<?= $usuario['email_usuario']; ?>" class="btn btn-outline-primary fw-semibold rounded-pill py-2">Editar Perfil</a>
                        <button class="btn btn-outline-danger fw-semibold rounded-pill py-2">Excluir Conta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-4 py-3 text-center text-muted small">
        &copy; <?= date('Y'); ?> <span class="text-success fw-bold">Frequen</span><span class="text-warning fw-bold">Cy</span>. Todos os direitos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>