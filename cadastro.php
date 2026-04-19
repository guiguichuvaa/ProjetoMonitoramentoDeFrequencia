<?php
session_start();
include ('conexao.php');

// ✅ verificar se os campos estão vazios (CORRIGIDO)
if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['tipo_usuario'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header('Location: tela_cadastro.php');
    exit();
}

// sanitizar os dados
$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));
$tipo_usuario = mysqli_real_escape_string($conexao, trim($_POST['tipo_usuario']));

// 🔒 validar domínio do email
if (!str_ends_with($email, '@admin.com') && !str_ends_with($email, '@coletor.com')) {
    $_SESSION['mensagem'] = "Email inválido! Use @admin.com ou @coletor.com.";
    header('Location: tela_cadastro.php');
    exit();
}

// 🔑 validar tamanho da senha
if (strlen($senha) < 4) {
    $_SESSION['mensagem'] = "A senha deve ter pelo menos 4 caracteres.";
    header('Location: tela_cadastro.php');
    exit();
}

// verificar se já existe email
$sql = "SELECT count(*) as total FROM usuario WHERE email_usuario = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    $_SESSION['mensagem'] = "Email já cadastrado!";
    header('Location: tela_cadastro.php');
    exit();
} else {
    $sql = "INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, perfil_usuario) 
            VALUES ('$nome', '$email', MD5('$senha'), '$tipo_usuario')";
    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
        header('Location: tela_cadastro.php');
        exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($conexao);
        header('Location: tela_cadastro.php');
        exit();
    }
}
?>