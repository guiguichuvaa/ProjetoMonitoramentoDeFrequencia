<?php
session_start();
include('conexao.php');
include('helper.php');

if (empty($_POST['email']) || empty($_POST['senha'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos.";
    header('Location: tela_login.php');
    exit();
}

$email = mysqli_real_escape_string($conexao, $_POST['email']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

// 🔒 Validação do domínio do email
if (!str_ends_with($email, '@admin.com') && !str_ends_with($email, '@coletor.com')) {
    $_SESSION['mensagem'] = "Email inválido! Use um email @admin.com ou @coletor.com.";
    header('Location: tela_login.php');
    exit();
}

// 🔑 Validação do tamanho da senha
if (strlen($senha) < 4) {
    $_SESSION['mensagem'] = "A senha deve ter pelo menos 4 caracteres.";
    header('Location: tela_login.php');
    exit();
}

$query = "SELECT id_usuario, email_usuario, nome_usuario, perfil_usuario FROM usuario 
          WHERE email_usuario = '$email' 
          AND senha_usuario = MD5('$senha')";

$result = mysqli_query($conexao, $query);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

$row = mysqli_num_rows($result);

if ($row == 1) {
    if (!verificar_autorizacao($conexao, $email)) {
        header('Location: tela_login.php');
        exit();
    }
        // Buscando os dados do usuário do resultado da query
        $userData = mysqli_fetch_assoc($result);
        
        // Salvando todas as informações na sessão
        $_SESSION['email'] = $userData['email_usuario'];
        $_SESSION['nome_usuario'] = $userData['nome_usuario'];
        $_SESSION['perfil_usuario'] = $userData['perfil_usuario'];
        
        header('Location: painel.php');
        exit();
    
} else {
    $_SESSION['mensagem'] = "Email ou senha incorretos.";
    header('Location: tela_login.php');
    exit();
}
