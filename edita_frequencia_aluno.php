<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['data'];
    $situacao = $_POST['situacao'];
    $matricula = $_POST['matricula'];

    $matricula = mysqli_real_escape_string($conexao, $matricula);
    $situacao = mysqli_real_escape_string($conexao, $situacao);
    
    // Buscamos os dados do aluno para o caso de ser um novo registro
    $res = mysqli_query($conexao, "SELECT nome_aluno, turma_aluno FROM aluno WHERE matricula = '$matricula'");
    $dados = mysqli_fetch_assoc($res);
    $nome = $dados['nome_aluno'];
    $turma = $dados['turma_aluno'];


    //remover registro de frequência caso a situação seja "Null"
    if($_POST['situacao'] == 'Null') {
      $query = "DELETE FROM frequencia WHERE data_frequencia = '$data' AND matricula_aluno_frequencia = '$matricula'";
      mysqli_query($conexao, $query);
      $_SESSION['success'] = "Frequência removida com sucesso!";
      header("Location: painel_aluno.php?matricula=$matricula");
      exit();
    
    }

    // O segredo está aqui:
    $query = "INSERT INTO frequencia 
                (data_frequencia, nome_aluno_frequencia, matricula_aluno_frequencia, turma_aluno_frequencia, situacao_frequencia) 
              VALUES 
                ('$data', '$nome', '$matricula', '$turma', '$situacao') 
              ON DUPLICATE KEY UPDATE 
                situacao_frequencia = '$situacao'"; // Se já existir, apenas muda a situação
    
    mysqli_query($conexao, $query);

    $_SESSION['success'] = "Frequência atualizada com sucesso!";

    header("Location: painel_aluno.php?matricula=$matricula");
    exit();
}else{
    $_SESSION['success'] = "Não foi possível atualizar a frequência.";
    header("Location: painel_aluno.php");
    exit();
}



?>