<?php
session_start();
include('conexao.php');

if (!isset($_POST['matricula'], $_POST['qtd_dias_cobertos'], $_POST['data_registro'], $_POST['responsavel_cadastro']) || !isset($_FILES['arquivo'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos.";
    header('Location: tela_cadastro_atestado.php?matricula=' . urlencode($_POST['matricula'] ?? ''));
    exit();
}

if ($_FILES['arquivo']['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES['arquivo']['tmp_name'])) {
    $_SESSION['mensagem'] = "Erro no envio do arquivo. Verifique se o anexo foi selecionado.";
    header('Location: tela_cadastro_atestado.php?matricula=' . urlencode($_POST['matricula']));
    exit();
}

$nome_aluno = mysqli_real_escape_string($conexao, $_POST['nome']);
$numero_aluno = mysqli_real_escape_string($conexao, $_POST['numero']);
$turma_aluno = mysqli_real_escape_string($conexao, $_POST['turma']);
$matricula = mysqli_real_escape_string($conexao, $_POST['matricula']);
$qtd_dias_cobertos = mysqli_real_escape_string($conexao, $_POST['qtd_dias_cobertos']);
$data_registro = mysqli_real_escape_string($conexao, $_POST['data_registro']);
$responsavel_cadastro = mysqli_real_escape_string($conexao, $_POST['responsavel_cadastro']);
$tipo = 'Atestado';

$arquivoConteudo = file_get_contents($_FILES['arquivo']['tmp_name']);
if ($arquivoConteudo === false) {
    $_SESSION['mensagem'] = "Erro ao ler o arquivo enviado.";
    header('Location: tela_cadastro_atestado.php?matricula=' . urlencode($_POST['matricula']));
    exit();
}
$arquivo = mysqli_real_escape_string($conexao, $arquivoConteudo);

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚçÇ\s]+$/", $responsavel_cadastro)) {
    $_SESSION['mensagem'] = "O campo 'Responsável por Cadastro' deve conter apenas letras, acentos e espaços.";
    header('Location: tela_cadastro_atestado.php?matricula=' . urlencode($_POST['matricula']));
    exit();
}

$query = "INSERT INTO registro (nome_aluno, numero_aluno, turma_aluno, matricula, tipo_registro, arquivo, nome_funcionario, data_registro, dias_cobertos)
          VALUES ('$nome_aluno', '$numero_aluno', '$turma_aluno', '$matricula', '$tipo', '$arquivo', '$responsavel_cadastro', '$data_registro', '$qtd_dias_cobertos')";
$result = mysqli_query($conexao, $query);
if (!$result) {
    $_SESSION['mensagem'] = "Erro ao cadastrar atestado: " . mysqli_error($conexao);
    header('Location: tela_cadastro_atestado.php?matricula=' . urlencode($_POST['matricula']));
    exit();
}

$_SESSION['mensagem'] = "Atestado cadastrado com sucesso!";
header('Location: painel_aluno.php?matricula=' . urlencode($_POST['matricula']));
exit();
