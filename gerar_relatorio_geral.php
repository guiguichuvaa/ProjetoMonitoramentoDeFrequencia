<?php
session_start();
include('conexao.php');
include('verifica_login.php');
include('dados.php');

$data = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');
$validDate = DateTime::createFromFormat('Y-m-d', $data);
if (!$validDate) {
    $data = date('Y-m-d');
    $validDate = new DateTime($data);
}

$data_formatada = $validDate->format('d/m/Y');
$total_presentes = contar_total_frequencias($conexao, $data);
$total_faltas = contar_total_faltas($conexao, $data);
$total_atrasos = contar_atrasos_por_dia($conexao, $data);
$total_dispensas = contar_dispensas_por_dia($conexao, $data);

$alunos_faltosos = array();
$data_escaped = mysqli_real_escape_string($conexao, $data);
$query_faltosos = "SELECT a.nome_aluno, a.turma_aluno, a.numero_aluno, a.matricula
                    FROM aluno a
                    INNER JOIN frequencia f ON a.matricula = f.matricula_aluno_frequencia
                    WHERE f.data_frequencia = '$data_escaped' AND f.situacao_frequencia = 'A'
                    ORDER BY a.turma_aluno, a.nome_aluno";
$result_faltosos = mysqli_query($conexao, $query_faltosos);
if ($result_faltosos) {
    while ($row = mysqli_fetch_assoc($result_faltosos)) {
        $alunos_faltosos[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Geral - FrequenCy</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" width="22" height="22">
    <style>
        body {
            background-color: #f0f9f4;
            font-family: 'Poppins', sans-serif;
        }

        .dash-card {
            background-color: #ffffff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .dash-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(13, 138, 79, 0.12);
        }

        .relatorio-header {
            min-height: 115px;
            background: linear-gradient(135deg, #0d8a4f, #12c95e);
            border-radius: 20px;
            color: white;
        }

        .relatorio-header h1 {
            font-size: 2.1rem;
        }
    </style>
</head>

<body>

    <div class="container conteudo-painel py-4" id="report-content">
        <div class="row mb-4">
            <div class="col-12">
                <div class="dash-card relatorio-header p-4 text-white">
                    <h1 class="fw-bold">Relatório Geral</h1>
                    <p class="mb-0">Dados do dia <strong><?= $data_formatada ?></strong></p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presentes</span>
                    <h2 class="fw-bold text-green mt-3"><?= $total_presentes ?></h2>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas</span>
                    <h2 class="fw-bold text-orange mt-3"><?= $total_faltas ?></h2>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Atrasos</span>
                    <h2 class="fw-bold text-green mt-3"><?= $total_atrasos ?></h2>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Dispensas</span>
                    <h2 class="fw-bold text-green mt-3"><?= $total_dispensas ?></h2>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="dash-card p-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                        <div>
                            <h5 class="fw-semibold mb-2">Resumo do dia</h5>
                            <p class="mb-0">Este relatório mostra os números do dia selecionado.</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="painel.php" class="btn btn-outline-secondary">Voltar ao Painel</a>
                            <a href="gerar_relatorio_geral.php?data=<?= $data ?>" class="btn btn-success">Atualizar</a>
                            <a href="gerar_relatorio_geral_pdf.php?data=<?= $data ?>" class="btn btn-primary">Baixar PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="dash-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-semibold mb-1">Alunos Faltosos do dia</h5>
                            <span class="text-muted">Data: <?= $data_formatada ?></span>
                        </div>
                        <span class="badge bg-danger rounded-pill px-3 py-2">Total: <?= count($alunos_faltosos) ?></span>
                    </div>

                    <?php if (!empty($alunos_faltosos)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-start">Nome</th>
                                        <th>Turma</th>
                                        <th>Número</th>
                                        <th>Matrícula</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alunos_faltosos as $aluno): ?>
                                        <tr>
                                            <td class="text-start fw-semibold"><?php echo $aluno['nome_aluno']; ?></td>
                                            <td><?php echo $aluno['turma_aluno']; ?></td>
                                            <td><?php echo $aluno['numero_aluno']; ?></td>
                                            <td><?php echo $aluno['matricula']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="mb-0 text-muted">Nenhum aluno faltoso encontrado para esta data.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>