<?php
session_start();
include('conexao.php');
if (!isset($_POST['motivo']) || !isset($_POST['data_cadastro']) || !isset($_POST['responsavel_cadastro']) || !isset($_POST['horario_dispensa'])  || !isset($_POST['responsavel_autorizar']) || !isset($_POST['tipo_resp'])){
    $_SESSION['mensagem'] = "Preencha todos os campos.";
    header('Location: tela_cadastro_dispensa.php?matricula=' . $_POST['matricula']);
    exit();
}

$nome_aluno = mysqli_real_escape_string($conexao, $_POST['nome']);
$numero_aluno = mysqli_real_escape_string($conexao, $_POST['numero']);
$turma_aluno = mysqli_real_escape_string($conexao, $_POST['turma']);
$matricula = mysqli_real_escape_string($conexao, $_POST['matricula']);
$horario_dispensa = mysqli_real_escape_string($conexao, $_POST['horario_dispensa']);
$nome_responsavel = mysqli_real_escape_string($conexao, $_POST['responsavel_cadastro']);
$responsavel_autorizar = mysqli_real_escape_string($conexao, $_POST['responsavel_autorizar']);
$tipo_responsavel = mysqli_real_escape_string($conexao, $_POST['tipo_resp']);
$data_cadastro = mysqli_real_escape_string($conexao, $_POST['data_cadastro']);
$motivo = mysqli_real_escape_string($conexao, $_POST['motivo']);
$tipo = 'Dispensa';

//verifica se os campos motivo, nome_responsavel e responsavel_autorizar estão preenchidos com letras e permita acentos e espaços
if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $motivo)) {
    $_SESSION['mensagem'] = "O campo motivo deve conter apenas letras, acentos e espaços.";
    header('Location: tela_cadastro_dispensa.php?matricula=' . $_POST['matricula']);
    exit();
}

$query = "INSERT INTO registro (nome_aluno,	numero_aluno,	turma_aluno, 	matricula,	tipo_registro,	arquivo,	nome_funcionario, data_registro, dias_cobertos,	motivo,	nome_responsavel,	tipo_responsavel, horario_registro )
        VALUES ('$nome_aluno', '$numero_aluno', '$turma_aluno', '$matricula', '$tipo', '', '$nome_responsavel', '$data_cadastro', '', '$motivo', '$responsavel_autorizar', '$tipo_responsavel', '$horario_dispensa')";

if (!mysqli_query($conexao, $query)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao cadastrar dispensa: " . mysqli_error($conexao);
    header('Location: tela_cadastro_dispensa.php');
    exit();
}



// Se o aluno tiver falta cadastrada na mesma data, atualiza para presença.
// Se houver registro de frequência para essa data, insere ausência.
$updateFrequencia = "INSERT INTO frequencia 
            (data_frequencia, nome_aluno_frequencia, matricula_aluno_frequencia, turma_aluno_frequencia, situacao_frequencia) 
          VALUES 
            ('$data_cadastro', '$nome_aluno', '$matricula', '$turma_aluno', 'A') 
          ON DUPLICATE KEY UPDATE 
            situacao_frequencia = 'A'";

if (!mysqli_query($conexao, $updateFrequencia)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao atualizar frequência: " . mysqli_error($conexao);
    header('Location: tela_cadastro_dispensa.php');
    exit();
}

mysqli_commit($conexao);
$_SESSION['mensagem'] = "Dispensa cadastrada com sucesso!";
header('Location: painel_aluno.php?matricula=' . $_POST['matricula']);
exit();
