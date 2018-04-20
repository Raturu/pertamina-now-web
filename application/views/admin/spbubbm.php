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
      <p style="font-size: 24px; font-weight: 100; color:#dd4b39; margin-left: 1%; margin-top: -0.3%;">Data SPBU BBM</p>
      <div class="col-md-12">
        <table class="table table-bordered table-hover data-spbu" style="white-space: nowrap;">
          <thead>
          <tr>
            <th><div><b>No</b></div></th>
            <th><div><b>SPBU</b></div></th>
            <th><div><b>BBM Name</b></div></th>
            <th><div><b>Level</b></div></th>
            <th><div><b>Max Tank</b></div></th>
            <th><div><b>Min Tank</b></div></th>
            <th><div><b>Price</b></div></th>
            <th><div><b>Status</b></div></th>
          </tr>
          </thead>
        </table>
        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#addUser">
          <i class="fa fa-plus"></i>&nbsp; Add SPBU
        </button>
      </div>
    </div>
  </section>

  <!--add-->
  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addMenuTambahan" id="addUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add SPBU BBM</h4>
        </div>
        <div class="modal-body">
        <form action="<?=base_url()?>SPBU/create_data" method="POST" enctype="multipart/form-data">
          <div class='form-group'>
            <label >No SPBU</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='no_spbu' required placeholder='No SPBU'>
            </p>
          </div>
          <div class='form-group'>
            <label >Name</label>
            <p>
              <input type='text'  value='' class='form-control input-sm' name='nama' required placeholder='Name'>
            </p>
          </div>
          <div class='form-group'>
            <label>Address</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='alamat' required placeholder='Address'>
            </p>
          </div>
          <div class='form-group'>
            <label>City</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='kota' required placeholder='City'>
            </p>
          </div>
          <div class='form-group'>
            <label>Province</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='provinsi' required placeholder='Province'>
            </p>
          </div>
          <div class='form-group'>
            <label>Latitude</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='latitude' required placeholder='Latitude'>
            </p>
          </div>
          <div class='form-group'>
            <label>Longitude</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='longitude' required placeholder='Longitude'>
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Add</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit password -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editPassword">
    <div class="modal-dialog">
      <div class="modal-content" id="modelEditPassword">
        
      </div>
    </div>
  </div>

  <!-- Edit group -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editGroup">
    <div class="modal-dialog">
      <div class="modal-content" id="modelEditGroup">
        
      </div>
    </div>
  </div>
</div>