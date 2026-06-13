<?php
session_start();
include('conexao.php');
include('listar_usuario.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Usuários - FrequenCy</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon_io/image.png" type="image/x-icon">

    <style>
        /* 1. IMPORTAÇÃO DAS FONTES (Pasta /fonts) */
        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-regular.woff2') format('woff2');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-500.woff2') format('woff2');
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-600.woff2') format('woff2');
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-700.woff2') format('woff2');
            font-weight: 700;
            font-style: normal;
        }

        /* 2. RESET PARA CORRIGIR O CABEÇALHO E A FONTE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif !important;
        }

        body {
            background-color: #f0f9f4;
            color: #444;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* 3. AJUSTE DA NAVBAR */
        .navbar {
            margin-bottom: 0 !important;
            padding: 0.5rem 1rem !important;
            width: 100%;
        }

        .container-lista {
            margin: 30px auto;
            width: 95%;
            max-width: 1200px;
        }

        .titulo-verde {
            color: #0d8a4f;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        /* 4. FILTROS */
        .filter-section {
            background: white;
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .form-control {
            border-radius: 50px !important;
            padding: 10px 20px;
            border: 1px solid #ced4da;
        }

        .btn-search {
            background-color: #0d8a4f;
            border: none;
            color: white;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            padding: 10px;
        }

        .btn-search:hover {
            background-color: #0a6e3f;
            transform: translateY(-1px);
        }

        /* 5. TABELA E CARDS */
        .custom-card {
            background-color: #ffffff;
            border-radius: 25px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            padding: 10px;
            overflow: hidden;
        }

        .table-header-green {
            background-color: #0d8a4f !important;
            color: white !important;
        }

        .table thead th {
            border: none;
            padding: 18px;
            font-weight: 600;
        }

        .table tbody td {
            vertical-align: middle;
            border-top: 1px solid #f8f9fa;
            padding: 15px;
        }

        /* 6. BOTÕES DE AÇÃO (Pílula) */
        .btn-action {
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 6px 18px;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
        }

        .btn-view {
            border: 1px solid #0d6efd;
            color: #0d6efd;
            background: transparent;
        }

        .btn-view:hover {
            background: #0d6efd;
            color: white;
        }

        .btn-edit {
            border: 1px solid #198754;
            color: #198754;
            background: transparent;
        }

        .btn-edit:hover {
            background: #198754;
            color: white;
        }

        .btn-delete {
            border: 1px solid #dc3545;
            color: #dc3545;
            background: transparent;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        /* Badges */
        .badge-status {
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-sim {
            background-color: #e6f4ea;
            color: #0d8a4f;
            border: 1px solid #0d8a4f;
        }

        .status-nao {
            background-color: #fff1f0;
            color: #cf1322;
            border: 1px solid #ffa39e;
        }
    </style>
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container-lista">

        <div class="row align-items-center mb-3 header-row">
            <div class="col-auto">
                <a href="painel.php" class="btn btn-danger rounded-pill px-4 mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
                    </svg>
                </a>
            </div>
            <div class="col text-center">
                <h2 class="titulo-verde mb-2 mt-3">Lista de Usuários</h2>
            </div>
        </div>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-warning alert-dismissible fade show fw-bold text-center" role="alert">
                <?= $_SESSION['mensagem']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['mensagem']);
        endif; ?>

        <div class="filter-section">
            <form method="get" action="lista_usuario.php">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Nome do Usuário</label>
                        <input type="text" name="nome" class="form-control" placeholder="Buscar por nome..." value="<?php echo htmlspecialchars($filterNome); ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">E-mail</label>
                        <input type="email" name="email" class="form-control" placeholder="Buscar por e-mail..." value="<?php echo htmlspecialchars($filterEmail); ?>">
                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-search w-100">Buscar Usuários</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="custom-card shadow-sm">
            <div class="table-responsive">
                <table class="table mb-0 text-center">
                    <thead class="table-header-green">
                        <tr>
                            <th class="text-start ps-4">Nome do Usuário</th>
                            <th>E-mail</th>
                            <th>Autorizado</th>
                            <th class="pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td class="text-start ps-4 fw-bold text-secondary"><?php echo $usuario['nome_usuario']; ?></td>
                                    <td class="text-muted"><?php echo $usuario['email_usuario']; ?></td>
                                    <td>
                                        <?php if ($usuario['is_autorized'] == 1): ?>
                                            <span class="badge-status status-sim">Sim</span>
                                        <?php else: ?>
                                            <span class="badge-status status-nao">Não</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="perfil_usuario.php?email_usuario=<?php echo $usuario['email_usuario']; ?>" class="btn-action btn-view">Ver</a>
                                            <a href="tela_edita_usuario.php?email_usuario=<?php echo $usuario['email_usuario']; ?>" class="btn-action btn-edit">Editar</a>
                                            <button class="btn-action btn-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal"
                                                data-email="<?php echo $usuario['email_usuario']; ?>">
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-4 text-muted">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 text-muted">Deseja realmente excluir este usuário? Esta ação não poderá ser desfeita.</div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger rounded-pill px-4">Confirmar Exclusão</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var email = button.getAttribute('data-email');
            document.getElementById('confirmDeleteBtn').href = 'exclui_usuario.php?email_usuario=' + email;
        });
    </script>
</body>

</html>