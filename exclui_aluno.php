<?php
session_start();
include('conexao.php');

$matricula = isset($_GET['matricula']) ? $_GET['matricula'] : null;

if (empty($matricula)) {
    $_SESSION['mensagem'] = 'Matrícula inválida ou não informada.';
    header('Location: lista_alunos.php');
    exit();
}

$matriculaEscaped = mysqli_real_escape_string($conexao, $matricula);

// Buscar turma e número de chamada do aluno para ajustar a sequência
$query_busca = "SELECT turma_aluno, numero_aluno FROM aluno WHERE matricula = '$matriculaEscaped'";
$result_busca = mysqli_query($conexao, $query_busca);
if (!$result_busca || mysqli_num_rows($result_busca) === 0) {
    $_SESSION['mensagem'] = 'Aluno não encontrado para exclusão.';
    header('Location: lista_alunos.php');
    exit();
}

$aluno = mysqli_fetch_assoc($result_busca);
$turma = mysqli_real_escape_string($conexao, $aluno['turma_aluno']);
$numero = intval($aluno['numero_aluno']);

mysqli_begin_transaction($conexao);

$errorMessage = null;

// Atualiza números de chamada posteriores na turma
$query_shift = "UPDATE aluno SET numero_aluno = numero_aluno - 1 WHERE turma_aluno = '$turma' AND numero_aluno > $numero";
if (!mysqli_query($conexao, $query_shift)) {
    $errorMessage = 'Erro ao ajustar números de chamada: ' . mysqli_error($conexao);
}

// Deletar registros relacionados na tabela registro (atestados, dispensas, atrasos)
if (!$errorMessage) {
    $query_registro = "DELETE FROM registro WHERE matricula = '$matriculaEscaped'";
    if (!mysqli_query($conexao, $query_registro)) {
        $errorMessage = 'Erro ao excluir registros: ' . mysqli_error($conexao);
    }
}

// Deletar frequências na tabela frequencia
if (!$errorMessage) {
    $query_frequencia = "DELETE FROM frequencia WHERE matricula_aluno_frequencia = '$matriculaEscaped'";
    if (!mysqli_query($conexao, $query_frequencia)) {
        $errorMessage = 'Erro ao excluir frequências: ' . mysqli_error($conexao);
    }
}

// Deletar o aluno na tabela aluno
if (!$errorMessage) {
    $query_aluno = "DELETE FROM aluno WHERE matricula = '$matriculaEscaped'";
    if (!mysqli_query($conexao, $query_aluno)) {
        $errorMessage = 'Erro ao excluir aluno: ' . mysqli_error($conexao);
    }
}

if ($errorMessage) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = $errorMessage;
    header('Location: lista_alunos.php');
    exit();
}

mysqli_commit($conexao);

$_SESSION['mensagem'] = 'Aluno e todos os registros relacionados excluídos com sucesso.';
header('Location: lista_alunos.php');
exit();
