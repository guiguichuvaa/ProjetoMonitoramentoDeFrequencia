<?php
session_start();
include('conexao.php');
include('verifica_login.php');
include('lista.php');

// Capturar filtros
$filterNome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$filterTurma = isset($_GET['turma']) ? trim($_GET['turma']) : '';
$filterData = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

// Buscar alunos com situação
$alunos = buscar_alunos_com_situacao($conexao, $filterData);

// Aplicar filtros
$filtros = array();
if ($filterNome !== '') {
    $filtros['nome_aluno'] = $filterNome;
}
if ($filterTurma !== '' && $filterTurma !== 'Selecione') {
    $filtros['turma_aluno'] = $filterTurma;
}

$alunosFiltrados = filtrar_alunos($alunos, $filtros);

// Se nenhum filtro, exibe todos
if (empty($filtros)) {
    $alunosFiltrados = $alunos;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Realizar Frequência - FrequenCy</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        body { background-color: #f0f9f4; font-family: 'Poppins', sans-serif; display: block; margin: 0; }
        
        .conteudo-pagina { margin: 4vh auto 50px; width: 95%; max-width: 1000px; }
        .dash-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); }
        
        .header-card {
            position: relative;
            overflow: hidden;
            padding: 30px 20px;
            text-align: center;
        }

        .header-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #0d8a4f, #ff7a1a);
        }

        .header-card h3 {
            font-weight: 700;
            color: #1c3249;
            margin: 0;
        }
    </style>
</head>

<body>

    <?php 
    $_SESSION['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : null; 
    include('navbar.php');
    ?>

    <div class="conteudo-pagina">

        <div class="dash-card header-card mb-4">
            <h3>Realizar Frequência</h3>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                Frequência salva com sucesso!
            </div>
        <?php endif; ?>

        <!-- Filtros -->
        <form method="get" action="lista_frequencia.php">
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Nome:</label>
                    <input type="text" name="nome" class="form-control" placeholder="Insira um nome:" value="<?php echo htmlspecialchars($filterNome); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Turma:</label>
                    <select name="turma" class="form-select">
                        <option value="">Selecione</option>
                        <option value="1A" <?php if ($filterTurma == '1A') echo 'selected'; ?>>1ºA</option>
                        <option value="1B" <?php if ($filterTurma == '1B') echo 'selected'; ?>>1ºB</option>
                        <option value="1C" <?php if ($filterTurma == '1C') echo 'selected'; ?>>1ºC</option>
                        <option value="1D" <?php if ($filterTurma == '1D') echo 'selected'; ?>>1ºD</option>
                        <option value="2A" <?php if ($filterTurma == '2A') echo 'selected'; ?>>2ºA</option>
                        <option value="2B" <?php if ($filterTurma == '2B') echo 'selected'; ?>>2ºB</option>
                        <option value="2C" <?php if ($filterTurma == '2C') echo 'selected'; ?>>2ºC</option>
                        <option value="2D" <?php if ($filterTurma == '2D') echo 'selected'; ?>>2ºD</option>
                        <option value="3A" <?php if ($filterTurma == '3A') echo 'selected'; ?>>3ºA</option>
                        <option value="3B" <?php if ($filterTurma == '3B') echo 'selected'; ?>>3ºB</option>
                        <option value="3C" <?php if ($filterTurma == '3C') echo 'selected'; ?>>3ºC</option>
                        <option value="3D" <?php if ($filterTurma == '3D') echo 'selected'; ?>>3ºD</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Data:</label>
                    <input type="date" name="data" class="form-control" value="<?php echo htmlspecialchars($filterData); ?>" required>
                </div>

                <div class="col-md-3">
                    <input type="submit" value="Filtrar" class="btn btn-primary mt-4 w-100 fs-5">
                </div>
            </div>
        </form>

        <!-- Formulário de Frequência -->
        <form method="post" action="salvar_frequencia.php">
            <input type="hidden" name="data" value="<?php echo htmlspecialchars($filterData); ?>">

            <!-- Tabela -->
            <div class="card">
                <div class="card-header bg-warning fw-bold">
                    Lista de Alunos
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>Nome do aluno</th>
                                <th>Turma</th>
                                <th>Matrícula</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alunosFiltrados as $aluno): ?>
                                <tr>
                                    <td><?php echo $aluno['nome_aluno']; ?></td>
                                    <td><?php echo $aluno['turma_aluno']; ?></td>
                                    <td><?php echo $aluno['matricula']; ?></td>
                                    <td>
                                        <select name="situacao[<?php echo $aluno['matricula']; ?>]" class="form-select">
                                            <option value="Presente" <?php if ($aluno['situacao'] == "Presente") echo "selected"; ?>>Presente</option>
                                            <option value="Ausente" <?php if ($aluno['situacao'] == "Ausente") echo "selected"; ?>>Ausente</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center mt-3">
                <input type="submit" value="Salvar Frequência" class="btn btn-success fs-5">
            </div>
        </form>

    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>