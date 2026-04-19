<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['data'];
    $situacoes = $_POST['situacao'];

    foreach ($situacoes as $matricula => $situacao) {
        // Buscar nome e turma do aluno
        $query_busca = "SELECT nome_aluno, turma_aluno FROM aluno WHERE matricula = '$matricula'";
        $result = mysqli_query($conexao, $query_busca);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $nome = $row['nome_aluno'];
            $turma = $row['turma_aluno'];
            $query = "INSERT INTO frequencia (data_frequencia, nome_aluno_frequencia, matricula_aluno_frequencia, turma_aluno_frequencia, situacao_frequencia) VALUES ('$data', '$nome', '$matricula', '$turma', '$situacao') ON DUPLICATE KEY UPDATE situacao_frequencia = '$situacao'";
            mysqli_query($conexao, $query);
        }
    }

    // Redirecionar de volta com mensagem de sucesso
    header("Location: lista_frequencia.php?data=$data&success=1");
    exit();
}
