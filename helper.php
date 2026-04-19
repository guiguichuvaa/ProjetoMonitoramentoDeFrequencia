<?php

function pegar_matricula_aluno($conexao, $matricula)
{
    $query = "SELECT id_aluno FROM aluno WHERE matricula = '$matricula'";
    $result = mysqli_query($conexao, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['id_aluno'];
    }
    return null; // Retorna null se não encontrar o aluno
}

function verificar_autorizacao($conexao, $email_usuario)
{
    $query = "SELECT is_autorized FROM usuario WHERE email_usuario = '$email_usuario'";
    $result = mysqli_query($conexao, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['is_autorized'] == 1) {
            return true; // Usuário autorizado
        } else {
            $_SESSION['mensagem'] = "Seu email ($email_usuario) não tem permissão para logar.";
            return false; // Usuário não autorizado
        }
    } else {
        $_SESSION['mensagem'] = "Usuário não encontrado.";
        return false; // Usuário não encontrado
    }
}

function converte_autorizacao($is_autorized)
{
    if ($is_autorized == 1) {
        return "Ativo";
    } else {
        return "Inativo";
    }
}
