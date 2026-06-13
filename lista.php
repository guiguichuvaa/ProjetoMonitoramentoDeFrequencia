<?php

// Capturar filtros enviados via GET
$filterNome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$filterTurma = isset($_GET['turma']) ? trim($_GET['turma']) : '';
$filterMatricula = isset($_GET['matricula']) ? trim($_GET['matricula']) : '';
$filterEmail = isset($_GET['email']) ? trim($_GET['email']) : '';
$filterNumero = isset($_GET['numero']) ? trim($_GET['numero']) : '';
$filterData = isset($_GET['data']) ? trim($_GET['data']) : '';

// Buscar alunos baseado nos filtros
if (!empty($filterData)) {
    // Se há data, buscar alunos com faltas nessa data
    $alunos = buscar_alunos_com_faltas($conexao, $filterData);
    // Filtrar apenas os ausentes
    $alunosFiltrados = array_filter($alunos, function($aluno) {
        return $aluno['situacao'] == 'A';
    });
} else {
    // Buscar todos os alunos do banco
    $alunos = buscar_alunos($conexao);
}

// Aplicar filtros se houver (para nome, turma, matricula)
$filtros = array();
if ($filterNome !== '') {
    $filtros['nome_aluno'] = $filterNome;
}
if ($filterTurma !== '' && $filterTurma !== 'Selecione') {
    $filtros['turma_aluno'] = $filterTurma;
}
if ($filterMatricula !== '') {
    $filtros['matricula'] = $filterMatricula;
}

if (!empty($filterData)) {
    // Se já filtramos por data, aplicar filtros adicionais
    $alunosFiltrados = filtrar_alunos($alunosFiltrados, $filtros);
} else {
    $alunosFiltrados = filtrar_alunos($alunos, $filtros);
}

// Se nenhum filtro, exibe todos (mas se data foi fornecida, já está filtrado)
if (empty($filtros) && empty($filterData)) {
    $alunosFiltrados = $alunos;
}

if (isset($_POST['nome']) && $_POST['nome'] != '') {
    $alunos = array();

    $alunos['nome'] = $_POST['nome'];
}

if (isset($_POST['turma']) && $_POST['turma'] != '') {

    $alunos['turma'] = $_POST['turma'];
}

if (isset($_POST['matricula']) && $_POST['matricula'] != '') {

    $alunos['matricula'] = $_POST['matricula'];
}

if (isset($_POST['numero_aluno']) && $_POST['numero_aluno'] != '') {

    $alunos['numero_aluno'] = $_POST['numero_aluno'];
}

function buscar_alunos($conexao)
{
    $alunos = array();
    $query = "SELECT nome_aluno, turma_aluno, numero_aluno, matricula FROM aluno ORDER BY nome_aluno ASC";
    $result = mysqli_query($conexao, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $alunos[] = $row;
        }
    }
    return $alunos;
}

function filtrar_alunos($alunos, $filtros)
{
    $alunos_filtrados = array();

    foreach ($alunos as $aluno) {
        $match = true;
        foreach ($filtros as $campo => $valor) {
            if (!empty($valor) && stripos($aluno[$campo], $valor) === false) {
                $match = false;
                break;
            }
        }
        if ($match) {
            $alunos_filtrados[] = $aluno;
        }
    }
    return $alunos_filtrados;
}

function buscar_alunos_com_faltas($conexao, $data)
{
    $alunos = array();
    // Sanitizamos a data para evitar erros
    $data = mysqli_real_escape_string($conexao, $data);

    $query = "SELECT 
                a.nome_aluno, 
                a.turma_aluno, 
                a.numero_aluno,
                a.matricula, 
                COALESCE(f.situacao_frequencia, 'Ausente') as situacao
              FROM aluno a
              LEFT JOIN frequencia f ON a.matricula = f.matricula_aluno_frequencia 
              AND f.data_frequencia = '$data' 
              WHERE f.situacao_frequencia = 'A'
              ORDER BY a.nome_aluno ASC";

    $result = mysqli_query($conexao, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $alunos[] = $row;
        }
    }
    return $alunos;
}


function buscar_alunos_com_situacao($conexao, $data)
{
    $alunos = array();
    // Sanitizamos a data para evitar erros
    $data = mysqli_real_escape_string($conexao, $data);

    $query = "SELECT 
                a.nome_aluno, 
                a.turma_aluno, 
                a.numero_aluno,
                a.matricula, 
                COALESCE(f.situacao_frequencia, 'Presente') as situacao
              FROM aluno a
              LEFT JOIN frequencia f ON a.matricula = f.matricula_aluno_frequencia 
              AND f.data_frequencia = '$data' 
              ORDER BY a.nome_aluno ASC";

    $result = mysqli_query($conexao, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $alunos[] = $row;
        }
    }
    return $alunos;
}

