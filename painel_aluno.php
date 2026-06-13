<?php
session_start();
include('conexao.php');
include('dados.php');

// Verificar se a matrícula foi passada via GET
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Buscar o aluno no banco de dados
    $query = "SELECT nome_aluno, turma_aluno, matricula, numero_aluno FROM aluno WHERE matricula = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "s", $matricula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $aluno = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    } else {
        echo "Matrícula não encontrada.";
        exit;
    }
} else {
    echo "Matrícula não fornecida.";
    exit;
}

// --- LÓGICA DO CALENDÁRIO COM FILTRO MANUAL ---
$ano_atual = isset($_GET['ano_filtro']) ? intval($_GET['ano_filtro']) : intval(date('Y'));
$mes_atual = isset($_GET['mes_filtro']) ? $_GET['mes_filtro'] : date('m');

// cal_days_in_month identifica anos bissextos automaticamente para qualquer ano digitado
$num_dias = cal_days_in_month(CAL_GREGORIAN, intval($mes_atual), $ano_atual);
$primeiro_dia_mes = date('w', strtotime("$ano_atual-$mes_atual-01"));

$presencas = [];
$query_freq = "SELECT data_frequencia, situacao_frequencia FROM frequencia WHERE matricula_aluno_frequencia = ? AND MONTH(data_frequencia) = ? AND YEAR(data_frequencia) = ?";
$stmt_freq = mysqli_prepare($conexao, $query_freq);
mysqli_stmt_bind_param($stmt_freq, "sss", $aluno['matricula'], $mes_atual, $ano_atual);
mysqli_stmt_execute($stmt_freq);
$res_freq = mysqli_stmt_get_result($stmt_freq);

while ($row = mysqli_fetch_assoc($res_freq)) {
    $presencas[$row['data_frequencia']] = $row['situacao_frequencia'];
}
mysqli_stmt_close($stmt_freq);

// --- INTEGRAÇÃO COM BANCO: BUSCA DE OCORRÊNCIAS PARA AS CORES DO CALENDÁRIO ---
$atestados_mes = [];
$query_atest = "SELECT data_registro, dias_cobertos FROM registro WHERE matricula = ? AND tipo_registro = 'Atestado'";
if ($stmt_atest = mysqli_prepare($conexao, $query_atest)) {
    mysqli_stmt_bind_param($stmt_atest, "s", $aluno['matricula']);
    mysqli_stmt_execute($stmt_atest);
    $res_atest = mysqli_stmt_get_result($stmt_atest);
    while ($row = mysqli_fetch_assoc($res_atest)) {
        $data_inicio = $row['data_registro'];
        $dias_cobertos = max(1, (int)$row['dias_cobertos']);
        
        for ($i = 0; $i < $dias_cobertos; $i++) {
            $data_atual = date('Y-m-d', strtotime("$data_inicio + $i days"));
            $atestados_mes[$data_atual] = true;
        }
    }
    mysqli_stmt_close($stmt_atest);
}

$atrasos_mes = [];
$query_atraso = "SELECT data_registro FROM registro WHERE matricula = ? AND tipo_registro = 'Atraso' AND MONTH(data_registro) = ? AND YEAR(data_registro) = ?";
if ($stmt_atraso = mysqli_prepare($conexao, $query_atraso)) {
    mysqli_stmt_bind_param($stmt_atraso, "sss", $aluno['matricula'], $mes_atual, $ano_atual);
    mysqli_stmt_execute($stmt_atraso);
    $res_atraso = mysqli_stmt_get_result($stmt_atraso);
    while ($row = mysqli_fetch_assoc($res_atraso)) {
        $atrasos_mes[$row['data_registro']] = true;
    }
    mysqli_stmt_close($stmt_atraso);
}

$dispensas_mes = [];
$query_disp = "SELECT data_registro FROM registro WHERE matricula = ? AND tipo_registro = 'Dispensa' AND MONTH(data_registro) = ? AND YEAR(data_registro) = ?";
if ($stmt_disp = mysqli_prepare($conexao, $query_disp)) {
    mysqli_stmt_bind_param($stmt_disp, "sss", $aluno['matricula'], $mes_atual, $ano_atual);
    mysqli_stmt_execute($stmt_disp);
    $res_disp = mysqli_stmt_get_result($stmt_disp);
    while ($row = mysqli_fetch_assoc($res_disp)) {
        $dispensas_mes[$row['data_registro']] = true;
    }
    mysqli_stmt_close($stmt_disp);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno - FrequenCy</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon_io/image.png" type="image/x-icon">

    <style>
        body {
            background-color: #f0f9f4;
            font-family: 'Poppins', sans-serif;
            display: block;
            margin: 0;
        }

        .conteudo-perfil {
            margin: 4vh auto 50px;
            width: 95%;
            max-width: 900px;
        }

        .dash-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .avatar-grande {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #0d8a4f, #12c95e);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 auto 15px;
        }

        .btn-gerar-dados {
            background-color: #0d8a4f;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 5px 15px;
            transition: 0.3s;
            height: 31px;
            line-height: 1;
        }

        .btn-gerar-dados:hover {
            background-color: #0a6d3e;
            color: white;
        }

        .info-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 1.1rem;
            color: #2d3436;
            font-weight: 500;
        }

        .btn-outline-green {
            border: 2px solid #0d8a4f;
            color: #0d8a4f;
            font-weight: 600;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-outline-orange {
            border: 2px solid #ff7a1a;
            color: #ff7a1a;
            font-weight: 600;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-outline-orange:hover {
            background: #ff7a1a;
            color: white;
        }

        .btn-outline-green:hover {
            background: #0d8a4f;
            color: white;
        }

        .mini-card {
            min-height: 170px;
        }

        .calendario-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 4px;
        }

        .calendario-table th {
            font-size: 0.65rem;
            color: #6c757d;
            text-transform: uppercase;
            padding-bottom: 8px;
            text-align: center;
        }

        .dia-card {
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.8rem;
            color: #2d3436;
        }

        /* Cores Dinâmicas do Calendário */
        .dia-presente { background: #12c95e !important; color: white !important; }
        .dia-ausente { background: #ff4757 !important; color: white !important; }
        .dia-atestado { background: #0284c7 !important; color: white !important; }
        .dia-atraso { background: #ff7a1a !important; color: white !important; }
        .dia-multipla { background: #8b5cf6 !important; color: white !important; }

        .dia-vazio { background: transparent; }
        .mes-titulo-badge { color: #0d8a4f; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; }
        .ponto-legenda { width: 10px; height: 10px; display: inline-block; border-radius: 50%; margin-right: 5px; }
        .titulo-verde { color: #0d8a4f; font-weight: 700; text-align: center; margin-bottom: 25px; font-size: 1.8rem; }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="conteudo-perfil">
        <div class="row align-items-center mb-3 header-row">
            <div class="col-auto">
                <a href="painel.php" class="btn btn-danger rounded-pill px-4 mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
                    </svg>
                </a>
            </div>
            <div class="col text-center">
                <h2 class="titulo-verde mb-2 mt-3">Painel do Aluno</h2>
            </div>
        </div>

        <?php if (isset($_SESSION['success']) || isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-success alert-dismissible fade show fw-bold text-center" role="alert">
                <?= $_SESSION['success'] ?? $_SESSION['mensagem']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['success']); unset($_SESSION['mensagem']); endif; ?>

        <div class="dash-card p-4 text-center mb-4 position-relative overflow-hidden">
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg, #0d8a4f, #ff7a1a);"></div>
            <div class="avatar-grande"><?= strtoupper(substr($aluno['nome_aluno'], 0, 1)); ?></div>
            <h3 class="fw-bold text-dark mb-1"><?= $aluno['nome_aluno']; ?></h3>
            <p class="text-muted mb-0">Turma <?= htmlspecialchars($aluno['turma_aluno']); ?></p>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="dash-card p-4 h-100">
                    <h5 class="fw-bold mb-4 border-start border-warning border-4 ps-2">Dados do Aluno</h5>
                    <div class="info-label">Nome Completo</div>
                    <div class="info-value mb-3"><?= $aluno['nome_aluno']; ?></div>
                    <div class="info-label">Número</div>
                    <div class="info-value mb-3"><?= $aluno['numero_aluno']; ?></div>
                    <div class="info-label">Turma</div>
                    <div class="info-value mb-3"><?= $aluno['turma_aluno']; ?></div>
                    <div class="info-label">Matrícula</div>
                    <div class="info-value"><?= $aluno['matricula']; ?></div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="dash-card p-4 h-100 d-flex flex-column justify-content-center text-center">
                    <h5 class="fw-bold mb-4">Ações</h5>
                    <div class="d-grid gap-3">
                        <a href="lista_alunos.php" class="btn btn-outline-green py-2">Lista de Alunos</a>
                        <a href="tela_edita_aluno.php?matricula=<?= urlencode($aluno['matricula']); ?>" class="btn btn-outline-primary fw-semibold rounded-pill py-2">Editar Aluno</a>
                        <button type="button" class="btn btn-outline-warning fw-semibold rounded-pill py-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar Frequência</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dash-card p-4 text-center mini-card mb-4">
                    <span class="text-muted fw-semibold">Presença no mês:</span>
                    <h2 class="fw-bold text-success m-4"><?= contar_frequencia_no_mes_por_aluno($conexao, $aluno['matricula'], $mes_atual); ?></h2>
                </div>
                <div class="dash-card p-4 text-center mini-card mb-4">
                    <span class="text-muted fw-semibold">Faltas no mês:</span>
                    <h2 class="fw-bold text-danger m-4"><?= contar_faltas_no_mes_por_aluno($conexao, $aluno['matricula'], $mes_atual); ?></h2>
                </div>
                <div class="dash-card p-4 text-center mini-card mb-4">
                    <span class="text-muted fw-semibold">Presença no ano:</span>
                    <h2 class="fw-bold text-success m-4"><?= contar_frequencia_no_ano_por_aluno($conexao, $aluno['matricula'], $ano_atual); ?></h2>
                </div>
                <div class="dash-card p-4 text-center mini-card mb-4">
                    <span class="text-muted fw-semibold">Faltas Justificadas:</span>
                    <h2 class="fw-bold text-success m-4"><?= contar_dias_justificados_por_aluno($conexao, $aluno['matricula']); ?></h2>
                </div>
            </div>

            <div class="col-md-8">
                <div class="dash-card p-4 text-center mini-card mb-4">
                    <span class="text-muted fw-semibold">Situação Pé-De-Meia:</span>
                    <div class="fs-4 fw-semibold mb-2 px-2 py-3">
                        <h2 class="badge bg-secondary fw-semibold">
                            <?= porcentagem_frequencia($conexao, $aluno['matricula'], $mes_atual); ?>%
                        </h2>
                    </div>
                </div>
                <div class="dash-card p-4 text-center mini-card mb-4">
                    <span class="text-muted fw-semibold mb-3">Registros:</span>
                    <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                        <a class="btn btn-outline-warning fw-semibold rounded-pill py-2" href="tela_cadastro_atestado.php?matricula=<?= $aluno['matricula'] ?>">Atestados</a>
                        <a class="btn btn-outline-warning fw-semibold rounded-pill py-2" href="tela_cadastro_dispensa.php?matricula=<?= $aluno['matricula'] ?>">Dispensas</a>
                        <a class="btn btn-outline-warning fw-semibold rounded-pill py-2" href="tela_cadastro_atraso.php?matricula=<?= $aluno['matricula'] ?>">Atrasos</a>
                    </div>
                </div>

                <div class="dash-card p-3 text-center mb-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-3">
                        <span class="text-muted fw-semibold">Assiduidade:</span>

                        <form method="GET" class="d-flex gap-1 align-items-center">
                            <input type="hidden" name="matricula" value="<?= $aluno['matricula']; ?>">
                            <select name="mes_filtro" class="form-select form-select-sm border-success" style="width: 80px;">
                                <?php
                                $meses = ["01" => "Jan", "02" => "Fev", "03" => "Mar", "04" => "Abr", "05" => "Mai", "06" => "Jun", "07" => "Jul", "08" => "Ago", "09" => "Set", "10" => "Out", "11" => "Nov", "12" => "Dez"];
                                foreach ($meses as $num => $nome) {
                                    $sel = ($num == $mes_atual) ? "selected" : "";
                                    echo "<option value='$num' $sel>$nome</option>";
                                }
                                ?>
                            </select>
                            <input type="number" name="ano_filtro" class="form-control form-control-sm border-success" value="<?= $ano_atual ?>" placeholder="Ano" style="width: 90px;" min="1900" max="2100">
                            <button type="submit" class="btn-gerar-dados">Filtrar</button>
                        </form>
                    </div>

                    <?php if (isset($_GET['mes_filtro'])): ?>
                        <div id="msg-filtro" class="alert alert-success py-1 mb-2" style="font-size: 0.75rem;">
                            Calendário de <?= $ano_atual ?> updated!
                        </div>
                        <script>setTimeout(() => { document.getElementById('msg-filtro').style.display = 'none'; }, 2500);</script>
                    <?php endif; ?>

                    <div class="mb-2 mes-titulo-badge">
                        <?= date('M / Y', strtotime("$ano_atual-$mes_atual-01")); ?>
                    </div>
                    <table class="calendario-table">
    <thead>
        <tr>
            <th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Inicializa o contador de dias da semana (0 = Domingo)
        $dia_semana = $primeiro_dia_mes;
        $dia = 1;
        
        // Primeira linha: células vazias até o primeiro dia do mês
        echo "<tr>";
        for ($i = 0; $i < $dia_semana; $i++) {
            echo "<td class='dia-vazio'></td>";
        }
        
        // Loop pelos dias do mês
      for ($dia = 1; $dia <= $num_dias; $dia++) {
            $data_loop = sprintf("%s-%s-%02d", $ano_atual, $mes_atual, $dia);
            
            $tem_presenca = isset($presencas[$data_loop]) && trim($presencas[$data_loop]) === 'P';
            $tem_falta = isset($presencas[$data_loop]) && trim($presencas[$data_loop]) === 'A';
            $tem_atestado = isset($atestados_mes[$data_loop]);
            $tem_atraso = isset($atrasos_mes[$data_loop]);
            $tem_dispensa = isset($dispensas_mes[$data_loop]);

            $ocorrencias = 0;
            if ($tem_atestado) $ocorrencias++;
            if ($tem_atraso) $ocorrencias++;
            if ($tem_dispensa) $ocorrencias++;

            $st = "";
            // NOVA ORDEM DE PRIORIDADES CORRIGIDA
            if ($ocorrencias >= 2) {
                // 1º - Mais de um registo (ex: Atraso + Dispensa)
                $st = 'dia-multipla';
            } elseif ($tem_atraso || $tem_dispensa) {
                // 2º - Atraso ou Dispensa (Fica Laranja!)
                $st = 'dia-atraso';
            } elseif ($tem_presenca) {
                // 3º - Presença normal (Verde). Se houver Atestado + Presença, fica verde aqui.
                $st = 'dia-presente';
            } elseif ($tem_atestado) {
                // 4º - Atestado sem presença (Azul). Resolve as ausências justificadas.
                $st = 'dia-atestado';
            } elseif ($tem_falta) {
                // 5º - Falta pura (Vermelho).
                $st = 'dia-ausente';
            }
            
            $nomeAlunoJs = addslashes($aluno['nome_aluno']);
            $turmaAlunoJs = addslashes($aluno['turma_aluno']);
            
            echo "<td style='cursor:pointer;' onclick=\"abrirModalFrequencia('{$aluno['matricula']}', '{$data_loop}', '{$nomeAlunoJs}', '{$turmaAlunoJs}')\">
                    <div class='dia-card {$st}'>{$dia}</div>
                  </td>";
            
            // Avança o dia da semana
            $dia_semana++;
            // Se chegou a sábado (6), fecha a linha e abre uma nova, a menos que seja o último dia
            if ($dia_semana == 7) {
                echo "</tr>";
                if ($dia < $num_dias) {
                    echo "<tr>";
                }
                $dia_semana = 0;
            }
        }
        
        // Completa a última linha com células vazias, se necessário
        if ($dia_semana > 0 && $dia_semana < 7) {
            for ($i = $dia_semana; $i < 7; $i++) {
                echo "<td class='dia-vazio'></td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
                    
                    <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                        <small><span class="ponto-legenda bg-success"></span> Presente</small>
                        <small><span class="ponto-legenda bg-danger"></span> Falta Total</small>
                        <small><span class="ponto-legenda" style="background:#0284c7;"></span> Atestado</small>
                        <small><span class="ponto-legenda" style="background:#ff7a1a;"></span> Atraso/Dispensa</small>
                        <small><span class="ponto-legenda" style="background:#8b5cf6;"></span> Multi-ocorrência</small>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-2">
                <div class="dash-card card-bottom p-3 text-center shadow-sm" style="background: linear-gradient(135deg, #0d8a4f, #12c95e); cursor: pointer;">
                    <a href="gerar_relatorio_aluno.php?matricula=<?php echo $aluno['matricula']?>">
                        <span class="fw-bold text-white fs-5 text-uppercase">Gerar Relatório do Aluno</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Editar Frequência</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edita_frequencia_aluno.php" method="POST">
                        <input type="hidden" name="matricula" value="<?= $aluno['matricula'] ?>">
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Data:</label>
                            <input type="date" class="form-control" name="data" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Situação:</label>
                            <select class="form-select" name="situacao" required>
                                <option value="P">Presente</option>
                                <option value="A">Ausente</option>
                                <option value="Null">Nulo</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alteração</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <?php include('modal_frequencia_aulas.php'); ?>

</body>
</html>