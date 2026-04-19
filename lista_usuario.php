<?php
session_start();
include('conexao.php');
include('listar_usuario.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Usuários - FrequenCy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Topo -->
    <?php include('navbar.php');  ?>

    <div class="container mt-4">

        <h4 class="mb-3">Lista de Usuários</h4>

        <!-- Filtros -->
        <form method="get" action="lista_usuario.php">
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Nome:</label>
                    <input type="text" name="nome" class="form-control" placeholder="Insira um nome:" value="<?php echo htmlspecialchars($filterNome); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Insira um email:" value="<?php echo htmlspecialchars($filterEmail); ?>">
                </div>

                <div class="col-md-3">
                    <input type="submit" value="Buscar Usuários" class="btn btn-success mt-4 w-100 fs-5">
                </div>
            </div>
        </form>

        <!-- Tabela -->
        <div class="card">
            <div class="card-header bg-warning fw-bold">
                Lista de Usuários
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-success">
                        <tr>
                            <th>Nome do usuário</th>
                            <th>Email</th>
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['nome_usuario']; ?></td>
                                <td><?php echo $usuario['email_usuario']; ?></td>
                                <td><?php echo $usuario['is_autorized'] == 1 ? 'Autorizado' : 'Não Autorizado'; ?></td>
                                <td>
                                    <div class="d-grid gap-3 d-md-flex justify-content-md-center ">
                                        <button class="btn btn-sm btn-primary">
                                            <a href="painel_aluno.php?email_usuario=<?php echo $usuario['email_usuario']; ?>" class="text-decoration-none text-white">Visualizar</a>
                                        </button>
                                        <button class="btn btn-sm btn-success">
                                            <a href="tela_edita_usuario.php?email_usuario=<?php echo $usuario['email_usuario']; ?>" class="text-decoration-none text-white">Editar</a>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-email_usuario="<?php echo $usuario['email_usuario']; ?>">
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