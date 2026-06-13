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

//verificar se os campos estão preenchidos com numeros ou letras
if($_POST['motivo'] == '' || !ctype_alnum($_POST['responsavel_cadastro'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos corretamente.";
    header('Location: tela_cadastro_atraso.php?matricula=' . $_POST['matricula']);
    exit();
}

$query = "UPDATE registro SET nome_aluno = '$nome_aluno', numero_aluno = '$numero_aluno', turma_aluno = '$turma_aluno', tipo_registro = '$tipo', nome_funcionario = '$nome_responsavel', data_registro = '$data_cadastro', motivo = '$motivo', nome_responsavel = '$nome_responsavel', tipo_responsavel = '', horario_registro = '$horario_atraso' WHERE matricula = '$matricula'";

if (!mysqli_query($conexao, $query)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao cadastrar atraso: " . mysqli_error($conexao);
    header('Location: tela_cadastro_atraso.php');
    exit();
}

// Se o aluno tiver falta cadastrada na mesma data, atualiza para presença.
// Se não houver registro de frequência para essa data, insere presença.
$updateFrequencia = "UPDATE frequencia 
            SET data_frequencia = '$data_cadastro', nome_aluno_frequencia = '$nome_aluno', matricula_aluno_frequencia = '$matricula', turma_aluno_frequencia = '$turma_aluno', situacao_frequencia = 'P' 
          WHERE data_frequencia = '$data_cadastro' AND matricula_aluno_frequencia = '$matricula'";

if (!mysqli_query($conexao, $updateFrequencia)) {
    mysqli_rollback($conexao);
    $_SESSION['mensagem'] = "Erro ao atualizar frequência: " . mysqli_error($conexao);
    header('Location: tela_cadastro_atraso.php');
    exit();
}

mysqli_commit($conexao);
$_SESSION['mensagem'] = "Atraso atualizado com sucesso!";
header('Location: painel_aluno.php?matricula=' . $matricula);
exit();
