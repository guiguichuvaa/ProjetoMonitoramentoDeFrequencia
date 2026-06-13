<?php
session_start();
include('conexao.php');
$idRegistro = isset($_GET['id_registro']) ? intval($_GET['id_registro']) : null;

if (!$idRegistro) {
    $_SESSION['mensagem'] = "Registro inválido.";
    header('Location: lista_registro.php');
    exit();
}

// Buscar registro antes de excluir
$querySelect = "SELECT nome_aluno, turma_aluno, matricula, tipo_registro, data_registro FROM registro WHERE id_registro = $idRegistro";
$result = mysqli_query($conexao, $querySelect);

if ($result && mysqli_num_rows($result) > 0) {
    $registro = mysqli_fetch_assoc($result);

    if ($registro['tipo_registro'] === 'Atraso') {
        $dataFrequencia = mysqli_real_escape_string($conexao, $registro['data_registro']);
        $nomeAluno = mysqli_real_escape_string($conexao, $registro['nome_aluno']);
        $matricula = mysqli_real_escape_string($conexao, $registro['matricula']);
        $turma = mysqli_real_escape_string($conexao, $registro['turma_aluno']);

        // Primeiro, tenta atualizar a frequência existente para Ausente
        $queryUpdate = "UPDATE frequencia 
                       SET situacao_frequencia = 'A' 
                       WHERE matricula_aluno_frequencia = '$matricula' 
                       AND data_frequencia = '$dataFrequencia'";
        
        mysqli_query($conexao, $queryUpdate);
        
        // Se não encontrou nenhum registro, cria uma nova frequência como Ausente
        $rowsAffected = mysqli_affected_rows($conexao);
        
        if ($rowsAffected == 0) {
            $queryInsert = "INSERT INTO frequencia
                (data_frequencia, nome_aluno_frequencia, matricula_aluno_frequencia, turma_aluno_frequencia, situacao_frequencia)
                VALUES
                ('$dataFrequencia', '$nomeAluno', '$matricula', '$turma', 'A')";

            if (!mysqli_query($conexao, $queryInsert)) {
                $_SESSION['mensagem'] = "Erro ao atualizar frequência: " . mysqli_error($conexao);
                header('Location: lista_registro.php');
                exit();
            }
        }
    }

    $queryDelete = "DELETE FROM registro WHERE id_registro = $idRegistro";
    if (mysqli_query($conexao, $queryDelete)) {
        $_SESSION['mensagem'] = "Registro excluído com sucesso.";
        header('Location: lista_registro.php');
        exit();
    }
}

$_SESSION['mensagem'] = "Erro ao excluir registro.";
header('Location: lista_registro.php');
exit();

?>