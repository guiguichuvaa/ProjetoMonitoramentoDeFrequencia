<?php
session_start();
include('conexao.php');

// Verificar se a matrícula foi passada via GET
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Buscar o aluno no banco de dados
    $query = "SELECT nome_aluno, turma_aluno, matricula FROM aluno WHERE matricula = ?";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno - FrequenCy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
</head>
<body>
    <?php  include('navbar.php');  ?>

    <div class="container mt-4">

    <h5 class="mb-3">Visualizar Aluno:</h5>

    <div class="row g-3">

        <!-- Avatar -->
        <div class="col-md-3">
            <div class="border border-warning rounded p-4 text-center bg-white">
                <div class="bg-success rounded-circle mx-auto" style="width:100px; height:100px;"></div>
            </div>
        </div>

        <!-- Dados do aluno -->
        <div class="col-md-9">
            <div class="border border-warning rounded p-3 bg-white">
                <h4><?php echo $aluno['nome_aluno']; ?></h4>
                <p class="mb-1"><strong>Turma:</strong> <?php echo $aluno['turma_aluno']; ?></p>
                <p class="mb-1"><strong>Matrícula:</strong> <?php echo $aluno['matricula']; ?></p>
                <p class="mb-0"><strong>Presença no mês:</strong> Presença no mês</p>
            </div>
        </div>

        <!-- Cards inferiores -->
        <div class="col-md-4">
            <div class="border border-warning rounded p-4 text-center bg-white">
                <h5>Info</h5>
                <p class="fs-4 mb-0">Informações adicionais</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="border border-warning rounded p-4 text-center bg-white">
                <h5>Presença no ano</h5>
                <p class="fs-4 mb-0">Presença no ano</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="border border-warning rounded p-4 text-center bg-white">
                <h5>Justificativas:</h5>
                <button class="btn btn-outline-warning">Atestados</button>
                <button class="btn btn-outline-warning">Saídas</button>
            </div>
        </div>

    </div>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>