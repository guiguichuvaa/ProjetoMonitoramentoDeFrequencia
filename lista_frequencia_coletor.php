<?php
session_start();
include('conexao.php');
include('verifica_login.php');
include('lista.php');

// 1. Pega a data (se não tiver, usa a de hoje)
$filterData = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');
$filterNome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$filterTurma = isset($_GET['turma']) ? trim($_GET['turma']) : '';

// 2. BUSCA DO BANCO (Aqui já traz 'Ausente' se foi salvo antes)
$alunos = buscar_alunos_com_situacao($conexao, $filterData);

// 3. APLICA FILTROS DE TELA (Sem perder a situação do banco)
$alunosFiltrados = array();
foreach ($alunos as $aluno) {
    $match = true;

    if ($filterNome !== '' && stripos($aluno['nome_aluno'], $filterNome) === false) {
        $match = false;
    }
    if ($filterTurma !== '' && $filterTurma !== 'Selecione' && $aluno['turma_aluno'] !== $filterTurma) {
        $match = false;
    }

    if ($match) {
        $alunosFiltrados[] = $aluno;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Realizar Frequência - FrequenCy</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon_io/image.png" type="image/x-icon">
    <style>
        /* 1. IMPORTAÇÃO DAS FONTES (Pasta /fonts) */
        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-regular.woff2') format('woff2');
            font-weight: 400;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-500.woff2') format('woff2');
            font-weight: 500;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-600.woff2') format('woff2');
            font-weight: 600;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v24-latin-700.woff2') format('woff2');
            font-weight: 700;
        }

        /* 2. RESET TOTAL PARA O CABEÇALHO FICAR NO TOPO */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif !important;
        }

        body {
            background-color: #fffaf5;
            color: #444;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* 3. FIXAÇÃO DA NAVBAR */
        .navbar {
            margin-bottom: 0 !important;
            padding: 0.5rem 1rem !important;
            width: 100%;
        }

        .conteudo-pagina {
            margin: 30px auto;
            width: 95%;
            max-width: 1100px;
        }

        /* Título Laranja */
        .titulo-laranja {
            color: #e65c00;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        .dash-card {
            background: #fff;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            border: none;
        }

        /* Tabela Estilizada */
        .table-header-laranja {
            background-color: #e65c00 !important;
            color: white !important;
        }
        .titulo-verde {
            color: #0d8a4f;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        .table thead th {
            border: none;
            padding: 18px;
            font-weight: 600;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .btn-filtro {
            background-color: #e65c00;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-filtro:hover {
            background-color: #cc5200;
            transform: translateY(-1px);
            color: white;
        }

        .btn-salvar {
            background-color: #198754;
            color: white;
            border-radius: 50px;
            padding: 12px 50px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-salvar:hover {
            background-color: #146c43;
            transform: scale(1.05);
            color: white;
        }

        .form-control,
        .form-select {
            border-radius: 50px !important;
            padding: 10px 20px;
            border: 1px solid #ced4da;
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

    <?php
    $_SESSION['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : null;
    include('navbar_coletor.php');
    ?>

    <div class="conteudo-pagina">

       
        <div class="row align-items-center mb-3 header-row">
            <div class="col-auto">
                <a href="logout.php" class="btn btn-danger rounded-pill px-4 mb-0">
                    Sair
                </a>
            </div>
            <div class="col text-center">
                <h2 class="titulo-verde mb-0">Realizar Frequências</h2>
            </div>
        </div>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-warning alert-dismissible fade show fw-bold text-center" role="alert">
                <?= $_SESSION['mensagem']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['mensagem']);
        endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 text-center border-0 shadow-sm mb-4" role="alert">
                <strong>Sucesso!</strong> Frequência salva com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['success']) && (isset($_GET['nome']) || isset($_GET['turma']) || isset($_GET['data']))): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 text-center border-0 shadow-sm mb-4" role="alert">
                 Lista filtrada com sucesso.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="dash-card mb-4">
            <form method="get" action="lista_frequencia.php">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">Nome do Aluno</label>
                        <input type="text" name="nome" class="form-control" placeholder="Buscar..." value="<?php echo htmlspecialchars($filterNome); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">Turma</label>
                        <select name="turma" class="form-select">
                            <option value="">Todas</option>
                            <?php
                            $turmas = ['1A', '1B', '1C', '1D', '2A', '2B', '2C', '2D', '3A', '3B', '3C', '3D'];
                            foreach ($turmas as $t): ?>
                                <option value="<?= $t ?>" <?php if ($filterTurma == $t) echo 'selected'; ?>><?= $t ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">Data</label>
                        <input type="date" name="data" class="form-control" value="<?php echo htmlspecialchars($filterData); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-filtro w-100 py-2 shadow-sm">Filtrar Lista</button>
                    </div>
                </div>
            </form>
        </div>

        <form method="post" action="salvar_frequencia.php">
            <input type="hidden" name="data" value="<?php echo htmlspecialchars($filterData); ?>">

            <div class="dash-card p-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table mb-0 text-center">
                        <thead>
                            <tr class="table-header-laranja">
                                <th class="text-start ps-4">Nome do Aluno</th>
                                <th>Turma</th>
                                <th>Número</th>
                                <th>Matrícula</th>
                                <th class="pe-4">Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($alunosFiltrados)): ?>
                                <?php foreach ($alunosFiltrados as $aluno): ?>
                                    <tr>
                                        <td class="text-start ps-4 fw-bold text-secondary"><?php echo $aluno['nome_aluno']; ?></td>
                                        <td><span class="badge badge-turma"><?php echo $aluno['turma_aluno']; ?></span></td>
                                        <td><span class="badge badge-number"><?php echo $aluno['numero_aluno']; ?></span></td>
                                        <td class="text-muted small"><?php echo $aluno['matricula']; ?></td>
                                        <td class="pe-4">
                                            <select name="situacao[<?php echo $aluno['matricula']; ?>]" class="form-select mx-auto" style="max-width: 150px;">
                                                <option value="Presente" <?php if ($aluno['situacao'] == "Presente") echo "selected"; ?>>Presente</option>
                                                <option value="Ausente" <?php if ($aluno['situacao'] == "Ausente") echo "selected"; ?>>Ausente</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="py-4 text-muted">Nenhum aluno encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center mt-4 mb-5">
                <button type="submit" class="btn btn-salvar shadow">Salvar Frequência</button>
            </div>
        </form>

    </div>

    <?php include('footer.php'); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>