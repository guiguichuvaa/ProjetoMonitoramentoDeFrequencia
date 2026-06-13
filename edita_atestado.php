<?php
session_start();
include('conexao.php');

if (!isset($_POST['qtd_dias_cobertos'], $_POST['data_registro'], $_POST['responsavel_cadastro'],
          $_POST['matricula'], $_POST['id_registro'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos obrigatórios.";
    header('Location: tela_edita_atestado.php?matricula=' . urlencode($_POST['matricula'] ?? ''));
    exit();
}

$nome_aluno = mysqli_real_escape_string($conexao, $_POST['nome']);
$numero_aluno = mysqli_real_escape_string($conexao, $_POST['numero']);
$turma_aluno = mysqli_real_escape_string($conexao, $_POST['turma']);
$matricula = mysqli_real_escape_string($conexao, $_POST['matricula']);
$id_registro = (int)$_POST['id_registro'];
$responsavel_cadastro = mysqli_real_escape_string($conexao, $_POST['responsavel_cadastro']);
$data_registro = mysqli_real_escape_string($conexao, $_POST['data_registro']);
$qtd_dias_cobertos = mysqli_real_escape_string($conexao, $_POST['qtd_dias_cobertos']);
$tipo = 'Atestado';

$arquivoBlob = null;
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['mensagem'] = "Erro no upload do arquivo.";
        header('Location: tela_edita_atestado.php?matricula=' . urlencode($matricula));
        exit();
    }

    $arquivoBlob = file_get_contents($_FILES['arquivo']['tmp_name']);
    $arquivoBlob = mysqli_real_escape_string($conexao, $arquivoBlob);
}

$query = "UPDATE registro SET ";
$query .= "nome_aluno = '$nome_aluno', ";
$query .= "numero_aluno = '$numero_aluno', ";
$query .= "turma_aluno = '$turma_aluno', ";
$query .= "tipo_registro = '$tipo', ";
$query .= "nome_funcionario = '$responsavel_cadastro', ";
$query .= "data_registro = '$data_registro', ";
$query .= "dias_cobertos = '$qtd_dias_cobertos'";

if ($arquivoBlob !== null) {
    $query .= ", arquivo = '$arquivoBlob'";
}

$query .= " WHERE id_registro = $id_registro AND matricula = '$matricula' AND tipo_registro = '$tipo'";

if (!mysqli_query($conexao, $query)) {
    $_SESSION['mensagem'] = "Erro ao atualizar atestado: " . mysqli_error($conexao);
    header('Location: tela_edita_atestado.php?matricula=' . urlencode($matricula));
    exit();
}

$_SESSION['mensagem'] = "Atestado atualizado com sucesso!";
header('Location: painel_aluno.php?matricula=' . urlencode($matricula));
exit();