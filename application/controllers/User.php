<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core/Admin_Controller.php');
class User extends Admin_Controller {
  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('id') == ""){
      redirect('Auth');
    }
  	$this->load->model("MDataUser");
  }
  public function index($nama_user = null) {
    $this->data['current_page'] = $this->uri->uri_string();
    $this->content = 'admin/user';     
    $this->navigation = 'template_admin/_parts/navigation/admin_view'; 
    // passing middle to function. change this for different views.
    $this->data['page_title'] = 'Data User | Pertamina Now';
    $this->layout();
  }

  public function get_data(){
    $start  = $_REQUEST['iDisplayStart'];
    $length = $_REQUEST['iDisplayLength'];
    $sSearch = $_REQUEST['sSearch'];

    $col = $_REQUEST['iSortCol_0'];

    $arr = array(0 => 'id', 1 => 'username', 2 => 'nama', 3=> 'ktp', 4=> 'jenis_kelamin', 5=> 'tanggal_lahir', 6=> 'tempat_lahir', 7=> 'email', 8 => 'no_tlp', 9 => 'poin', 10=> 'rule');

    $sort_by = $arr[$col];
    $sort_type = $_REQUEST['sSortDir_0'];

        
    $qry = "select * from user u where (u.username LIKE '%".$sSearch."%' or u.nama LIKE '%".$sSearch."%' or u.ktp LIKE '%".$sSearch."%' or u.jenis_kelamin LIKE '%".$sSearch."%' or u.tanggal_lahir LIKE '%".$sSearch."%' or u.tempat_lahir LIKE '%".$sSearch."%' or u.email LIKE '%".$sSearch."%' or u.no_tlp like '%".$sSearch."%')  ORDER BY ".$sort_by." ".$sort_type." LIMIT ".$start.", ".$length;
    $res = $this->db->query($qry);

    $qry = "select count(u.id) as count from user u where (u.username LIKE '%".$sSearch."%' or u.nama LIKE '%".$sSearch."%' or u.ktp LIKE '%".$sSearch."%' or u.jenis_kelamin LIKE '%".$sSearch."%' or u.tanggal_lahir LIKE '%".$sSearch."%' or u.tempat_lahir LIKE '%".$sSearch."%' or u.email LIKE '%".$sSearch."%' or u.no_tlp like '%".$sSearch."%')";
    $result = $this->db->query($qry);

    foreach($result->result() as $key)
    {
        $iTotal = $key->count;
    }

    $rec = array(
        'iTotalRecords' => $iTotal,
        'iTotalDisplayRecords' => $iTotal,
        'aaData' => array()
    );

    $k=0;
    $i=1;
    if($res->num_rows() != null){
        foreach ($res->result() as $value) {
          if($value->username == ''){$username = '-';}else{$username = $value->username;}
          if($value->nama == ''){$nama = '-';}else{$nama = $value->nama;}
          if($value->ktp == ''){$ktp = '-';}else{$ktp = $value->ktp;}
          if($value->tanggal_lahir == ''){$tanggal_lahir = '-';}else{$tanggal_lahir = $value->tanggal_lahir;}
          if($value->tempat_lahir == ''){$tempat_lahir = '-';}else{$tempat_lahir = $value->tempat_lahir;}
          if($value->email == ''){$email = '-';}else{$email = $value->email;}
          if($value->no_tlp == ''){$no_tlp = '-';}else{$no_tlp = $value->no_tlp;}
          if($value->rule == '1'){
            $rule = 'Admin';
          }else{
            $rule = 'User';
          }
          if ($value->jenis_kelamin == '1') {
            $jk = 'Laki-laki';
          }else{
            $jk = 'Perempuan';
          }
            $rec['aaData'][$k] = array(
                0 => 't|id||'.$i++,
                1 => 't|username|e|'.$username,
                2 => 't|nama|e|'.$nama,
                3 => 't|ktp|e|'.$ktp,
                4 => 't|jenis_kelamin|e|'.$jk,
                5 => 'd|tanggal_lahir|e|'.$tanggal_lahir,
                6 => 't|tempat_lahir|e|'.$tempat_lahir,
                7 => 'e|email|e|'.$email,
                8 => 't|no_tlp|e|'.$no_tlp,
                9 => 't|poin||'.$value->poin,
                10 => 't|rule||'.$rule,
                11 => 't|id||'.$value->id,
            );
            $k++;
            $start++;
        }

    }

    echo json_encode($rec);
  }

  function getDataGroup(){
    foreach ($this->MDataUser->getDataGroup()->result() as $value) {
      echo "<option value='".$value->id_group."'>".$value->nama_group."</option>";
    }
  }

  function change_status(){
    $id = $this->input->post('id');
    $val = $this->input->post('val');
    $res = $this->MDataUser->change_status($id,$val);
    if ($res !== false){
        echo 1;
    }else{ 
        echo $res;
    }
  }

  function change_publish(){
    $id = $this->input->post('id');
    $val = $this->input->post('val');
    $res = $this->MDataUser->change_publish($id,$val);
    if ($res !== false){
        echo 1;
    }else{ 
        echo $res;
    }
  }

  function delete_data(){
    $id = $this->input->post('id');
    $res = $this
                ->MDataUser
                ->delete_data($id);

    if ($res !== false){
        echo 1;
    }else{ 
        echo $res;
    }
  }

  function create_data(){
    if($this->MDataUser->cekUsername($this->input->post('username'))->num_rows() == null){
      $data = array(
        'nama' => $this->input->post('nama'),
        'ktp' => $this->input->post('ktp'),
        'jenis_kelamin' => $this->input->post('jenis_kelamin'),
        'tanggal_lahir' => $this->input->post('tanggal_lahir'),
        'tempat_lahir' => $this->input->post('tempat_lahir'),
        'email' => $this->input->post('email'),
        'no_tlp' => $this->input->post('no_tlp'),
        'username' => $this->input->post('username'),
        'password' => md5($this->input->post('password')),
        'rule' => $this->input->post('rule'),
      );
      $id_user = $this->MDataUser->create_data($data);
      $this->session->set_flashdata('sukses',true);
      $this->session->set_flashdata('pesanSukses','<h4><i class="fa fa-check"></i> Success !</h4><p>Users has been entered to the database successfully.</p>');
      redirect('DataUser','refresh');
    }else{
      $this->session->set_flashdata('gagal',true);
      $this->session->set_flashdata('pesanGagal','<h4><i class="fa fa-times"></i> Failed!</h4><p>Username is already exist.</p>');
      redirect('DataUser','refresh');
    }
  }

  function update_data(){
    $userId      = $_REQUEST['id'];
    $newValue   = $_REQUEST['newValue'];
    $colName    = $_REQUEST['colName'];

    if($newValue == ""){
        if($colName == "tanggal_lahir"){
            $newValue = "0000-00-00";
        }else{
            $newValue = "-";
        }
    }
    if($userId != '' && $newValue != '' && $colName != '')
    {
        $data = array(
            $colName => $newValue,
        );
        $this->db->where('id', $userId);
        if($this->db->update('user',$data))
        {   
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
  }

  public function editPassword(){
    if($this->input->post('repassword') == $this->input->post('password')){
      $this->MDataUser->editPassword($this->input->post('id'),'NOK1'.$this->input->post('password'));
      $this->session->set_flashdata('sukses',true);
      $this->session->set_flashdata('pesanSukses','<h4><i class="fa fa-check"></i> Success !</h4><p>Edit password '.$this->input->post('nama_user').' successfully.</p>');
      redirect('DataUser','refresh');
    }else{
      $this->session->set_flashdata('gagal',true);
      $this->session->set_flashdata('pesanGagal','<h4><i class="fa fa-times"></i> Failed!</h4><p>Edit password '.$this->input->post('nama_user').' does not match the confirm password.</p>');
      redirect('DataUser','refresh');
    }
  }

  public function modelEditPassword(){
    foreach ($this->MDataUser->getDataById($_POST['id'])->result() as $key) {
        $nama_user = $key->nama_user;
    }

    echo "<div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button>
            <h4 class='modal-title'>Edit Password ".$nama_user."</h4>
        </div>
        <div class='modal-body'>
          <form action='".base_url()."DataUser/editPassword' method='POST' enctype='multipart/form-data'>
          <input type='hidden' name='id' value='".$_POST['id']."'>
          <input type='hidden' name='nama_user' value='".$nama_user."'>
              <div class='form-group'>
                <label >New password</label>
                <p>
                  <input type='password' id='editPass' class='form-control input-sm' name='password' required placeholder='New password' required>
                </p>
                <p>
                  <input type='password' id='rePassEdit' class='form-control input-sm' name='repassword' required placeholder='Confirm new password' required>
                  <span class='help-block' style='color:red; display: none;' id='notMatchEdit'>* Password does not match the confirm password</span>
                </p>
              </div>
              
              <button type='' class='btn btn-sm' data-dismiss='modal'>Close</button>
              <button type='submit' class='btn btn-success btn-sm'>Save</button>
            </div>
          </form>
        </div>

        
        ";
  }

  public function editGroup(){
    if($this->MDataUser->cekDataUserInUserGroup($this->input->post('id'))->num_rows() == null){
      $this->MDataUser->addUserGroup($this->input->post('id'),$this->input->post('id_group'));
    }else{
      $this->MDataUser->editUserGroup($this->input->post('id'),$this->input->post('id_group'));
    }
    $this->session->set_flashdata('sukses',true);
    $this->session->set_flashdata('pesanSukses','<h4><i class="fa fa-check"></i> Success !</h4><p>Edit group '.$this->input->post('nama_user').' successfully.</p>');
    redirect('DataUser','refresh');
  }

  public function modelEditGroup(){
    foreach ($this->MDataUser->getDataById($_POST['id'])->result() as $key) {
        $nama_user = $key->nama_user;
    }

    foreach ($this->MDataUser->getDataUserGroupByIdUser($_POST['id'])->result() as $key) {
        $id_group = $key->id_group;
    }

    $select = "<select class='form-control input-sm' name='id_group' required>";
    foreach ($this->MDataUser->getDataGroup()->result() as $key) {
      if(isset($id_group)){
        if ($key->id_group == $id_group) {
          $select .= "<option value='".$key->id_group."' selected>".$key->nama_group."</option>";
        }else{
          $select .= "<option value='".$key->id_group."'>".$key->nama_group."</option>";
        }
      }else{
        $select .= "<option value='".$key->id_group."'>".$key->nama_group."</option>";
      }
    }
    $select .= "</select>";
    echo "<div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button>
            <h4 class='modal-title'>Edit Group ".$nama_user."</h4>
        </div>
        <div class='modal-body'>
          <form action='".base_url()."DataUser/editGroup' method='POST' enctype='multipart/form-data'>
          <input type='hidden' name='id' value='".$_POST['id']."'>
          <input type='hidden' name='nama_user' value='".$nama_user."'>
              <div class='form-group'>
                <label >Group</label>
                <p>
                  ".$select."
                </p>
              </div>
              
              <button type='' class='btn btn-sm' data-dismiss='modal'>Close</button>
              <button type='submit' class='btn btn-success btn-sm'>Save</button>
            </div>
          </form>
        </div>

        
        ";
  }

  function tanggal_indo($tanggal)
  {
    $bulan = array (1 =>   'Januari',
          'Februari',
          'Maret',
          'April',
          'Mei',
          'Juni',
          'Juli',
          'Agustus',
          'September',
          'Oktober',
          'November',
          'Desember'
        );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
  }
  
}