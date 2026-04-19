<?php
session_start();
include('conexao.php');
include('lista.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Alunos - FrequenCy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Topo -->
    <?php include('navbar.php');  ?>

    <div class="container mt-4">

        <h4 class="mb-3">Lista de Alunos</h4>

        <!-- Filtros -->
        <form method="get" action="lista_alunos.php">
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
                    <label class="form-label">Matrícula:</label>
                    <input type="text" name="matricula" class="form-control" placeholder="Insira uma matrícula:" value="<?php echo htmlspecialchars($filterMatricula); ?>">
                </div>

                <div class="col-md-3">
                    <input type="submit" value="Buscar Alunos" class="btn btn-success mt-4 w-100 fs-5">
                </div>
            </div>
        </form>

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
                                    <div class="d-grid gap-3 d-md-flex justify-content-md-center ">
                                        <button class="btn btn-sm btn-primary">
                                            <a href="painel_aluno.php?matricula=<?php echo $aluno['matricula']; ?>" class="text-decoration-none text-white">Visualizar</a>
                                        </button>
                                        <button class="btn btn-sm btn-success">
                                            <a href="tela_edita_aluno.php?matricula=<?php echo $aluno['matricula']; ?>" class="text-decoration-none text-white">Editar</a>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-matricula="<?php echo $aluno['matricula']; ?>">
                                            Excluir
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir este aluno?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<script>
    var confirmDeleteModal = document.getElementById('confirmDeleteModal');
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var matricula = button.getAttribute('data-matricula');
        var confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.href = 'exclui_aluno.php?matricula=' + matricula;
    });
</script>

</html>