<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['bar']
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    // Definimos a data atual ou a vinda do POST
    <?php $data_grafico = isset($_POST['data']) ? $_POST['data'] : date('Y-m-d'); ?>

    var data = google.visualization.arrayToDataTable([
      ['Séries', 'Enfermagem', 'Informática', 'Desen. de Sistemas', 'Administração'],
      ['1º Anos', <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '1A'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '1B'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '1C'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '1D'); ?>],
      ['2º Anos', <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '2A'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '2B'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '2C'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '2D'); ?>],
      ['3º Anos', <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '3A'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '3B'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '3C'); ?>, <?php echo contar_frequencia_por_turma($conexao, $data_grafico, '3D'); ?>]

    ]);



    var container = document.getElementById('columnchart_material');
    var options = {
      chart: {
        title: 'Presença por Série',
        subtitle: 'Dados do dia: <?php echo date("d/m/Y", strtotime($data_grafico)); ?>',
        backgroundColor: 'transparent',
        fontSize: 16,
        FontFace: 'Arial',
        fontColor: '#000000',
        fontWeight: 'bold',
      },
      legend: {
        position: 'bottom',
        alignment: 'center'
      },
      colors: ['#0d8a4f', '#ff7a1a'], // Cor verde para combinar com seu tema
      backgroundColor: 'transparent', // Deixa o fundo transparente para combinar com seu tema
      width: container.offsetWidth,
      height: Math.max(300, Math.round(container.offsetWidth * 0.6))
    };

    var chart = new google.charts.Bar(container);
    chart.draw(data, google.charts.Bar.convertOptions(options));
  }

  window.addEventListener('resize', drawChart);
</script>
<div id="columnchart_material" style="width: 100%; max-width: 650px; height: 400px; min-height: 300px;"></div>