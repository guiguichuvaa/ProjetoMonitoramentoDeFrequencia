<?php
require_once 'conexao.php';

// 1. Capturar filtros (Ajustado para bater com o 'name' do HTML: nome, turma, matricula)
$filterNome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$filterTurma = isset($_GET['turma']) ? trim($_GET['turma']) : '';
$filterMatricula = isset($_GET['matricula']) ? trim($_GET['matricula']) : '';
$filterTipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
$filterData = isset($_GET['data']) ? trim($_GET['data']) : '';

// 2. Buscar todos os registros do banco (Função definida abaixo)
$todosRegistros = buscar_registros($conexao);

// 3. Preparar o array de filtros para a função de filtragem
$filtros = array();
if ($filterNome !== '') {
    $filtros['nome_aluno'] = $filterNome; // 'nome_aluno' é a coluna no banco
}
if ($filterTurma !== '') {
    $filtros['turma_aluno'] = $filterTurma;
}
if ($filterMatricula !== '') {
    $filtros['matricula'] = $filterMatricula;
}
if ($filterTipo !== '') {
    $filtros['tipo_registro'] = $filterTipo;
}
if ($filterData !== '') {
    $filtros['data_registro'] = $filterData;
}

// 4. Executar a filtragem ou mostrar tudo
if (!empty($filtros)) {
    // Se existem termos de busca, filtramos o array original
    $registros_filtrados = filtrar_registros($todosRegistros, $filtros);
} else {
    // Se não há busca, a variável $registros_filtrados recebe todos
    $registros_filtrados = $todosRegistros;
}

// --- FUNÇÕES ---

function buscar_registros($conexao)
{
    $registros = array();
    $query = "SELECT id_registro, nome_aluno, turma_aluno, numero_aluno, matricula, tipo_registro, data_registro FROM registro";
    $result = mysqli_query($conexao, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $registros[] = $row;
        }
    }
    return $registros;
}

function filtrar_registros($registros, $filtros)
{
    $registros_filtrados = array();

    foreach ($registros as $registro) {
        $match = true;
        foreach ($filtros as $campo => $valor) {
            // Busca parcial (case-insensitive) dentro do campo
            if (!empty($valor) && stripos($registro[$campo], $valor) === false) {
                $match = false;
                break;
            }
        }
        if ($match) {
            $registros_filtrados[] = $registro;
        }
    }
    return $registros_filtrados;
}
?>
