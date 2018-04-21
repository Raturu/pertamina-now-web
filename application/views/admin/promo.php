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
      <p style="font-size: 24px; font-weight: 100; color:#dd4b39; margin-left: 1%; margin-top: -0.3%;">Data Promo</p>
      <div class="col-md-12">
        <table class="table table-bordered table-hover data-promo" style="white-space: nowrap;">
          <thead>
          <tr>
            <th><div><b>No</b></div></th>
            <th><div><b>Title</b></div></th>
            <th><div><b>Category</b></div></th>
            <th><div><b>SPBU Name</b></div></th>
            <th><div><b>Description</b></div></th>
            <th><div><b>Point</b></div></th>
            <th><div><b>Promo Amount</b></div></th>
            <th><div><b>Promo Used</b></div></th>
            <th><div><b>Time Start</b></div></th>
            <th><div><b>Time Finish</b></div></th>
            <th><div><b>Picture</b></div></th>
            <th><div><b>Status</b></div></th>
          </tr>
          </thead>
        </table>
        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#addUser">
          <i class="fa fa-plus"></i>&nbsp; Add Promo
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
            <h4 class="modal-title">Add Promo</h4>
        </div>
        <div class="modal-body">
        <form action="<?=base_url()?>Promo/create_data" method="POST" enctype="multipart/form-data">
          <div class='form-group'>
            <label >Title</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='judul' required placeholder='Title'>
            </p>
          </div>
          <div class='form-group'>
            <label >Category</label>
            <p>
              <select class='form-control input-sm' name='id_kategori_promo' id='id_kategori_promo' required>
                <?php foreach ($kategori->result() as $value) { ?>
                  <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>
                <?php } ?>
              </select>
            </p>
          </div>
          <div class='form-group'>
            <label>SPBU</label>
            <p>
              <select class='form-control input-sm' name='id_spbu' id='id_spbu' required>
                <?php foreach ($spbu->result() as $value) { ?>
                  <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>
                <?php } ?>
              </select>
            </p>
          </div>
          <div class='form-group'>
            <label>Description</label>
            <p>
              <textarea class='form-control input-sm' name='diskripsi'></textarea>
            </p>
          </div>
          <div class='form-group'>
            <label>Point</label>
            <p>
              <input type='number' value='' class='form-control input-sm' name='poin' required placeholder='Point'>
            </p>
          </div>
          <div class='form-group'>
            <label>Promo Amount</label>
            <p>
              <input type='number' value='' class='form-control input-sm' name='jumlah_promo' required placeholder='Price'>
            </p>
          </div>
          <div class='form-group'>
            <label>Time Start</label>
            <p>
              <input type='datetime-local' value='' class='form-control input-sm' name='waktu_mulai' required placeholder='Time Start'>
            </p>
          </div>
          <div class='form-group'>
            <label>Time Finish</label>
            <p>
              <input type='datetime-local' value='' class='form-control input-sm' name='waktu_selesai' required placeholder='Time Finish'>
            </p>
          </div>
          <div class='form-group'>
            <label>Picture</label>
            <p>
              <input type='file' value='' class='form-control input-sm' name='userfile' required placeholder='Picture' accept=".jpg, .jpeg, .png">
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

  <!-- Edit bbm -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editPicture">
    <div class="modal-dialog">
      <div class="modal-content" id="modelEditPicture">
        
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