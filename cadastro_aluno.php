<?php 
session_start();
include('conexao.php');
if (empty($_POST['nome']) || empty($_POST['matricula']) || empty($_POST['turma']) || empty($_POST['numero'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos.";
    header('Location: tela_cadastro_aluno.php');
    exit();
}

if ($_POST['turma'] === 'null') {
    $_SESSION['mensagem'] = "Selecione uma turma válida.";
    header('Location: tela_cadastro_aluno.php');
    exit();
}

if(strlen($_POST['matricula']) < 7) {
    $_SESSION['mensagem'] = "A matrícula deve ter pelo menos 7 caracteres.";
    header('Location: tela_cadastro_aluno.php');
    exit();
}

if (!preg_match('/^[\p{L}\s]+$/u', $_POST['nome'])) {
    $_SESSION['mensagem'] = "O nome deve conter apenas letras e espaços.";
    header('Location: tela_cadastro_aluno.php');
    exit();
}
if (!preg_match('/^[0-9]+$/', $_POST['matricula'])) {
    $_SESSION['mensagem'] = "A matrícula deve conter apenas números, sem espaços.";
    header('Location: tela_cadastro_aluno.php');
    exit();
}

$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
$matricula = mysqli_real_escape_string($conexao, $_POST['matricula']);
$turma = mysqli_real_escape_string($conexao, $_POST['turma']);
$numero = intval($_POST['numero']);

if ($numero < 1) {
    $_SESSION['mensagem'] = "O número de chamada deve ser maior que zero.";
    header('Location: tela_cadastro_aluno.php');
    exit();
}

// verificar se já existe matricula
$sql = "SELECT count(*) as total FROM aluno WHERE matricula = '$matricula'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    $_SESSION['mensagem'] = "Aluno já cadastrado!";
    header('Location: tela_cadastro_aluno.php');
    exit();
}

mysqli_begin_transaction($conexao);

// Ajustar números de chamada existentes na turma para abrir espaço
$query_shift = "UPDATE aluno SET numero_aluno = numero_aluno + 1 WHERE turma_aluno = '$turma' AND numero_aluno >= $numero";
if (!mysqli_query($conexao, $query_shift)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = 'Erro ao ajustar números de chamada: ' . mysqli_error($conexao);
    header('Location: tela_cadastro_aluno.php');
    exit();
}

$query = "INSERT INTO aluno (nome_aluno, matricula, turma_aluno, numero_aluno) VALUES ('$nome', '$matricula', '$turma', $numero)";
if (!mysqli_query($conexao, $query)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao cadastrar aluno: " . mysqli_error($conexao);
    header('Location: tela_cadastro_aluno.php');
    exit();
}

mysqli_commit($conexao);
$_SESSION['mensagem'] = "Aluno cadastrado com sucesso!";
header('Location: lista_alunos.php');
exit();
?>
