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
      <p style="font-size: 24px; font-weight: 100; color:#134292; margin-left: 1%; margin-top: -0.3%;">Data User</p>
      <div class="col-md-12">
        <table class="table table-bordered table-hover data-user" style="white-space: nowrap;">
          <thead>
          <tr>
            <th><div><b>No</b></div></th>
            <th><div><b>Username</b></div></th>
            <th><div><b>Name</b></div></th>
            <th><div><b>KTP</b></div></th>
            <th><div><b>Gender</b></div></th>
            <th><div><b>Birth Date</b></div></th>
            <th><div><b>Birth Place</b></div></th>
            <th><div><b>Email</b></div></th>
            <th><div><b>Phone</b></div></th>
            <th><div><b>Poin</b></div></th>
            <th><div><b>Rule</b></div></th>
          </tr>
          </thead>
        </table>
        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#addUser">
          <i class="fa fa-plus"></i>&nbsp; Add user
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
            <h4 class="modal-title">Add user</h4>
        </div>
        <div class="modal-body">
        <form action="<?=base_url()?>DataUser/create_data" method="POST" enctype="multipart/form-data">
          <div class='form-group'>
            <label >Username</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='username' required placeholder='Username'>
            </p>
          </div>
          <div class='form-group'>
            <label >Password</label>
            <p>
              <input type='password' id="pass" value='' class='form-control input-sm' name='password' required placeholder='Password'>
            </p>
            <p>
              <input type='password' id="rePass" value='' class='form-control input-sm' name='password1' required placeholder='Confirm Password'>
              <span class='help-block' style="color:red; display: none;" id="notMatch">* Password does not match the confirm password</span>
            </p>

          </div>
          <div class='form-group'>
            <label>Name</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='nama' required placeholder='Name'>
            </p>
          </div>
          <div class='form-group'>
            <label>No. KTP</label>
            <p>
              <input type='number' value='' class='form-control input-sm' name='ktp' required placeholder='KTP'>
            </p>
          </div>
          <div class='form-group'>
            <label>Gender</label>
            <p>
              <select class="form-control input-sm" name="jenis_kelamin">
                <option value="1">Laki-laki</option>
                <option value="0">Perempuan</option>
              </select>
            </p>
          </div>
          <div class='form-group'>
            <label >Birth date</label>
            <p>
              <input type='date' value='' class='form-control input-sm' name='tanggal_lahir' required placeholder='Birth date'>
            </p>
          </div>
          <div class='form-group'>
            <label >Birth place</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='tempat_lahir' required placeholder='Birth place'>
            </p>
          </div>
          <div class='form-group'>
            <label >Email</label>
            <p>
              <input type='email' value='' class='form-control input-sm' name='email' required placeholder='Email'>
            </p>
          </div>
          <div class='form-group'>
            <label >Phone No</label>
            <p>
              <input type='text' value='' class='form-control input-sm' name='no_tlp' required placeholder='Phone Number'>
            </p>
          </div>
          <div class='form-group'>
            <label >Rule</label>
            <p>
              <select class="form-control input-sm" name="rule">
                <option value="1">Admin</option>
                <option value="0">User</option>
              </select>
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