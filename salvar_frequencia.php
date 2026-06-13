<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['data'];
    $situacoes = $_POST['situacao'];

    foreach ($situacoes as $matricula => $situacao) {
        $matricula = mysqli_real_escape_string($conexao, $matricula);
        $situacao = mysqli_real_escape_string($conexao, $situacao);
        
        // Buscamos os dados do aluno para o caso de ser um novo registro
        $res = mysqli_query($conexao, "SELECT nome_aluno, turma_aluno FROM aluno WHERE matricula = '$matricula'");
        $dados = mysqli_fetch_assoc($res);
        $nome = $dados['nome_aluno'];
        $turma = $dados['turma_aluno'];

        // O segredo está aqui:
        $query = "INSERT INTO frequencia 
                    (data_frequencia, nome_aluno_frequencia, matricula_aluno_frequencia, turma_aluno_frequencia, situacao_frequencia) 
                  VALUES 
                    ('$data', '$nome', '$matricula', '$turma', '$situacao') 
                  ON DUPLICATE KEY UPDATE 
                    situacao_frequencia = '$situacao'"; // Se já existir, apenas muda a situação
        
        mysqli_query($conexao, $query);
    }

    //se a conta for coletor, redireciona para a página de frequência do coletor
    if (isset($_SESSION['email']) && str_ends_with($_SESSION['email'], '@coletor.com')) {
        header("Location: lista_frequencia_coletor.php?data=$data&success=1");
        exit();
    }else{
  
    header("Location: lista_frequencia.php?data=$data&success=1");
    exit();
    
}
}