<?php 
session_start();
include('conexao.php');
if (empty($_POST['nome']) || empty($_POST['matricula']) || empty($_POST['turma'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos.";
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

// verificar se já existe matricula
$sql = "SELECT count(*) as total FROM aluno WHERE matricula = '$matricula'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    $_SESSION['mensagem'] = "Aluno já cadastrado!";
    header('Location: tela_cadastro_aluno.php');
    exit();
}else {
$query = "INSERT INTO aluno (nome_aluno, matricula, turma_aluno) VALUES ('$nome', '$matricula', '$turma')";

if (mysqli_query($conexao, $query)) {
    $_SESSION['mensagem'] = "Aluno cadastrado com sucesso!";
    header('Location: lista_alunos.php');
    exit();
} else {
    $_SESSION['mensagem'] = "Erro ao cadastrar aluno.";
    header('Location: tela_cadastro_aluno.php');
    exit();
}
}
?>