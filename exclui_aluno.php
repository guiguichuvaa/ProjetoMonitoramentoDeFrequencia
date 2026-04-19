<?php
session_start();
include('conexao.php');

$matricula = $_GET['matricula'];

$query = "DELETE FROM aluno WHERE matricula = '$matricula'";

if (mysqli_query($conexao, $query)) {
    $_SESSION['mensagem'] = "Aluno excluído com sucesso.";
    header('Location: lista_alunos.php');
    exit();
} else {
    $_SESSION['mensagem'] = "Erro ao excluir aluno.";
    header('Location: lista_alunos.php');
    exit();
}
?>