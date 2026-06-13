<?php
session_start();
include('conexao.php');
if (!isset($_POST['motivo']) || !isset($_POST['data_cadastro']) || !isset($_POST['responsavel_cadastro']) || !isset($_POST['horario_atraso'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos.";
    header('Location: tela_cadastro_atestado.php?matricula=' . $_POST['matricula']);
    exit();
}

$nome_aluno = mysqli_real_escape_string($conexao, $_POST['nome']);
$numero_aluno = mysqli_real_escape_string($conexao, $_POST['numero']);
$turma_aluno = mysqli_real_escape_string($conexao, $_POST['turma']);
$matricula = mysqli_real_escape_string($conexao, $_POST['matricula']);
$horario_atraso = mysqli_real_escape_string($conexao, $_POST['horario_atraso']);
$nome_responsavel = mysqli_real_escape_string($conexao, $_POST['responsavel_cadastro']);
$data_cadastro = mysqli_real_escape_string($conexao, $_POST['data_cadastro']);
$motivo = mysqli_real_escape_string($conexao, $_POST['motivo']);
$tipo = 'Atraso';

//verificar se os campos estão motivo, nome_responsavel preenchidos com numeros ou letras e permite acentos e espaços
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚçÇ\s]+$/", $motivo)) {
    $_SESSION['mensagem'] = "O campo motivo deve conter apenas letras, acentos e espaços.";
    header('Location: tela_cadastro_atraso.php?matricula=' . $matricula);
    exit();
}

$query = "INSERT INTO registro (nome_aluno,	numero_aluno,	turma_aluno, 	matricula,	tipo_registro,	arquivo,	nome_funcionario, data_registro, dias_cobertos,	motivo,	nome_responsavel,	tipo_responsavel, horario_registro )
        VALUES ('$nome_aluno', '$numero_aluno', '$turma_aluno', '$matricula', '$tipo', '', '$nome_responsavel', '$data_cadastro', '', '$motivo', '', '', '$horario_atraso')";

if (!mysqli_query($conexao, $query)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao cadastrar atraso: " . mysqli_error($conexao);
    header('Location: tela_cadastro_atraso.php');
    exit();
}

// Se o aluno tiver falta cadastrada na mesma data, atualiza para presença.
// Se não houver registro de frequência para essa data, insere presença.
$updateFrequencia = "INSERT INTO frequencia 
            (data_frequencia, nome_aluno_frequencia, matricula_aluno_frequencia, turma_aluno_frequencia, situacao_frequencia) 
          VALUES 
            ('$data_cadastro', '$nome_aluno', '$matricula', '$turma_aluno', 'P') 
          ON DUPLICATE KEY UPDATE 
            situacao_frequencia = 'P'";

if (!mysqli_query($conexao, $updateFrequencia)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao atualizar frequência: " . mysqli_error($conexao);
    header('Location: tela_cadastro_atraso.php');
    exit();
}

mysqli_commit($conexao);
$_SESSION['mensagem'] = "Atraso cadastrado com sucesso!";
header('Location: painel_aluno.php?matricula=' . $matricula);
exit();
