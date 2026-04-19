<?php
// Capturar filtros enviados via GET
$filterNome = isset($_GET['nome_usuario']) ? trim($_GET['nome_usuario']) : '';
$filterEmail = isset($_GET['email_usuario']) ? trim($_GET['email_usuario']) : '';

//PARTE DE USUARIOS
$usuarios = buscar_usuarios($conexao);

// Aplicar filtros se houver
$filtros = array();
if ($filterNome !== '') {
    $filtros['nome_usuario'] = $filterNome;
}
if ($filterEmail !== '') {
    $filtros['email_usuario'] = $filterEmail;
}
// Se nenhum filtro, exibe todos
if (empty($filtros)) {
    $usuariosFiltrados = $usuarios;
}

if (isset($_GET['nome_usuario']) && $_GET['nome_usuario'] != '') {
    $usuarios = array();

    $usuarios['nome_usuario'] = $_GET['nome_usuario'];
}

if (isset($_GET['email_usuario']) && $_GET['email_usuario'] != '') {
    $usuarios['email_usuario'] = $_GET['email_usuario'];
}

function buscar_usuarios($conexao)
{
    $usuarios = array();
    $query = "SELECT nome_usuario, email_usuario, is_autorized FROM usuario";
    $result = mysqli_query($conexao, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $usuarios[] = $row;
        }
    }
    return $usuarios;
}

function filtrar_usuarios($usuarios, $filtros)
{
    $usuarios_filtrados = array();

    foreach ($usuarios as $usuario) {
        $match = true;
        foreach ($filtros as $campo => $valor) {
            if (!empty($valor) && stripos($usuario[$campo], $valor) === false) {
                $match = false;
                break;
            }
        }
        if ($match) {
            $usuarios_filtrados[] = $usuario;
        }
    }
    return $usuarios_filtrados;
}

?>