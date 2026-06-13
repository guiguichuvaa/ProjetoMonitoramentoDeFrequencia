<?php
session_start();
include('conexao.php');

$emailUsuario = $_GET['email_usuario'];

$query = "DELETE FROM usuario WHERE email_usuario = '$emailUsuario'";

//se ele excluir a própria conta, ele é redirecionado para a página de logout, que destrói a sessão e o redireciona para a tela de login. Se ele excluir a conta de outro usuário, ele é redirecionado para a página de listar usuários.
if ($emailUsuario === $_SESSION['email_usuario']) {
    if (mysqli_query($conexao, $query)) {
        $_SESSION['mensagem'] = "Sua conta foi excluída com sucesso.";
        header('Location: logout.php');
        exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir sua conta.";
        header('Location: logout.php');
        exit();
    }
}
if (mysqli_query($conexao, $query)) {
    $_SESSION['mensagem'] = "Usuário excluído com sucesso.";
    header('Location: lista_usuario.php');
    exit();
} else {
    $_SESSION['mensagem'] = "Erro ao excluir usuário.";
    header('Location: lista_usuario.php');
    exit();
}
?>
