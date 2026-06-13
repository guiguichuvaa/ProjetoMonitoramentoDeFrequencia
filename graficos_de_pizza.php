<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']}); // Pacote corechart
  google.charts.setOnLoadCallback(drawPieChart);

  function drawPieChart() {
    var data = google.visualization.arrayToDataTable([
      ['Status', 'Quantidade'],
      ['Presentes', <?php echo contar_total_frequencias($conexao, $data_grafico); ?>],
      ['Faltas',    <?php echo contar_total_faltas($conexao, $data_grafico); ?>]
    ]);

    var container = document.getElementById('donutchart');
    var options = {
      title: 'Proporção de Frequência Geral',
      pieHole: 0.4, // Transforma em gráfico de rosca (opcional)
      colors: ['#0d8a4f', '#ff7a1a'],
      fontSize: 16, FontFace: 'Arial', fontColor: '#000000', fontWeight: 'bold',
      backgroundColor: 'transparent', // Deixa o fundo transparente para combinar com seu tema
      width: container.offsetWidth,
      height: Math.max(300, Math.round(container.offsetWidth * 0.6)),
      chartArea: { width: '90%', height: '85%' }
    };

    var chart = new google.visualization.PieChart(container);
    chart.draw(data, options);
  }

  window.addEventListener('resize', drawPieChart);
</script>
<div id="donutchart" style="width: 100%; max-width: 650px; height: 400px; min-height: 300px;"></div>