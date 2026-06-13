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

//verificar se o aluno existe
$matricula = isset($_GET['matricula']) ? $_GET['matricula'] : null;
if ($matricula) {
    $matricula_escaped = mysqli_real_escape_string($conexao, $matricula);
    $query_aluno = "SELECT * FROM aluno WHERE matricula = '$matricula_escaped'";
    $result_aluno = mysqli_query($conexao, $query_aluno);
    if ($result_aluno && mysqli_num_rows($result_aluno) > 0) {
        $aluno = mysqli_fetch_assoc($result_aluno);
    } else {
        die('Aluno não encontrado.');
    }
} else {
    die('Matrícula do aluno não fornecida.');
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Geral do Aluno - FrequenCy</title>
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

        .text-green {
            color: #0d8a4f;
        }

        .text-orange {
            color: #ff7a1a;
        }
    </style>
</head>



<body>

    <div class="container conteudo-painel py-4" id="report-content">
        <div class="row mb-4">
            <div class="col-12">
                <div class="dash-card relatorio-header p-4 text-white">
                    <h1 class="fw-bold">Relatório Geral do Aluno</h1>
                    <p class="mb-0">Dados do Aluno: <strong><?= $aluno['nome_aluno'] ?></strong></p>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="dash-card p-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                        <div>
                            <h5 class="fw-semibold mb-2">Resumo do dia</h5>
                            <p class="mb-0">Este relatório mostra os números do dia selecionado.</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="painel_aluno.php?matricula=<?= $matricula ?>" class="btn btn-outline-secondary">Voltar ao Painel do Aluno</a>
                            <a href="gerar_relatorio_aluno_pdf.php?&matricula=<?= $matricula ?>" class="btn btn-primary">Baixar PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class=" col-12 col-md-12 mb-4">
                <div class="dash-card card-bottom p-4">
                <!--div alinhada à esquerda-->
                <div class="d-flex flex-column align-items-start gap-2 border-end col-12 col-md-6">
                
                    <span class="text-muted fw-bold text-align-left">Dados do Aluno:</span>
                    <span class="d-block mt-3">Nome Completo: <strong><?= $aluno['nome_aluno'] ?></strong></span>
                    <span class="d-block mt-1">Número da Chamada: <strong><?= $aluno['numero_aluno'] ?></strong></span>
                    <span class="d-block mt-1">Turma: <strong><?= $aluno['turma_aluno'] ?></strong></span>
                    <span class="d-block mt-1">Matrícula: <strong><?= $matricula ?></strong></span>
                </div>

                <!--div alinhada à direita-->
                <div class="d-flex flex-column align-items-end gap-2 border-start col-12 col-md-6">
                    <span class="text-muted fw-bold text-align-left">Métricas do Aluno:</span>
                    <h5>
                        Situação Pé-de-Meia do mês: <strong><?= date('m/Y') ?></strong> <br>
                    <strong><?= porcentagem_frequencia($conexao, $matricula, date('m')) ?>%</strong>
                </h5>
                </div>

                
            </div>

        </div>
        </div>

        <div class="row g-4">

        <div class="col-12 col-md-6">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Total de Presenças: </span>
                    <!-- conta as presenças do aluno no ano -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_ano_por_aluno($conexao, $matricula, date('Y')) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Total de Faltas: </span>
                    <!-- conta as faltas do aluno no ano -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_ano_por_aluno($conexao, $matricula, date('Y')) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas Justificadas: </span>
                    <!-- conta as faltas justificadas do aluno no ano -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_dias_justificados_por_aluno($conexao, $matricula) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Janeiro: </span>
                    <!-- conta as presenças do aluno no mês de janeiro -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 1) ?></h2>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Janeiro: </span>
                    <!-- conta as faltas do aluno no mês de janeiro -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 1) ?></h2>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Fevereiro: </span>
                    <!-- conta as presenças do aluno no mês de fevereiro -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 2) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Fevereiro: </span>
                    <!-- conta as faltas do aluno no mês de fevereiro -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 2) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Março: </span>
                    <!-- conta as presenças do aluno no mês de março -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 3) ?></h2>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Março: </span>
                    <!-- conta as faltas do aluno no mês de março -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 3) ?></h2>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Abril: </span>
                    <!-- conta as presenças do aluno no mês de abril -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 4) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Abril: </span>
                    <!-- conta as faltas do aluno no mês de abril -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 4) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Maio: </span>
                    <!-- conta as presenças do aluno no mês de maio -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 5) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Maio: </span>
                    <!-- conta as faltas do aluno no mês de maio -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 5) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Junho: </span>
                    <!-- conta as presenças do aluno no mês de junho -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 6) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Junho: </span>
                    <!-- conta as faltas do aluno no mês de junho -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 6) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Julho: </span>
                    <!-- conta as presenças do aluno no mês de julho -->
                    <h2 class="fw-bold mt-3">Férias</h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Julho: </span>
                    <!-- conta as faltas do aluno no mês de julho -->
                    <h2 class="fw-bold mt-3">Férias</h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Agosto: </span>
                    <!-- conta as presenças do aluno no mês de agosto -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 8) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Agosto: </span>
                    <!-- conta as faltas do aluno no mês de agosto -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 8) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Setembro: </span>
                    <!-- conta as presenças do aluno no mês de setembro -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 9) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Setembro: </span>
                    <!-- conta as faltas do aluno no mês de setembro -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 9) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Outubro: </span>
                    <!-- conta as presenças do aluno no mês de outubro -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 10) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Outubro: </span>
                    <!-- conta as faltas do aluno no mês de outubro -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 10) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Novembro: </span>
                    <!-- conta as presenças do aluno no mês de novembro -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 11) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Novembro: </span>
                    <!-- conta as faltas do aluno no mês de novembro -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 11) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Presenças no mês de Dezembro: </span>
                    <!-- conta as presenças do aluno no mês de dezembro -->
                    <h2 class="fw-bold text-green mt-3"><?= contar_frequencia_no_mes_por_aluno($conexao, $matricula, 12) ?></h2>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="dash-card card-bottom p-4 text-center">
                    <span class="text-muted fw-bold">Faltas no mês de Dezembro: </span>
                    <!-- conta as faltas do aluno no mês de dezembro -->
                    <h2 class="fw-bold text-orange mt-3"><?= contar_faltas_no_mes_por_aluno($conexao, $matricula, 12) ?></h2>
                </div>
            </div>
        </div>
    </div>



    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>