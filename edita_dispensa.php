<?php
session_start();
include('conexao.php');

if (!isset($_POST['motivo'], $_POST['data_cadastro'], $_POST['responsavel_cadastro'],
          $_POST['horario_atraso'], $_POST['matricula'], $_POST['id_registro'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos.";
    header('Location: tela_edita_dispensa.php?matricula=' . urlencode($_POST['matricula'] ?? ''));
    exit();
}

$nome_aluno          = mysqli_real_escape_string($conexao, $_POST['nome']);
$numero_aluno        = mysqli_real_escape_string($conexao, $_POST['numero']);
$turma_aluno         = mysqli_real_escape_string($conexao, $_POST['turma']);
$matricula           = mysqli_real_escape_string($conexao, $_POST['matricula']);
$id_registro         = (int)$_POST['id_registro'];
$horario_dispensa    = mysqli_real_escape_string($conexao, $_POST['horario_atraso']); // campo reutilizado
$nome_responsavel    = mysqli_real_escape_string($conexao, $_POST['responsavel_cadastro']);
$responsavel_autor   = mysqli_real_escape_string($conexao, $_POST['responsavel_autorizar'] ?? '');
$tipo_responsavel    = mysqli_real_escape_string($conexao, $_POST['tipo_resp'] ?? '');
$data_cadastro       = mysqli_real_escape_string($conexao, $_POST['data_cadastro']);
$motivo              = mysqli_real_escape_string($conexao, $_POST['motivo']);
$tipo                = 'Dispensa';

// Validação: motivo e responsável só podem conter letras, acentos e espaços
if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $_POST['motivo'])) {
    $_SESSION['mensagem'] = "O campo motivo deve conter apenas letras, acentos e espaços.";
    header('Location: tela_edita_dispensa.php?matricula=' . urlencode($matricula));
    exit();
}

mysqli_begin_transaction($conexao);

// Atualiza o registro identificado pelo id_registro
$query = "UPDATE registro SET
            nome_aluno       = '$nome_aluno',
            numero_aluno     = '$numero_aluno',
            turma_aluno      = '$turma_aluno',
            tipo_registro    = '$tipo',
            nome_funcionario = '$nome_responsavel',
            data_registro    = '$data_cadastro',
            motivo           = '$motivo',
            nome_responsavel = '$responsavel_autor',
            tipo_responsavel = '$tipo_responsavel',
            horario_registro = '$horario_dispensa'
          WHERE id_registro = $id_registro AND matricula = '$matricula'";

if (!mysqli_query($conexao, $query)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao atualizar dispensa: " . mysqli_error($conexao);
    header('Location: tela_edita_dispensa.php?matricula=' . urlencode($matricula));
    exit();
}

// Dispensa = saída antecipada → frequência do dia fica como AUSENTE ('A')
$updateFrequencia = "INSERT INTO frequencia
        (data_frequencia, nome_aluno_frequencia, matricula_aluno_frequencia, turma_aluno_frequencia, situacao_frequencia)
      VALUES ('$data_cadastro', '$nome_aluno', '$matricula', '$turma_aluno', 'A')
      ON DUPLICATE KEY UPDATE situacao_frequencia = 'A'";

if (!mysqli_query($conexao, $updateFrequencia)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao atualizar frequência: " . mysqli_error($conexao);
    header('Location: tela_edita_dispensa.php?matricula=' . urlencode($matricula));
    exit();
}

mysqli_commit($conexao);
$_SESSION['mensagem'] = "Dispensa atualizada com sucesso!";
header('Location: painel_aluno.php?matricula=' . urlencode($matricula));
exit();