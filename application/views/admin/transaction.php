<div class="content-wrapper" style="background-color: white;">
  <!-- Main content -->
  <section class="content">
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
      <p style="font-size: 24px; font-weight: 100; color:#dd4b39; margin-left: 1%; margin-top: -0.3%;">Data Transaction</p>
      <div class="col-md-12">
        <table class="table table-bordered table-hover data-transaction" style="white-space: nowrap;">
          <thead>
          <tr>
            <th><div><b>No</b></div></th>
            <th><div><b>User name</b></div></th>
            <th><div><b>SPBU Name</b></div></th>
            <th><div><b>BBM Name</b></div></th>
            <th><div><b>Promo Title</b></div></th>
            <th><div><b>Promo Poin</b></div></th>
            <th><div><b>Time Transaction</b></div></th>
            <th><div><b>Gasoline Amount</b></div></th>
            <th><div><b>Paid Amount</b></div></th>
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>
</div>