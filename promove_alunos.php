
<?php
//atualizar série dos alunos para a próxima série
session_start();
require_once 'conexao.php';

if (!isset($conn)) {
    if (isset($conexao)) {
        $conn = $conexao;
    } elseif (isset($pdo)) {
        $conn = $pdo;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: lista_alunos.php');
    exit();
}

// Excluir alunos do 3° ano e seus registros/frequências antes de promover os demais
$deleteFrequenciaSql = "DELETE f FROM frequencia f
                        JOIN aluno a ON f.matricula_aluno_frequencia = a.matricula
                        WHERE a.turma_aluno LIKE '3%'";
$deleteFrequenciaStmt = $conn->prepare($deleteFrequenciaSql);
$deleteFrequenciaStmt->execute();

$deleteRegistroSql = "DELETE r FROM registro r
                      JOIN aluno a ON r.matricula = a.matricula
                      WHERE a.turma_aluno LIKE '3%'";
$deleteRegistroStmt = $conn->prepare($deleteRegistroSql);
$deleteRegistroStmt->execute();

$deleteAlunoSql = "DELETE FROM aluno WHERE turma_aluno LIKE '3%'";
$deleteAlunoStmt = $conn->prepare($deleteAlunoSql);
$deleteAlunoStmt->execute();

$sql = "UPDATE aluno SET turma_aluno = CASE 
                WHEN turma_aluno LIKE '1%' THEN CONCAT('2', SUBSTRING(turma_aluno, 2))
                WHEN turma_aluno LIKE '2%' THEN CONCAT('3', SUBSTRING(turma_aluno, 2))
                ELSE turma_aluno
            END
            WHERE turma_aluno LIKE '1%' OR turma_aluno LIKE '2%'";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Atualizar os registros de frequência dos alunos promovidos
$updateFrequenciaSql = "UPDATE frequencia f
                        JOIN aluno a ON f.matricula_aluno_frequencia = a.matricula
                        SET f.turma_aluno_frequencia = a.turma_aluno
                        WHERE a.turma_aluno IS NOT NULL";
$updateFrequenciaStmt = $conn->prepare($updateFrequenciaSql);
$updateFrequenciaStmt->execute();

// Atualizar os registros de atestados dos alunos promovidos
$updateRegistroSql = "UPDATE registro r
                      JOIN aluno a ON r.matricula = a.matricula
                      SET r.turma_aluno = a.turma_aluno
                      WHERE a.turma_aluno IS NOT NULL";
$updateRegistroStmt = $conn->prepare($updateRegistroSql);
$updateRegistroStmt->execute();

$_SESSION['mensagem'] = "Alunos promovidos com sucesso!";
header('Location: lista_alunos.php');
exit();
