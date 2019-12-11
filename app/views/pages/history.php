<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('info');?>
<a href="<?php echo URLROOT; ?>/pages/chart/<?php echo $data['id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>

<div class="page-wrapper">
   <br />
   <h2 align="center"><?php echo $data['name'].'\'s History';?></h2>
   <div id="chartContainer1" style="height: 370px; width: 95%;"></div>
<div id="chartContainer2" style="height: 370px; width: 95%;"></div>
<div id="chartContainer3" style="height: 370px; width: 95%;"></div>
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>  

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer1", {
	title: {
		text: "Temperature"
	},
	axisY: {
		title: "Temperature"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($data['Temperature'], JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

var chart2 = new CanvasJS.Chart("chartContainer2", {
	title: {
		text: "Breathing rate"
	},
	axisY: {
		title: "Breathing rate"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($data['Breathing'], JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();

var chart3 = new CanvasJS.Chart("chartContainer3", {
	title: {
		text: "Humidity"
	},
	axisY: {
		title: "Humidity"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($data['Humidity'], JSON_NUMERIC_CHECK); ?>
	}]
});
chart3.render();
 
}
</script>

<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<script  type="text/javascript" src="<?php echo URLROOT; ?>/js/canvasjs.min.js"></script>
 