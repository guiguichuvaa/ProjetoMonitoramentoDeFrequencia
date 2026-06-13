<?php
// Minimal PDF generator endpoint: fetch data and output a simple PDF
session_start();
ob_start();
include('conexao.php');
include('verifica_login.php');
include('dados.php');
include('fpdf.php');

//verifica se a matrícula do aluno foi passada como parâmetro
if (!isset($_GET['matricula'])) {
    echo "Matrícula do aluno não fornecida.";
    exit();
}
$matricula = $_GET['matricula'];
 //busca os dados do aluno com base na matrícula
$query_aluno = "SELECT * FROM aluno WHERE matricula = '$matricula'";
$result_aluno = mysqli_query($conexao, $query_aluno);
if ($result_aluno && mysqli_num_rows($result_aluno) > 0) {
    $aluno = mysqli_fetch_assoc($result_aluno);
} else {
    echo "Aluno não encontrado.";
    exit();
}


$printHeader = function ($pdf, $data_formatada) {
    // Adiciona o logo no centro (ajuste o caminho e tamanho conforme necessário)
    $pdf->Image('img/logo_eeep-removebg-preview.png', 80, 0, 50); // (caminho, x, y, largura)
    $pdf->SetY(35); // Ajusta a posição vertical para o texto do cabeçalho
    // 1. Nome da Instituição (Negrito e Centralizado)
$pdf->SetFont('Arial', 'B', 14); // Define Arial, Bold (Negrito), Tamanho 14
// Usar largura '0' faz a célula ocupar toda a largura útil da página (da margem esquerda até a direita)
$pdf->Cell(0, 10, utf8_decode('Escola Profissional de Educação Profissional Manoel Mano'), 0, 1, 'C');

// Espaçamento entre blocos (opcional)
$pdf->Ln(3);

// 2. Título do Relatório (Menor ou com outra formatação se preferir, também centralizado)
$pdf->SetFont('Arial', 'B', 16); // Um pouco maior para o título principal, ou mantenha o padrão
$textoRelatorio = 'Relatório Geral de Aluno';
$pdf->Cell(0, 10, utf8_decode($textoRelatorio), 0, 1, 'C');

// Espaço final antes de começar o conteúdo/tabela do PDF
$pdf->Ln(3);
};

$data = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');
$validDate = DateTime::createFromFormat('Y-m-d', $data);
if (!$validDate) {
    $data = date('Y-m-d');
    $validDate = new DateTime($data);
}

$data_formatada = $validDate->format('d/m/Y');
$total_presentes = contar_frequencia_no_mes_por_aluno($conexao, $matricula, $validDate->format('m'));
$total_faltas = contar_faltas_no_mes_por_aluno($conexao, $matricula, $validDate->format('m'));
$total_justificados = contar_dias_justificados_por_aluno($conexao, $matricula);
$total_faltas_liquidas = $total_faltas - $total_justificados;
$situacao_pe_de_meia = porcentagem_frequencia($conexao, $aluno['matricula'], $validDate->format('m'));
$mes = array(
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
);

$alunos_faltosos = array();
$data_escaped = mysqli_real_escape_string($conexao, $data);
$query_faltosos = "SELECT a.nome_aluno, a.turma_aluno, a.numero_aluno
                    FROM aluno a
                    INNER JOIN frequencia f ON a.matricula = f.matricula_aluno_frequencia
                    WHERE f.data_frequencia = '$data_escaped' AND f.situacao_frequencia = 'A'
                    ORDER BY a.turma_aluno, a.nome_aluno";
$result_faltosos = mysqli_query($conexao, $query_faltosos);
if ($result_faltosos) {
    while ($row = mysqli_fetch_assoc($result_faltosos)) {
        $alunos_faltosos[] = $row;
    }
}


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// first page header
$printHeader($pdf, $data_formatada);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(40, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Dados Pessoais:'), 0, 1);
//adiciona linha de divisão
$pdf->SetLineWidth(0.3);
$pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Nome Completo: ' . $aluno['nome_aluno']), 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Turma: ' . $aluno['turma_aluno']), 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Matrícula: ' . $aluno['matricula']), 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Número da Chamada: ' . $aluno['numero_aluno']), 0, 1);

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Informações:'), 0, 1);
//linha de divisão
$pdf->SetLineWidth(0.3);
$pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(110, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Total de Presenças: ' . $total_presentes), 0, 0);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Situação Pé-De-Meia:'. date('m/Y')), 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Total de Faltas: ' . $total_faltas), 0, 0);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $situacao_pe_de_meia . '%'), 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Total de Faltas Justificadas: ' . $total_justificados), 0, 1);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Total de Faltas Líquidas (Tirando as Justificadas): ' . $total_faltas_liquidas), 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Mês'), 1, 0, 'C');
$pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Presenças'), 1, 0, 'C');
$pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Faltas'), 1, 1, 'C');
$pdf->SetFont('Arial', '', 11);

$lineHeight = 7;
$bottomGap = 20;
$maxY = 270 - $bottomGap; // Altura máxima para evitar ultrapassar a margem inferior
        // Exibe os dados dw todos os meses do ano
for ($m = 1; $m <= 12; $m++) {
    $mes_num = str_pad($m, 2, '0', STR_PAD_LEFT);
    $mes_nome = $mes[$mes_num];
    $presencas_mes = contar_frequencia_no_mes_por_aluno($conexao, $matricula, $mes_num);
    $faltas_mes = contar_faltas_no_mes_por_aluno($conexao, $matricula, $mes_num);
    if ($pdf->GetY() + $lineHeight > $maxY) {
        $pdf->AddPage();
        // print header on new page
        $printHeader($pdf, $data_formatada);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Informações:'), 0, 1);
            //linha de divisão
        $pdf->SetLineWidth(0.3);
        $pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
        $pdf->Ln(10);
        // reimprime o cabeçalho da tabela
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(70, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Mês'), 1, 0, 'C');
        $pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Presenças'), 1, 0, 'C');
        $pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Faltas'), 1, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
    }
    $pdf->Cell(70, $lineHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $mes_nome), 1, 0);
    $pdf->Cell(40, $lineHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $presencas_mes), 1, 0, 'C');
    $pdf->Cell(40, $lineHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $faltas_mes), 1, 1, 'C');
}

if (ob_get_length()) {
    ob_end_clean();
}
$pdf->Output(
    'relatorio_geral_aluno_' . $aluno['nome_aluno'] . '.pdf', 'D'
);
