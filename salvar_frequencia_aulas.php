<?php
session_start();
include('conexao.php');

// Recebe os dados do fetch (JSON)
$input = json_decode(file_get_contents('php://input'), true);

$matricula = $input['matricula'] ?? '';
$data = $input['data'] ?? '';
$frequencias = $input['frequencias'] ?? [];

if (!$matricula || !$data || empty($frequencias)) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
    exit;
}

$success = true;

// Inicia uma transação para garantir consistência
mysqli_begin_transaction($conexao);

$query = "INSERT INTO frequencia_detalhada (matricula_aluno, data_aula, aula_numero, status)
          VALUES (?, ?, ?, ?)
          ON DUPLICATE KEY UPDATE status = VALUES(status), updated_at = NOW()";

// Prepara o Statement apenas UMA VEZ
if ($stmt = mysqli_prepare($conexao, $query)) {
    
    foreach ($frequencias as $aula_num => $info) {
        $status = $info['status'];
        $aula_num_int = (int)$aula_num;
        
        mysqli_stmt_bind_param($stmt, "ssis", $matricula, $data, $aula_num_int, $status);
        
        if (!mysqli_stmt_execute($stmt)) {
            $success = false;
            break; 
        }
    }
    mysqli_stmt_close($stmt);
} else {
    $success = false;
}

if ($success) {
    mysqli_commit($conexao);
    echo json_encode(['success' => true, 'message' => 'Frequência gravada com sucesso!']);
} else {
    mysqli_rollback($conexao);
    echo json_encode(['success' => false, 'message' => 'Erro ao gravar as frequências.']);
}
?>