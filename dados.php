<?php

function contar_total_frequencias($conexao, $data) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE data_frequencia = '$data' and situacao_frequencia = 'P'";
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

function contar_frequencia_no_mes_por_aluno($conexao, $matricula, $mes) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE matricula_aluno_frequencia = '$matricula' AND MONTH(data_frequencia) = '$mes' AND situacao_frequencia = 'P'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

function contar_faltas_no_mes_por_aluno($conexao, $matricula, $mes) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE matricula_aluno_frequencia = '$matricula' AND MONTH(data_frequencia) = '$mes' AND situacao_frequencia = 'A'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

function contar_frequencia_no_ano_por_aluno($conexao, $matricula, $ano) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE matricula_aluno_frequencia = '$matricula' AND YEAR(data_frequencia) = '$ano' AND situacao_frequencia = 'P'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

function contar_faltas_no_ano_por_aluno($conexao, $matricula, $ano) {
    $query = "SELECT COUNT(*) AS total FROM frequencia WHERE matricula_aluno_frequencia = '$matricula' AND YEAR(data_frequencia) = '$ano' AND situacao_frequencia = 'A'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

function porcentagem_frequencia($conexao, $matricula, $mes) {
    $total_frequencias = contar_frequencia_no_mes_por_aluno($conexao, $matricula, $mes);
    $total_faltas = contar_faltas_no_mes_por_aluno($conexao, $matricula, $mes);
    $total_dias = $total_frequencias + $total_faltas;
    
    if ($total_dias > 0) {
        return round(($total_frequencias / $total_dias) * 100); // Retorna a porcentagem com 2 casas decimais
    }
    return 0;
}

function media_faltas_por_turma($conexao, $dia) {
    $query = "SELECT turma_aluno_frequencia, COUNT(*) AS total_faltas FROM frequencia WHERE data_frequencia = '$dia' AND situacao_frequencia = 'A' GROUP BY turma_aluno_frequencia";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $total_faltas = 0;
        $total_turmas = 0;
        
        while($row = mysqli_fetch_assoc($result)){
            $total_faltas += $row['total_faltas'];
            $total_turmas++;
        }
        
        if ($total_turmas > 0) {
            return round($total_faltas / $total_turmas, 2); // Retorna a média de faltas por turma
        }
    }
    return 0;
}

function contar_dias_justificados_por_aluno($conexao, $matricula) {
    $query = "SELECT SUM(dias_cobertos) AS total FROM registro WHERE matricula = '$matricula' AND tipo_registro = 'Atestado'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0; // Retorna 0 se total for NULL
    }
    return 0;
}

function contar_dispensas_por_dia($conexao, $data) {
    $query = "SELECT COUNT(*) AS total FROM registro WHERE data_registro = '$data' AND tipo_registro = 'Dispensa'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

function contar_atrasos_por_dia($conexao, $data) {
    $query = "SELECT COUNT(*) AS total FROM registro WHERE data_registro = '$data' AND tipo_registro = 'Atraso'";
    $result = mysqli_query($conexao, $query);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}
