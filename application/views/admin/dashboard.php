<div class="content-wrapper" style="background-color: white;">
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <!-- Content Header (Page header) -->
  <section class="content-header">
  	<div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div id="inTransaction" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-primary">
          <div id="finishyear" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
    </div>
    <!-- <h1>
      <img src="<?php echo base_url() ?>assets/dist/img/logo.png" class="img-responsive">
    </h1> -->
  </section>
</div>
<script>
	window.onload = function () {
		var dps = []; // dataPoints
		var chart = new CanvasJS.Chart("inTransaction", {
			title :{
				text: "In Transaction"
			},
			axisY: {
				includeZero: false
			},      
			data: [{
				type: "line",
				dataPoints: dps
			}]
		});
		var xVal = 0;
		var yVal = 0; 
		var updateInterval = 1000;
		var dataLength = 20; // number of dataPoints visible at any point
		var updateChart = function (count) {
			count = count || 1;

			for (var j = 0; j < count; j++) {
				$.ajax({
				    url : '<?php echo base_url('Dashboard/getIntransaction') ?>',
				    success : function(respone)
				    {
				      yVal =  parseInt(respone);
				    }
				});

				dps.push({
					x: xVal,
					y: yVal
				});
				xVal++;
			}

			if (dps.length > dataLength) {
				dps.shift();
			}
			chart.render();
		};
		updateChart(dataLength);
		setInterval(function(){updateChart()}, updateInterval);

	}
</script>