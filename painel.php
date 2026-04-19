<?php
session_start();
include('conexao.php');
include('verifica_login.php');
include('dados.php')
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - FrequenCy</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-color: #f0f9f4;
            font-family: 'Poppins', sans-serif;
            display: block;
            margin: 0;
        }

        /* Dashboard Cards com melhorias de toque para mobile */
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
            /* Garante que todos os cards da mesma linha tenham a mesma altura */
        }

        .dash-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(13, 138, 79, 0.15);
        }

        .text-green {
            color: #0d8a4f;
        }

        .text-orange {
            color: #ff7a1a;
        }

        .date-input {
            background-color: #ffffff;
            border: 1px solid #ced4da;
            padding: 10px 18px;
            border-radius: 50px;
            font-weight: 500;
            color: #495057;
            transition: all 0.3s;
        }

        /* Alturas adaptáveis */
        .card-main {
            min-height: 280px;
        }

        .card-sm {
            min-height: 130px;
        }

        .card-bottom {
            min-height: 100px;
        }

        /* Container Principal Otimizado */
        .conteudo-painel {
            margin-top: 3vh;
            width: 95%;
            max-width: 1600px;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 50px;
        }

        /* Ajustes para telas grandes (Desktop) */
        @media (min-width: 1200px) {
            .conteudo-painel {
                margin-top: 6vh;
            }

            .card-main {
                min-height: 320px;
            }
        }

        /* Ajustes para telas pequenas (Mobile) */
        @media (max-width: 576px) {
            .conteudo-painel {
                width: 100%;
                padding: 15px;
            }

            .display-3 {
                font-size: 2.5rem;
            }

            .fs-3 {
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>

<body>


    <?php
    $_SESSION['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : null;
    include('navbar.php');
    ?>

    <div class="conteudo-painel">

        <div class="d-flex flex-wrap align-items-center gap-3 mb-4 px-2">
            <h4 class="fw-bold m-0 text-secondary fs-4">Data de Controle:</h4>
            <form method="POST" class="d-flex gap-3 align-items-center">
                <input type="date" name="data" class="date-input shadow-sm" value="<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>" required>
                <button type="submit" class="btn btn-success fw-bold text-white">Gerar Dados</button>
            </form>
        </div>

        <div class="row g-4">

            <div class="col-12 col-lg-8">
                <div class="dash-card card-main p-4 p-md-5 text-center position-relative overflow-hidden">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 8px; background: linear-gradient(135deg, #ff7a1a, #ffb347);"></div>
                    <p class="fs-4 fw-semibold mb-2">Total de Alunos Presentes:</p>
                    <h1 class="display-2 fw-bold text-green m-0"> <?php echo isset($_POST['data']) ? contar_total_frequencias($conexao, $_POST['data']) : '0'; ?> </h1>
                    <p class="text-muted fw-medium mt-3 fs-5">
                        <?php echo isset($_POST['data']) ? 'em ' . date('d/m/Y', strtotime($_POST['data'])) : 'Selecione uma data'; ?>
                    </p>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="row g-3 h-100">
                    <div class="col-6 col-sm-6">
                        <div class="dash-card card-sm p-3 text-center">
                            <span class="text-muted fw-semibold">Faltas</span>
                            <h2 class="fw-bold text-orange m-0"> <?php echo isset($_POST['data']) ? contar_total_faltas($conexao, $_POST['data']) : '0'; ?> </h2>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="dash-card card-sm p-3 text-center">
                            <span class="text-muted fw-semibold">Atrasos</span>
                            <h2 class="fw-bold text-orange m-0">05</h2>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="dash-card card-sm p-3 text-center">
                            <span class="text-muted fw-semibold">Dispensas</span>
                            <h2 class="fw-bold text-green m-0">02</h2>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="dash-card card-sm p-3 text-center">
                            <span class="text-muted fw-semibold">Turmas</span>
                            <h2 class="fw-bold text-green m-0">12</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">

            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-semibold">Presença na Enfermagem:</span>
                    <h2 class="fw-bold text-green m-2"> <?php echo isset($_POST['data']) ? contar_frequencia_por_turma($conexao, $_POST['data'], 'A') : '0'; ?> </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-semibold">Presença na Informática:</span>
                    <h2 class="fw-bold text-green m-2"> <?php echo isset($_POST['data']) ? contar_frequencia_por_turma($conexao, $_POST['data'], 'B') : '0'; ?> </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-semibold">Presença no Desen. de Sistemas:</span>
                    <h2 class="fw-bold text-green m-2"> <?php echo isset($_POST['data']) ? contar_frequencia_por_turma($conexao, $_POST['data'], 'C') : '0'; ?> </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-semibold">Presença na Administração:</span>
                    <h2 class="fw-bold text-green m-2"> <?php echo isset($_POST['data']) ? contar_frequencia_por_turma($conexao, $_POST['data'], 'D') : '0'; ?> </h2>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="dash-card card-bottom p-3 text-center shadow-sm" style="background: linear-gradient(135deg, #0d8a4f, #12c95e); cursor: pointer;">
                    <span class="fw-bold text-white fs-5 text-uppercase">Gerar Relatório Geral</span>
                </div>
            </div>

        </div>

        <div class="row g-4 mt-2">

            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-sm p-3 text-center">
                    <span class="text-muted fw-semibold">Faltas na Enfermagem:</span>
                    <h2 class="fw-bold text-orange m-2"> <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], 'A') : '0'; ?> </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-semibold">Faltas na <br> Informática:</span>
                    <h2 class="fw-bold text-orange m-2"> <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], 'B') : '0'; ?> </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-semibold">Faltas no Desen. de Sistemas:</span>
                    <h2 class="fw-bold text-orange m-2"> <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], 'C') : '0'; ?> </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-semibold">Faltas na Administração:</span>
                    <h2 class="fw-bold text-orange m-2"> <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], 'D') : '0'; ?> </h2>
                </div>
            </div>


        </div>

    </div>

    <footer class="footer-painel mt-5">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 py-4 border-top">
            <div class="text-muted fw-medium text-center text-md-start">
                &copy; <?= date('Y'); ?> <span class="text-success fw-bold">Frequen</span><span class="text-warning fw-bold">Cy </span>.
            </div>

            <p class="fs-5 fw-semibold text-secondary mb-0 text-center">
                Nunca foi tão fácil organizar suas frequências com <span class="text-success fw-bold">Frequen</span><span class="text-warning fw-bold">Cy</span>
            </p>

            <div class="d-flex gap-4">
                <a href="#" class="text-decoration-none text-muted small">Suporte</a>
                <a href="#" class="text-decoration-none text-muted small">Termos</a>
                <a href="#" class="text-decoration-none text-muted small">Privacidade</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>