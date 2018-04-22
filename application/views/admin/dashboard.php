<div class="content-wrapper" style="background-color: white;">
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <!-- Content Header (Page header) -->
  <section class="content-header"  style="background-color: #ecf0f5;">
  	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Active User</span>
              <span class="info-box-number"><?php echo $countActiveUser/$countAllUser * 100; ?><small> %</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12" id="lowTank">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-tint"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Low Level Tank</span>
              <span class="info-box-number"><?php echo $countLimitBBM; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales In Current Month</span>
              <span class="info-box-number"><?php echo $countAllTransactionCurrentMonth; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
    </div>
  	<div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div id="inTransaction" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <!-- <div class="col-md-6">
        <div class="box box-primary">
          <div id="percentageBbmBuyed" style="height: 300px; width: 100%;"></div>
        </div>
      </div> -->
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div id="transactionSPBU" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-primary">
          <div id="percentageBbmBuyed" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
    </div>
    <!-- <h1>
      <img src="<?php echo base_url() ?>assets/dist/img/logo.png" class="img-responsive">
    </h1> -->
  </section>
</div>

  <div class="modal fade" tabindex="-1" role="dialog" id="limitBBM">
    <div class="modal-dialog">
      <div class="modal-content" id="modalLimitBBM">
        
      </div>
    </div>
  </div>

<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script>
	$("#lowTank").click(function(){
		$("#limitBBM").modal("show");
		$.post("<?php echo base_url('Dashboard/modalLimitBBM') ?>",
			  {id:$(this).attr('data-id')},
			  function(html){
			      $("#modalLimitBBM").html(html);
			  }   
		);
	});
	window.onload = function () {
		var dps = []; // dataPoints
		var chart = new CanvasJS.Chart("inTransaction", {
			theme: "light2", // "light1", "light2", "dark1", "dark2"
			title :{
				text: "Current Transaction"
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


		var chartPercentageBbmBuyed = new CanvasJS.Chart("percentageBbmBuyed", {
			theme: "light2", // "light1", "light2", "dark1", "dark2"
			animationEnabled: true,
			title: {
				text: "Most Bought BBM"
			},
			data: [{
				type: "pie",
				startAngle: 25,
				toolTipContent: "<b>{label}</b>: {y}%",
				showInLegend: "true",
				legendText: "{label}",
				indexLabelFontSize: 16,
				indexLabel: "{label} - {y}%",
				dataPoints: [
					<?php foreach ($bbmBuyed->result() as $value) { ?>
						{ y: <?php echo round($value->count / $countBbmBuyed * 100,2); ?>, label: <?php echo '"'.$value->jenis.'"'; ?> },
					<?php } ?>
				]
			}]
		});
		chartPercentageBbmBuyed.render();

		var chartTransactionSPBU = new CanvasJS.Chart("transactionSPBU", {
			theme: "light2", // "light1", "light2", "dark1", "dark2"
			animationEnabled: true,
			title: {
				text: "Most Visit SPBU",
				fontWeight: "bold"
			},
			data: [{
				type: "pie",
				startAngle: 25,
				toolTipContent: "<b>{label}</b>: {y}%",
				showInLegend: "true",
				legendText: "{label}",
				indexLabelFontSize: 16,
				indexLabel: "{label} - {y}%",
				dataPoints: [
					<?php foreach ($transactionSPBU->result() as $value) { ?>
						{ y: <?php echo round($value->count / $countTransactionSPBU * 100,2); ?>, label: <?php echo '"'.$value->nama.'"'; ?> },
					<?php } ?>
				]
			}]
		});
		chartTransactionSPBU.render();
	}
</script>