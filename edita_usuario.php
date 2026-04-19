<?php
session_start();
include('conexao.php');

if (!isset($_POST['nome_usuario']) || !isset($_POST['email_usuario']) || !isset($_POST['tipo_usuario'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos obrigatórios. Campos recebidos: " . implode(', ', array_keys($_POST));
    header('Location: tela_edita_usuario.php');
    exit();
}

$id_usuario = mysqli_real_escape_string($conexao, $_POST['id_usuario']);
$nomeEditado = mysqli_real_escape_string($conexao, $_POST['nome_usuario']);
$emailEditado = mysqli_real_escape_string($conexao, $_POST['email_usuario']);
$perfilEditado = mysqli_real_escape_string($conexao, $_POST['tipo_usuario']);
$is_autorizedEditado = isset($_POST['is_autorized']) ? ($_POST['is_autorized'] === 'NULL' ? NULL : mysqli_real_escape_string($conexao, $_POST['is_autorized'])) : null;

// Verificar se a senha foi preenchida
if (!empty($_POST['senha'])) {
    $senhaEditada = mysqli_real_escape_string($conexao, md5($_POST['senha']));
    $query = "UPDATE usuario SET nome_usuario = '$nomeEditado', email_usuario = '$emailEditado', senha_usuario = '$senhaEditada', perfil_usuario = '$perfilEditado'";
    if ($is_autorizedEditado !== null) {
        $query .= ", is_autorized = " . ($is_autorizedEditado === NULL ? "NULL" : "'$is_autorizedEditado'");
    }
    $query .= " WHERE id_usuario = '$id_usuario'";
} else {
    // Se a senha não foi preenchida, não atualizar a senha
    $query = "UPDATE usuario SET nome_usuario = '$nomeEditado', email_usuario = '$emailEditado', perfil_usuario = '$perfilEditado'";
    if ($is_autorizedEditado !== null) {
        $query .= ", is_autorized = " . ($is_autorizedEditado === NULL ? "NULL" : "'$is_autorizedEditado'");
    }
    $query .= " WHERE id_usuario = '$id_usuario'";
}

if (mysqli_query($conexao, $query)) {
    $_SESSION['mensagem'] = "Usuário editado com sucesso.";
    header('Location: lista_usuario.php');
    exit();
} else {
    $error = mysqli_error($conexao);
    $_SESSION['mensagem'] = "Erro ao editar usuário: $error";
    header('Location: tela_edita_usuario.php?email_usuario=' . $emailEditado);
    exit();
}
