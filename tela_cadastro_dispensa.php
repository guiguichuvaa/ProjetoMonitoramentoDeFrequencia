<?php session_start();
include('conexao.php');
// Verificar se a matrícula foi passada via GET
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Buscar o aluno no banco de dados
    $query = "SELECT nome_aluno, turma_aluno, matricula, numero_aluno FROM aluno WHERE matricula = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "s", $matricula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $aluno = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);
    } else {
        // Matrícula não fornecida, redirecionar ou mostrar erro
        echo "Matrícula não fornecida.";
        exit;
    }
} else {
    // Matrícula não fornecida, redirecionar ou mostrar erro
    echo "Matrícula não fornecida.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadastrar Registro - FrequenCy</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon_io/image.png" type="image/x-icon">

    <style>
        body {
            background-color: #fff9f5;
            font-family: 'Poppins', sans-serif;
            display: block;
            margin: 0;
        }

        /* Estilo do Card de Título (do primeiro código) */
        .conteudo-cadastro {
            margin: 4vh auto 20px;
            width: 95%;
            max-width: 600px;
        }

        .dash-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .header-card {
            background: linear-gradient(135deg, #fff9f5, #fff);
            border: none;
            margin-bottom: 30px;
        }

        .card-auth {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .card-header-orange {
            background: linear-gradient(135deg, #ff7a1a, #ffb347);
            padding: 25px;
            text-align: center;
            color: white;
        }

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

        .btn-signup {
            background-color: transparent;
            border: 2px solid #ff7a1a;
            color: #ff7a1a;
            transition: all 0.3s ease;
        }

        .btn-signup:hover {
            background-color: #ff7a1a;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(255, 122, 26, 0.3);
        }

        .form-check-input:checked {
            background-color: #ff7a1a;
            border-color: #ff7a1a;
        }

        /* Ajuste das ondas para não sobrepor o conteúdo */
        .wave-container {
            position: relative;
            width: 100%;
            bottom: 0;
            line-height: 0;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container main-content pt-4 pb-5">


        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-10">
                <div class="text-center mb-4">
                    <img src="image.png" alt="Logo" style="max-width: 160px;">
                </div>

                <div class="card card-auth shadow-lg">
                    <div class="card-header-orange">
                        <h2 class="fs-4 fw-bold mb-0">Cadastro de Dispensa</h2>
                    </div>
                    <div class="card-body p-4 p-md-5 bg-white w-100">

                        <?php if (isset($_SESSION['mensagem'])): ?>
                            <div class="alert alert-warning alert-dismissible fade show fw-bold text-center" role="alert">
                                <?= $_SESSION['mensagem']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php unset($_SESSION['mensagem']);
                        endif; ?>

                        <form action="cadastro_dispensa.php" method="POST">
                            <input type="hidden" name="nome" value="<?php echo $aluno['nome_aluno']; ?>">
                            <input type="hidden" name="numero" value="<?php echo $aluno['numero_aluno']; ?>">
                            <input type="hidden" name="turma" value="<?php echo $aluno['turma_aluno']; ?>">
                            <input type="hidden" name="matricula" value="<?php echo $aluno['matricula']; ?>">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-secondary">Nome Completo:</label> <br>
                                    <span><?php echo $aluno['nome_aluno'] ?></span>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold text-secondary">Motivo da Dispensa</label> <br>
                                    <textarea type="text" class="form-control" name="motivo" required></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-secondary">Número:</label> <br>
                                    <span><?php echo $aluno['numero_aluno'] ?></span>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold text-secondary">Tipo:</label> <br>
                                    <span class="" name="tipo" value="dispensa">Dispensa</span>
                                </div>

                            </div>

                            <div class="row d-flex ">
                                <div class="col-md-4 mb-3">

                                    <label class="form-label fw-bold text-secondary">Matrícula:</label> <br>
                                    <span><?php echo $aluno['matricula'] ?></span>
                                </div>

                                <div class=" col-md-3 mb-4">
                                    <label class="form-label fw-bold text-secondary">Responsável por Cadastro:</label> <br>
                                    <input type="text" class="form-control" name="responsavel_cadastro" value="<?php echo isset($aluno['responsavel_cadastro']) ? $aluno['responsavel_cadastro'] : ''; ?>" required>
                                </div>
                                <div class=" col-md-3 mb-4">
                                    <label class="form-label fw-bold text-secondary">Responsável por Autorizar:</label> <br>
                                    <input type="text" class="form-control" name="responsavel_autorizar" value="" required>
                                </div>
                                <div class=" col-md-2 mb-4">
                                    <label class="form-label fw-bold text-secondary">Tipo:</label> <br>
                                    <select class="form-select" name="tipo_resp" id="">
                                        <option value="Mãe">Mãe</option>
                                        <option value="Pai">Pai</option>
                                        <option value="Outro">Outro</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class=" col-md-4 mb-4">
                                    <label class="form-label fw-bold text-secondary">Turma:</label> <br>
                                    <span><?php echo $aluno['turma_aluno'] ?></span>
                                </div>

                                <div class=" col-md-5 mb-4">
                                    <label class="form-label fw-bold text-secondary text-align-center">Data de Cadastro:</label> <br>
                                    <input type="date" class="form-control" name="data_cadastro" value="" required>
                                </div>

                                <div class=" col-md-3 mb-4">
                                    <label class="form-label fw-bold text-secondary text-align-center">Horário:</label> <br>
                                    <input type="time" class="form-control" name="horario_dispensa" id="">
                                </div>
                            </div>


                            <div class="d-flex mt-4 justify-content-between">
                                <input type="hidden" name="matricula" value="<?php echo $aluno['matricula']; ?>">
                                <a href="painel_aluno.php?matricula=<?= $matricula ?>" class="btn btn-danger rounded-pill px-4 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </a>
                                <button type="submit" class="btn btn-signup btn-lg rounded-pill fw-bold text-uppercase">Cadastrar</button>
                            </div>
                        </form>
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

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>