<script src="<?php echo base_url('assets/dist/js/canvas.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script type="text/javascript">

$(document).ready(function () {
  var chart = new CanvasJS.Chart("unfinish", {
    animationEnabled: true, 
    title:{
      text: "Sor Por Unfinish <?php echo date("Y-m-d H:i:s"); ?>",
      fontFamily: "tahoma",
      fontSize: 16
    },
    data: [              
    {
      // Change type to "doughnut", "line", "splineArea", etc.
      type: "column",
      indexLabel: "{y}",
      dataPoints: [
        <?php foreach ($unfinishUser as $value) { if($value->count == ""){$count = 0;}else{$count = $value->count;}?>
          { label: "<?php echo $value->id_user_assign; ?>",  y: <?php echo $count; ?>  },
        <?php } ?>
      ]
    }
    ]
  });
  chart.render();

  var chart = new CanvasJS.Chart("finishday", {
    animationEnabled: true, 
    title:{
      text: "Sor Por Finish (<?php echo date("F")." ".date("Y");?>)",
      fontFamily: "tahoma",
      fontSize: 16
    },
    data: [              
    {
      // Change type to "doughnut", "line", "splineArea", etc.
      type: "column",
      indexLabel: "{y}",
      color: "#124191",
      dataPoints: [
        <?php
          for ($i=1; $i <= $totalDays ; $i++) {
            $found = "tidak";
            foreach ($finishMonth as $value) {
              if($value->day == $i){
        ?>
                { label: "<?php echo $i; ?>",  y: <?php echo $value->count; ?>  },
        <?php
                $found = "ada";
                break;
              }
            }
            if($found == "tidak"){
        ?>
                { label: "<?php echo $i; ?>",  y: 0  },
        <?php
            }
          }
        ?>
      ]
    }
    ]
  });
  chart.render();

  var chart = new CanvasJS.Chart("finishyear", {
    animationEnabled: true, 
    title:{
      text: "Sor Por Finish (<?php echo date("Y");?>)",
      fontFamily: "tahoma",
      fontSize: 16        
    },
    data: [              
    {
      <?php $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'); ?>
      // Change type to "doughnut", "line", "splineArea", etc.
      type: "column",
      indexLabel: "{y}",
      color: "#124191",
      dataPoints: [
        <?php
          for ($i=1; $i <= 12 ; $i++) {
            $found = "tidak";
            foreach ($finishYear as $value) {
              if($value->month == $i){
        ?>
                { label: "<?php echo $months[$i]; ?>",  y: <?php echo $value->count; ?>  },
        <?php
                $found = "ada";
                break;
              }
            }
            if($found == "tidak"){
        ?>
                { label: "<?php echo $months[$i]; ?>",  y: 0  },
        <?php
            }
          }
        ?>
      ]
    }
    ]
  });
  chart.render();
});
</script>
<style type="text/css">
  table.table-bordered{
    border:1px solid grey;
  }
  table.table-bordered > tbody > tr > td{
    border:1px solid grey;
  }
</style>
<div class="content-wrapper">


  <!-- Main content -->
  <section class="content" style="background-color: white;">
    <?php if($this->session->flashdata('sukses')){ ?>
      <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $this->session->flashdata('pesanSukses'); ?>
      </div>
    <?php }elseif ($this->session->flashdata('gagal')) {?>
      <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $this->session->flashdata('pesanGagal'); ?>
      </div>
    <?php } ?>
    <!-- Default box -->    
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div id="finishday" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-primary">
          <div id="finishyear" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div id="unfinish" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-left: 10px; margin-top: 10px;">
      <p style="font-size: 24px; font-weight: 100; color:#134292;">Sor Por <?php echo "Finish ".date("F")." ".date("Y"); ?></p>
      <div class="table-responsive">
        <table class="table table-bordered" style="width: 85%; background-color: white; font-size: 12px;">
          <tr>
            <td style="color:#134292; background-color: #F5F5F6;"><b>Finish</b></td>
            <?php
              for ($i=1; $i <= $totalDays ; $i++) { 
                $found = false;
                foreach ($finishMonth as $value) {
                  if($i == $value->day){
            ?>
                    <td style="color:#134292;" align="center"><?php echo $value->count; ?></td>
            <?php 
                    $found = true;
                    break;
                  }
                }
                if($found == false){
            ?>
                    <td style="color:#134292;" align="center">0</td>
            <?php
                }
              }
            ?>
          </tr>
          <tr>
            <td style="color:#134292; background-color: #F5F5F6;"><b>Date</b></td>
            <?php for ($i=1; $i <= $totalDays ; $i++) { if($i < 10){$day = "0".$i;}else{$day = $i;} ?>
              <td style="color:#134292;" align="center"><?php echo $day; ?></td>
            <?php } ?>
          </tr>
        </table>
      </div>
      
      <p style="font-size: 24px; font-weight: 100; color:#134292;">Sor Por <?php echo "Finish ".date("Y"); ?></p>
      <div class="table-responsive">
        <table class="table table-bordered" style="width: 50%; background-color: white; font-size: 12px;">
          <tr>
            <td style="color:#134292; background-color: #F5F5F6;"><b>Finish</b></td>
            <?php
              for ($i=1; $i <= 12 ; $i++) { 
                $found = false;
                foreach ($finishYear as $value) {
                  if($i == $value->month){
            ?>
                    <td style="color:#134292;" align="center"><?php echo $value->count; ?></td>
            <?php 
                    $found = true;
                    break;
                  }
                }
                if($found == false){
            ?>
                    <td style="color:#134292;" align="center">0</td>
            <?php
                }
              }
            ?>
          </tr>
          <tr>
            <td style="color:#134292; background-color: #F5F5F6;"><b>Month</b></td>
            <?php 
              $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
              for ($i=1; $i <= 12 ; $i++) {
            ?>
              <td style="color:#134292;" align="center"><?php echo $months[$i]; ?></td>
            <?php 
              }
            ?>
          </tr>
        </table>
      </div>
      
      <p style="font-size: 24px; font-weight: 100; color:#134292;">Sor Por Unfinish <?php echo date("Y-m-d H:i:s"); ?></p>
      <div class="table-responsive">
        <table class="table table-bordered" style="width: 15%; background-color: white; font-size: 12px;">
          <tr style="color:#134292; background-color: #F5F5F6;"><td><b>Person</b></td><td><b>Qty</b></td></tr>
          <?php 
            foreach ($unfinishUser as $value) {
              if ($value->count == "") {
                $count = 0;
              }else{
                $count = $value->count;
              }
          ?>
            <tr><td><?php echo $value->id_user_assign; ?></td><td><?php echo $count; ?></td></tr>
          <?php
            }
          ?>
        </table>
      </div>
    </div>
  </section>
</div>