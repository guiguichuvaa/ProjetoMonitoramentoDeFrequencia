<?php
session_start();
include('conexao.php');

if (!isset($_POST['nome']) || !isset($_POST['matricula']) || !isset($_POST['turma'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos.";
    header('Location: lista_alunos.php');
    exit();
}

$nomeEditado = mysqli_real_escape_string($conexao, $_POST['nome']);
$matriculaEditado = mysqli_real_escape_string($conexao, $_POST['matricula']);
$turmaEditada = mysqli_real_escape_string($conexao, $_POST['turma']);

$query = "UPDATE aluno SET nome_aluno = '$nomeEditado', matricula = '$matriculaEditado', turma_aluno = '$turmaEditada' WHERE matricula = '$matriculaEditado'";

if (mysqli_query($conexao, $query)) {
    $_SESSION['mensagem'] = "Aluno editado com sucesso.";
    header('Location: lista_alunos.php');
    exit();
} else {
    $_SESSION['mensagem'] = "Erro ao editar aluno.";
    header('Location: tela_edita_aluno.php?matricula=' . $matriculaEditado);
    exit();
}
