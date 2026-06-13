<?php
session_start();
include('conexao.php');

// Verificar se os parâmetros necessários foram passados
if (!isset($_GET['matricula']) || !isset($_GET['data'])) {
    echo "Parâmetros inválidos.";
    exit;
}

$matricula = $_GET['matricula'];
$data_selecionada = $_GET['data'];

// Buscar dados do aluno para o cabeçalho
$query_aluno = "SELECT nome_aluno, turma_aluno FROM aluno WHERE matricula = ?";
$stmt_aluno = mysqli_prepare($conexao, $query_aluno);
mysqli_stmt_bind_param($stmt_aluno, "s", $matricula);
mysqli_stmt_execute($stmt_aluno);
$res_aluno = mysqli_stmt_get_result($stmt_aluno);
$aluno = mysqli_fetch_assoc($res_aluno);

if (!$aluno) {
    echo "Aluno não encontrado.";
    exit;
}

// Buscar as 9 aulas do dia para este aluno
// Ajuste os nomes das colunas de acordo com o seu banco de dados se necessário
$query_aulas = "SELECT numero_aula, situacao_frequencia FROM frequencia WHERE matricula_aluno_frequencia = ? AND data_frequencia = ? ORDER BY numero_aula ASC";
$stmt_aulas = mysqli_prepare($conexao, $query_aulas);
mysqli_stmt_bind_param($stmt_aulas, "ss", $matricula, $data_selecionada);
mysqli_stmt_execute($stmt_aulas);
$res_aulas = mysqli_stmt_get_result($stmt_aulas);

$aulas_registradas = [];
$total_presencas = 0;
$total_faltas = 0;

while ($row = mysqli_fetch_assoc($res_aulas)) {
    $aulas_registradas[$row['numero_aula']] = $row['situacao_frequencia'];
    if ($row['situacao_frequencia'] == 'P') $total_presencas++;
    if ($row['situacao_frequencia'] == 'A') $total_faltas++;
}

// Define o status do dia baseado nas 9 aulas
$status_dia = "parcial"; 
if ($total_presencas == 9) {
    $status_dia = "total-presenca"; // Verde completo
} elseif ($total_faltas == 9) {
    $status_dia = "total-falta"; // Vermelho completo
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Frequência - FrequenCy</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #f0f9f4; font-family: 'Poppins', sans-serif; }
        .container-detalhes { max-width: 600px; margin: 5vh auto; }
        .card-detalhes { background: #fff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); padding: 25px; }
        .aula-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; border-bottom: 1px solid #eee; }
        .aula-item:last-child { border-bottom: none; }
        .badge-p { background-color: #12c95e; color: white; }
        .badge-a { background-color: #ff4757; color: white; }
        .status-geral { font-weight: 700; padding: 10px; border-radius: 8px; text-align: center; margin-bottom: 20px; }
        .bg-tudo-presente { background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .bg-tudo-falta { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
        .bg-parcial { background-color: #fff3cd; color: #664d03; border: 1px solid #ffecb5; }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="container container-detalhes">
        <div class="mb-3">
            <a href="painel_aluno.php?matricula=<?= urlencode($matricula) ?>" class="btn btn-secondary btn-sm rounded-pill px-3">
                ← Voltar ao Painel
            </a>
        </div>

        <div class="card-detalhes">
            <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($aluno['nome_aluno']) ?></h4>
            <p class="text-muted mb-3">Turma: <?= htmlspecialchars($aluno['turma_aluno']) ?> | Data: <?= date('d/m/Y', strtotime($data_selecionada)) ?></p>

            <?php if ($status_dia == "total-presenca"): ?>
                <div class="status-geral bg-tudo-presente">Presença Confirmada em Todas as 9 Aulas!</div>
            <?php elseif ($status_dia == "total-falta"): ?>
                <div class="status-geral bg-tudo-falta">Falta Registrada em Todas as 9 Aulas.</div>
            <?php else: ?>
                <div class="status-geral bg-parcial">Frequência Mista: <?= $total_presencas ?> Presenças e <?= $total_faltas ?> Faltas.</div>
            <?php endif; ?>

            <h5 class="fw-bold mb-3 text-secondary">Listagem por Aula</h5>
            <div class="border rounded-3 overflow-hidden">
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <div class="aula-item">
                        <span class="fw-semibold text-dark"><?= $i ?>ª Aula</span>
                        <?php 
                        if (isset($aulas_registradas[$i])) {
                            if ($aulas_registradas[$i] == 'P') {
                                echo '<span class="badge badge-p px-3 py-2 rounded-pill">Presente</span>';
                            } else {
                                echo '<span class="badge badge-a px-3 py-2 rounded-pill">Ausente</span>';
                            }
                        } else {
                            echo '<span class="badge bg-secondary px-3 py-2 rounded-pill">Sem Registro</span>';
                        }
                        ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>