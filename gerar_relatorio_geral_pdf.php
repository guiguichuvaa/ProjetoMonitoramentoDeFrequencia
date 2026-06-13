<?php
// Minimal PDF generator endpoint: fetch data and output a simple PDF
session_start();
ob_start();
include('conexao.php');
include('verifica_login.php');
include('dados.php');
include('fpdf.php');

$printHeader = function ($pdf, $data_formatada) {
    // Adiciona o logo no centro (ajuste o caminho e tamanho conforme necessário)
    $pdf->Image('img/logo_eeep-removebg-preview.png', 80, 0, 50); // (caminho, x, y, largura)
    $pdf->SetY(35); // Ajusta a posição vertical para o texto do cabeçalho
    // 1. Nome da Instituição (Negrito e Centralizado)
$pdf->SetFont('Arial', 'B', 14); // Define Arial, Bold (Negrito), Tamanho 14
// Usar largura '0' faz a célula ocupar toda a largura útil da página (da margem esquerda até a direita)
$pdf->Cell(0, 10, utf8_decode('Escola Profissional de Educação Profissional Manoel Mano'), 0, 1, 'C');

// Espaçamento entre blocos (opcional)
$pdf->Ln(15);

// 2. Título do Relatório (Menor ou com outra formatação se preferir, também centralizado)
$pdf->SetFont('Arial', 'B', 16); // Um pouco maior para o título principal, ou mantenha o padrão
$textoRelatorio = 'Relatório Geral de Frequência - '. $data_formatada;
$pdf->Cell(0, 10, utf8_decode($textoRelatorio), 0, 1, 'C');

// Espaço final antes de começar o conteúdo/tabela do PDF
$pdf->Ln(10);
};

$data = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');
$validDate = DateTime::createFromFormat('Y-m-d', $data);
if (!$validDate) {
    $data = date('Y-m-d');
    $validDate = new DateTime($data);
}

$data_formatada = $validDate->format('d/m/Y');
$total_presentes = contar_total_frequencias($conexao, $data);
$total_faltas = contar_total_faltas($conexao, $data);
$total_atrasos = contar_atrasos_por_dia($conexao, $data);
$total_dispensas = contar_dispensas_por_dia($conexao, $data);


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
$pdf->Cell(40, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Métricas Gerais:'), 0, 1);
//adiciona linha de divisão
$pdf->SetLineWidth(0.3);
$pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Presenças: ' . $total_presentes . ' alunos'), 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Faltas: ' . $total_faltas . ' alunos'), 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Atrasos: ' . $total_atrasos . ' alunos'), 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Dispensas: ' . $total_dispensas . ' alunos'), 0, 1);
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Lista de faltosos:'), 0, 1);
//linha de divisão
$pdf->SetLineWidth(0.3);
$pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(130, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Nome'), 1, 0, 'C');
$pdf->Cell(20, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Turma'), 1, 0, 'C');
$pdf->Cell(20, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Número'), 1, 1, 'C');
$pdf->SetFont('Arial', '', 11);

$lineHeight = 7;
$bottomGap = 20;
$maxY = 270 - $bottomGap; // Altura máxima para evitar ultrapassar a margem inferior

if (!empty($alunos_faltosos)) {
    foreach ($alunos_faltosos as $aluno) {
        $nome = $aluno['nome_aluno'];
        $turma = $aluno['turma_aluno'];
        $numero = $aluno['numero_aluno'];
        if ($pdf->GetY() + $lineHeight > $maxY) {
            $pdf->AddPage();
            // print header on new page
            $printHeader($pdf, $data_formatada);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Lista de faltosos:'), 0, 1);
                //linha de divisão
            $pdf->SetLineWidth(0.3);
            $pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(130, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Nome'), 1, 0, 'C');
            $pdf->Cell(20, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Turma'), 1, 0, 'C');
            $pdf->Cell(20, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Número'), 1, 1, 'C');
            $pdf->SetFont('Arial', '', 11);
            $maxY = 270 - $bottomGap;
        }
        $pdf->Cell(130, $lineHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nome), 1, 0);
        $pdf->Cell(20, $lineHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $turma), 1, 0, 'C');
        $pdf->Cell(20, $lineHeight, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $numero), 1, 1, 'C');
    }
} else {
    $pdf->Cell(170, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Nenhum aluno faltoso encontrado para esta data.'), 1, 1, 'C');
}

if (ob_get_length()) {
    ob_end_clean();
}
$pdf->Output(
    'relatorio_geral_' . $data . '.pdf', 'D'
);
