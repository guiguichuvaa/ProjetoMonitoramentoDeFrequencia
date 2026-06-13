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

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon_io/image.png" type="image/x-icon" width="22" height="22">

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

            <select class="form-select ms-auto w-auto" onchange="if (this.value) window.location.href=this.value">
                <option value="" selected>O que deseja fazer?</option>
                <option value="lista_frequencia.php">
                    <a href="lista_frequencia.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>" class="btn btn-outline-success text-orange fw-bold ms-auto">Realizar Frequência</a>
                </option>
                <option value="lista_alunos.php">
                    <a href="lista_alunos.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>" class="btn btn-outline-success text-green fw-bold ms-auto">Abrir lista de Alunos</a>
                </option>
                <option value="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('d-m-Y'); ?>&filtro=faltas">
                    <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&filtro=faltas" class="btn btn-outline-success text-green fw-bold ms-auto">Ver lista de Faltas</a>
                </option>
            </select>
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
                <div class="row g-4 h-100">
                    <div class="col-12 col-sm-12">
                        <div class="dash-card card-sm p-3 text-center">
                            <span class="text-muted fw-bold">Faltas:</span>
                            <h2 class="fw-bold text-orange m-2"> <?php echo isset($_POST['data']) ? contar_total_faltas($conexao, $_POST['data']) : '0'; ?> </h2>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="dash-card card-sm p-3 text-center">
                            <span class="text-muted fw-bold">Atrasos:</span>
                            <h2 class="fw-bold text-green m-2"><?php echo isset($_POST['data']) ? contar_atrasos_por_dia($conexao, $_POST['data']) : '0'; ?></h2>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="dash-card card-sm p-3 text-center">
                            <span class="text-muted fw-bold">Dispensas:</span>
                            <h2 class="fw-bold text-green m-2"><?php echo isset($_POST['data']) ? contar_dispensas_por_dia($conexao, $_POST['data']) : '0'; ?></h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">

            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 1ºano A:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=1A" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '1A') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 1ºano B:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=1B" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '1B') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 2ºano A:</span>
                    <h2 class="fw-bold text-green m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=2A" class="text-green text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '2A') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 2ºano B:</span>
                    <h2 class="fw-bold text-green m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=2B" class="text-green text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '2B') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 3ºano A:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=3A" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '3A') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 3ºano B:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=3B" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '3B') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>



        </div>

        <div class="row g-4 mt-2">

            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-sm p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 1ºano C:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=1C" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '1C') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 1ºano D:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=1D" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '1D') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 2ºano C:</span>
                    <h2 class="fw-bold text-green m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=2C" class="text-green text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '2C') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 2ºano D:</span>
                    <h2 class="fw-bold text-green m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=2D" class="text-green text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '2D') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 3ºano C:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=3C" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '3C') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="col-6 col-md-3 col-xl-2">
                <div class="dash-card card-bottom p-3 text-center">
                    <span class="text-muted fw-bold">Faltas no 3ºano D:</span>
                    <h2 class="fw-bold text-orange m-2">
                        <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&turma=3D" class="text-orange text-decoration-none">
                            <?php echo isset($_POST['data']) ? contar_faltas_por_turma($conexao, $_POST['data'], '3D') : '0'; ?>
                        </a>
                    </h2>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-6">
                    <div class="dash-card card-bottom p-3 text-center">
                        <span class="text-muted fw-bold">Lista de Alunos com mais Faltas:</span>
                        <h2 class="fw-bold text-orange m-2">
                            <a href="lista_faltas.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>&filtro=faltas" class="text-orange text-decoration-none">
                                Ver Aqui
                            </a>
                        </h2>
                    </div>
                </div>
                <div class="col-6">
                    <div class="dash-card card-bottom p-3 text-center">
                        <span class="text-muted fw-bold">Média de Faltas por Turma:</span>
                        <h2 class="fw-bold text-orange m-2">
                            <?php echo isset($_POST['data']) ? media_faltas_por_turma($conexao, $_POST['data']) : '0'; ?>
                        </h2>
                    </div>
                </div>
            </div>

        </div>
        <div class="row g-4 mt-2 mb-3">
            <div class="col-12 col-md-12 col-sm-4">
                <div class="dash-card card-sm p-3 text-center">
                    <?php include('graficos_de_barras.php'); ?>
                </div>
            </div>
            <div class="col-12 col-md-12 col-sm-4 ">
                <div class="dash-card card-sm p-3 text-center">
                    <?php include('graficos_de_pizza.php'); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-12 col-xl-4 align-items-center">
        <a href="gerar_relatorio_geral.php?data=<?php echo isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>" class="text-decoration-none">
            <div class="dash-card card-bottom p-3 text-center shadow-sm" style="background: linear-gradient(135deg, #0d8a4f, #12c95e); cursor: pointer;">
                <span class="fw-bold text-white fs-5 text-uppercase ">Gerar Relatório Geral</span>
            </div>
        </a>
    </div>

    <?php include('footer.php'); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>