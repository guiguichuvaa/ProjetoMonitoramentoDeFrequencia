<?php

function contar_total_frequencias($conexao, $data) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE data_frequencia = '$data'";
    $result = mysqli_query($conexao, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0; // Retorna 0 se ocorrer um erro ou se não houver frequências
}

function contar_total_faltas($conexao, $data) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE data_frequencia = '$data' AND situacao_frequencia = 'A'";
    $result = mysqli_query($conexao, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0; // Retorna 0 se ocorrer um erro ou se não houver faltas
}

function contar_frequencia_por_turma($conexao, $data, $turma) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE data_frequencia = '$data' AND situacao_frequencia = 'P' AND turma_aluno_frequencia LIKE '%$turma%'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

function contar_faltas_por_turma($conexao, $data, $turma) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE data_frequencia = '$data' AND situacao_frequencia = 'A' AND turma_aluno_frequencia LIKE '%$turma%'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}
