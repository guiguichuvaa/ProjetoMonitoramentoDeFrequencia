<?php
session_start();
include('conexao.php');
include('lista.php'); // Mantendo sua lógica de busca original
include('dados.php'); // Funções de contagem de faltas e frequências
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Faltas - FrequenCy</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon_io/image.png" type="image/x-icon">

    <style>
        /* 1. IMPORTAÇÃO DAS FONTES (Caminho ajustado para a pasta /fonts) */
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

        /* 2. RESET PARA CORRIGIR O CABEÇALHO */
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

        /* 3. AJUSTE DA NAVBAR (LOGO E MENU) */
        .navbar {
            margin-bottom: 0 !important;
            padding: 0.5rem 1rem !important;
            width: 100%;
        }

        /* 4. CONTEÚDO DA LISTA */
        .container-lista {
            margin: 25px auto;
            width: 95%;
            max-width: 1200px;
        }

        .titulo-verde {
            color: #0d8a4f;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .form-control,
        .form-select {
            border-radius: 50px !important;
            padding: 8px 18px;
            border: 1px solid #ced4da;
        }

        .btn-success-custom {
            background-color: #0d8a4f;
            border: none;
            color: white;
            border-radius: 50px;
            font-weight: 600;
            padding: 8px 25px;
            transition: 0.3s;
        }

        .btn-success-custom:hover {
            background-color: #0a6e3f;
            transform: translateY(-1px);
        }

        /* Estilo da Tabela */
        .custom-card {
            background-color: #ffffff;
            border-radius: 25px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            padding: 10px;
        }

        .table thead th {
            border: none;
            font-weight: 600;
            color: #333;
            padding: 15px;
        }

        .table tbody td {
            vertical-align: middle;
            border-top: 1px solid #f8f9fa;
            padding: 15px;
        }

        .btn-action {
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 5px 15px;
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

        .badge-turma {
            color: #0d8a4f;
            border: 2px solid #0d8a4f;
            padding: 3px 12px;
            border-radius: 50px;
            font-weight: 700;
        }

        .badge-number {
            color: #dc3545;
            border: 2px solid #dc3545;
            padding: 3px 12px;
            border-radius: 50px;
            font-weight: 700;
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
                <h2 class="titulo-verde mb-2 mt-3">Lista de Faltas - <?php echo date('d/m/Y', strtotime($_GET['data'])); ?></h2>
            </div>
        </div>


        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 shadow-sm border-0 mb-4 text-center" role="alert">
                <?php echo $_SESSION['mensagem'];
                unset($_SESSION['mensagem']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        

        <div class="custom-card shadow-sm">
            <div class="table-responsive">
                <table class="table mb-0 text-center">
                    <thead>
                        <tr>
                            <th class="text-start ps-4">Nome Completo</th>
                            <th>Turma</th>
                            <th>Número</th>
                            <th>Matrícula</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($alunosFiltrados)): ?>
                            <?php foreach ($alunosFiltrados as $aluno): ?>
                                <tr>
                                    <td class="text-start ps-4 fw-bold text-secondary"><?php echo $aluno['nome_aluno']; ?></td>
                                    <td><span class="badge-turma"><?php echo $aluno['turma_aluno']; ?></span></td>
                                    <td><span class="badge-number"><?php echo $aluno['numero_aluno']; ?></span></td>
                                    <td class="text-muted"><?php echo $aluno['matricula']; ?></td>
                                   
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-4 text-muted">Nenhum registro encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        

    </div>
    <?php include('footer.php'); ?>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 text-muted">Deseja realmente excluir este aluno?</div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger rounded-pill px-4">Excluir</a>
                </div>
            </div>
        </div>
    </div>

    

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var matricula = button.getAttribute('data-matricula');
            document.getElementById('confirmDeleteBtn').href = 'exclui_aluno.php?matricula=' + matricula;
        });
    </script>
    
</body>

</html>