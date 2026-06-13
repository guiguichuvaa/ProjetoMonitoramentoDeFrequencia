<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json; charset=utf-8');
include('conexao.php');

$matricula = $_GET['matricula'] ?? '';
$data      = $_GET['data'] ?? '';

$response = [
    'success'         => false,
    'nome_aluno'      => 'Não Encontrado',
    'turma_aluno'     => '---',
    'situacao_diaria' => null,
    'is_atestado'     => false,
    'horario_atraso'  => null,
    'horario_dispensa'=> null,
    'frequencias'     => [],
    'registros'       => [],
    'horarios_aulas'  => [],
    'error_message'   => ''
];

if (!$matricula || !$data) {
    $response['error_message'] = 'Parâmetros ausentes na requisição.';
    echo json_encode($response);
    exit;
}

try {
    // 1. Dados do aluno
    $stmt = mysqli_prepare($conexao, "SELECT nome_aluno, turma_aluno FROM aluno WHERE matricula = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $matricula);
    mysqli_stmt_execute($stmt);
    if ($row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
        $response['nome_aluno']  = $row['nome_aluno'];
        $response['turma_aluno'] = $row['turma_aluno'];
    }
    mysqli_stmt_close($stmt);

    // 2. Situação diária (tabela frequencia)
    $stmt = mysqli_prepare($conexao,
        "SELECT CONVERT(situacao_frequencia, CHAR) AS situacao_frequencia
         FROM frequencia
         WHERE matricula_aluno_frequencia = ? AND data_frequencia = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $matricula, $data);
    mysqli_stmt_execute($stmt);
    if ($row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
        $response['situacao_diaria'] = trim($row['situacao_frequencia']);
    }
    mysqli_stmt_close($stmt);

    // 3. Atraso no dia
    $stmt = mysqli_prepare($conexao,
        "SELECT horario_registro FROM registro
         WHERE matricula = ? AND tipo_registro = 'Atraso' AND data_registro = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $matricula, $data);
    mysqli_stmt_execute($stmt);
    if ($row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
        $response['horario_atraso'] = $row['horario_registro'];
        $response['registros'][]    = 'Atraso';
    }
    mysqli_stmt_close($stmt);

    // 4. Dispensa no dia
    $stmt = mysqli_prepare($conexao,
        "SELECT horario_registro FROM registro
         WHERE matricula = ? AND tipo_registro = 'Dispensa' AND data_registro = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $matricula, $data);
    mysqli_stmt_execute($stmt);
    if ($row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
        $response['horario_dispensa'] = $row['horario_registro'];
        $response['registros'][]      = 'Dispensa';
    }
    mysqli_stmt_close($stmt);

    // 5. Atestado cobre este dia?
    $stmt = mysqli_prepare($conexao,
        "SELECT data_registro, dias_cobertos FROM registro
         WHERE matricula = ? AND tipo_registro = 'Atestado'");
    mysqli_stmt_bind_param($stmt, "s", $matricula);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        $inicio = $row['data_registro'];
        $dias   = max(1, (int)$row['dias_cobertos']);
        for ($i = 0; $i < $dias; $i++) {
            if (date('Y-m-d', strtotime("$inicio + $i days")) === $data) {
                $response['is_atestado']  = true;
                $response['registros'][] = 'Atestado';
                break 2;
            }
        }
    }
    mysqli_stmt_close($stmt);

    // 6. Horários dinâmicos das aulas
    $horarios_aulas = [];
    $stmt = mysqli_prepare($conexao,
        "SELECT numero_aula, horario_inicio, horario_fim
         FROM grade_horarios ORDER BY numero_aula ASC");
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        $n = (int)$row['numero_aula'];
        $horarios_aulas[$n] = [
            'inicio' => substr($row['horario_inicio'], 0, 5),
            'fim'    => substr($row['horario_fim'], 0, 5)
        ];
    }
    mysqli_stmt_close($stmt);
    $response['horarios_aulas'] = $horarios_aulas;

    // 7. Frequências detalhadas já salvas
    $stmt = mysqli_prepare($conexao,
        "SELECT aula_numero, status FROM frequencia_detalhada
         WHERE matricula_aluno = ? AND data_aula = ?");
    mysqli_stmt_bind_param($stmt, "ss", $matricula, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $freq_salvas = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $freq_salvas[(int)$row['aula_numero']] = $row['status'];
    }
    mysqli_stmt_close($stmt);

    // 8. Calcula status de cada aula aplicando regras de atraso/dispensa
    //    Se não houver horários cadastrados, usa o que já está salvo.
    if (!empty($horarios_aulas)) {
        $horario_atraso  = $response['horario_atraso']   ? substr($response['horario_atraso'],  0, 5) : null;
        $horario_dispensa= $response['horario_dispensa']  ? substr($response['horario_dispensa'], 0, 5) : null;

        foreach ($horarios_aulas as $num => $h) {
            // Status base: usa o salvo ou 'A' se não houver registro
            $status = $freq_salvas[$num] ?? 'A';

            // --- REGRA DE ATRASO ---
            // Aulas cujo início <= horario_atraso ficam AUSENTES;
            // aulas depois ficam PRESENTES (a menos que dispensa as derrube depois).
            if ($horario_atraso !== null) {
                if ($h['inicio'] <= $horario_atraso) {
                    $status = 'A'; // aula anterior ou em andamento no momento do atraso
                } else {
                    $status = 'P'; // aluno chegou antes desta aula começar
                }
            }

            // --- REGRA DE DISPENSA ---
            // Aplicada DEPOIS do atraso, podendo derrubar presenças das aulas seguintes.
            if ($horario_dispensa !== null) {
                if ($h['inicio'] < $horario_dispensa) {
                    // Aulas que JÁ COMEÇARAM antes da dispensa permanecem (aluno estava lá)
                    // Não sobrescreve o que o atraso definiu; só garante que não viramos A desnecessariamente.
                    // Se o atraso já marcou P e a dispensa ainda não chegou, mantém P.
                    if ($horario_atraso === null) {
                        $status = 'P'; // sem atraso: estava presente
                    }
                    // com atraso: mantém o que o atraso calculou acima
                } elseif ($h['inicio'] === $horario_dispensa) {
                    // Dispensa exatamente no início: aluno não participou
                    $status = 'A';
                } else {
                    // Aula começa DEPOIS da dispensa: ausente
                    $status = 'A';
                }
            }

            $response['frequencias'][$num] = ['status' => $status];
        }
    } else {
        // Sem grade cadastrada: usa o que está salvo
        foreach ($freq_salvas as $num => $status) {
            $response['frequencias'][$num] = ['status' => $status];
        }
    }

    $response['success'] = true;

} catch (Exception $e) {
    $response['success']       = false;
    $response['error_message'] = $e->getMessage();
}

echo json_encode($response);
exit;