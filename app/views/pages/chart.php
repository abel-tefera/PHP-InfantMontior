<?php require APPROOT . '/views/inc/header.php';?>
<?php flash('info');?>
<!-- <?php echo $data['id']; ?> -->
<a href="<?php echo URLROOT; ?>/pages/viewInfants" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<a href="<?php echo URLROOT; ?>/pages/history/<?php echo $data['id']; ?>" class="btn btn-info"><i class="fa fa-line-chart"></i> History chart</a>
<a href="<?php echo URLROOT; ?>/pages/download/<?php echo $data['id']; ?>" class="btn btn-dark"><i class="fa fa-download"></i> Download history</a>

  <style>
        .page-wrapper
        {
        width:100%;
        height: 100%;
        /* padding: 0px; */
        /* background: grey; */
        margin:0 auto;
        }
  </style>
  <div class="page-wrapper">
   <br />
   <h2 align="center">Realtime data</h2>
   <div id="line_chart" style="width: 100%; height: 500px; padding: 0px; margin: 0px"></div>
  </div>
<?php require APPROOT . '/views/inc/footer.php';?>
<script type="text/javascript">
      google.charts.load('current', {
    callback: function () {

      drawChart();
      setInterval(drawChart, 1000);
      function drawChart() {
        $.ajax({
          url: '<?php echo URLROOT; ?>/pages/fetch_chart/<?php echo $data['id']; ?>',
          type: 'get',
          success: function (json) {
            var data = new google.visualization.DataTable(json);

              var options = {
              title:'Sensor\'s Data',
              legend:{position:'bottom'},
              chartArea:{width:'100%', height:'100%'}
              };
            var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
            chart.draw(data);
          }
        });
      }

    },
    packages: ['corechart']
  });
</script>