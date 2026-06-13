<?php
session_start();
include('conexao.php');

$matricula = $_GET['matricula'] ?? '';
$data = $_GET['data'] ?? '';
$tipo = $_GET['tipo'] ?? '';

if (!$matricula || !$data || !$tipo) {
    echo json_encode(['success' => false, 'message' => 'Parametros ausentes.']);
    exit;
}

// Para Atraso ou Dispensa, precisamos saber o HORÁRIO do acontecimento
if ($tipo == 'Atraso' || $tipo == 'Dispensa') {
    $query = "SELECT horario_registro FROM registro 
              WHERE matricula = ? AND data_registro = ? AND tipo_registro = ?
              ORDER BY id_registro DESC LIMIT 1";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "sss", $matricula, $data, $tipo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'exists' => true, 
            'horario' => $row['horario_registro']
        ]);
    } else {
        echo json_encode([
            'exists' => false, 
            'horario' => null
        ]);
    }
} else {
    // Para Atestado (Pode cobrir mais de um dia baseado na coluna dias_cobertos)
    $query = "SELECT * FROM registro 
              WHERE matricula = ? 
              AND ? BETWEEN data_registro AND DATE_ADD(data_registro, INTERVAL (dias_cobertos - 1) DAY)
              AND tipo_registro = ? 
              LIMIT 1";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "sss", $matricula, $data, $tipo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    echo json_encode([
        'exists' => mysqli_num_rows($result) > 0
    ]);
}
?>