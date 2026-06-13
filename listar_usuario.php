<?php
// 1. Capturar filtros (Ajustado para bater com o 'name' do HTML: nome e email)
$filterNome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$filterEmail = isset($_GET['email']) ? trim($_GET['email']) : '';

// 2. Buscar todos os usuários do banco (Função definida abaixo)
$todosUsuarios = buscar_usuarios($conexao);

// 3. Preparar o array de filtros para a função de filtragem
$filtros = array();
if ($filterNome !== '') {
    $filtros['nome_usuario'] = $filterNome; // 'nome_usuario' é a coluna no banco
}
if ($filterEmail !== '') {
    $filtros['email_usuario'] = $filterEmail; // 'email_usuario' é a coluna no banco
}

// 4. Executar a filtragem ou mostrar tudo
if (!empty($filtros)) {
    // Se existem termos de busca, filtramos o array original
    $usuarios = filtrar_usuarios($todosUsuarios, $filtros);
} else {
    // Se não há busca, a variável $usuarios recebe todos
    $usuarios = $todosUsuarios;
}

// --- FUNÇÕES ---

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
            // Busca parcial (case-insensitive) dentro do campo
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
