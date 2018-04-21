<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core/Admin_Controller.php');
class Promo extends Admin_Controller {
  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('id') == ""){
      redirect('Auth');
    }
    $this->load->model("MPromo");
  }
  
  public function index() {
    $this->data['current_page'] = $this->uri->uri_string();
    $this->data['kategori']  = $this->MPromo->getDataKategori();
    $this->data['spbu'] = $this->MPromo->getSPBU();
    $this->content = 'admin/promo';     
    $this->navigation = 'template_admin/_parts/navigation/admin_view'; 
    // passing middle to function. change this for different views.
    $this->data['page_title'] = 'Data Promo | Pertamina Now';
    $this->layout();
  }

  public function get_data(){
    $start  = $_REQUEST['iDisplayStart'];
    $length = $_REQUEST['iDisplayLength'];
    $sSearch = $_REQUEST['sSearch'];

    $col = $_REQUEST['iSortCol_0'];
    $iter = 0;
    $arr = array($iter => 'id', $iter+=1 => 'judul', $iter+=1 => 'nama_kategori', $iter+=1 => 'nama_spbu', $iter+=1 => 'deskripsi', $iter+=1 => 'poin', $iter+=1 => 'jumlah_promo', $iter+=1 => 'used', $iter+=1 => 'waktu_mulai', $iter+=1 => 'waktu_selesai', $iter+=1 => 'gambar', $iter+=1 => 'status');

    $sort_by = $arr[$col];
    $sort_type = $_REQUEST['sSortDir_0'];

        
    $qry = "select p.*, k.nama as nama_kategori, s.nama as nama_spbu from promo p, kategori_promo k, spbu s where p.id_kategori_promo=k.id and s.id=p.id_spbu and (k.nama LIKE '%".$sSearch."%' or s.nama LIKE '%".$sSearch."%' or p.poin LIKE '%".$sSearch."%' or p.jumlah_promo LIKE '%".$sSearch."%' or p.used LIKE '%".$sSearch."%' or p.waktu_mulai LIKE '%".$sSearch."%' or p.waktu_selesai LIKE '%".$sSearch."%' or p.judul LIKE '%".$sSearch."%' or p.deskripsi LIKE '%".$sSearch."%' or p.gambar LIKE '%".$sSearch."%') ORDER BY ".$sort_by." ".$sort_type." LIMIT ".$start.", ".$length;
    $res = $this->db->query($qry);

    $qry = "select count(p.id) as count from promo p, kategori_promo k, spbu s where p.id_kategori_promo=k.id and s.id=p.id_spbu and (k.nama LIKE '%".$sSearch."%' or s.nama LIKE '%".$sSearch."%' or p.poin LIKE '%".$sSearch."%' or p.jumlah_promo LIKE '%".$sSearch."%' or p.used LIKE '%".$sSearch."%' or p.waktu_mulai LIKE '%".$sSearch."%' or p.waktu_selesai LIKE '%".$sSearch."%' or p.judul LIKE '%".$sSearch."%' or p.deskripsi LIKE '%".$sSearch."%' or p.gambar LIKE '%".$sSearch."%')";
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
            $iterasi = 0;
            $buttonEditPicture = '<button class="btn btn-primary btn-xs edit-picture" data-id="'.$value->id.'"><i class="fa fa-pencil"></i></button>';
            if($value->status == 1){$status = '<button class="btn btn-success btn-xs active-data"style="height:20px;" status="'.$value->status.'" rel="'.$value->id.'" data-name="'.$value->judul.'">Active</button>';}else{$status = '<button class="btn btn-danger btn-xs active-data"style="height:20px;" status="'.$value->status.'" rel="'.$value->id.'" data-name="'.$value->judul.'">Inactive</button>';}
            $rec['aaData'][$k] = array(
                $iterasi => 't|no||'.$i++,
                $iterasi+=1 => 't|judul|e|'.$value->judul,
                $iterasi+=1 => 'sk|id_kategori_promo|e|'.$value->nama_kategori,
                $iterasi+=1 => 't|spbu||'.$value->nama_spbu,
                $iterasi+=1 => 't|deskripsi|e|'.$value->deskripsi,
                $iterasi+=1 => 'n|poin|e|'.$value->poin,
                $iterasi+=1 => 'n|jumlah_promo|e|'.$value->jumlah_promo,
                $iterasi+=1 => 'n|used||'.$value->used,
                $iterasi+=1 => 'd|waktu_mulai|e|'.$value->waktu_mulai,
                $iterasi+=1 => 'd|waktu_selesai|e|'.$value->waktu_selesai,
                $iterasi+=1 => 't|gambar||'.$buttonEditPicture.' '.$value->gambar,
                $iterasi+=1 => 't|status|'.$value->status.'|'.$status,
                $iterasi+=1 => 't|id||'.$value->id
            );
            $k++;
            $start++;
        }
    }
    echo json_encode($rec);
  }

  function update_data(){
    $userId      = $_REQUEST['id'];
    $newValue   = $_REQUEST['newValue'];
    $colName    = $_REQUEST['colName'];

    if($newValue == ""){
        $newValue = "-";
    }

    if($userId != '' && $newValue != '' && $colName != '')
    {
        $data = array(
            $colName => $newValue,
        );
        $this->db->where('id', $userId);
        if($this->db->update('promo',$data))
        {   
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
  }

  function create_data(){
    $result = $this->uploadPicture($this->input->post('userfile'));
    if($result){
      $dataUpload = $this->upload->data();
      $data = array(
        'judul' => $this->input->post('judul'),
        'id_kategori_promo' => $this->input->post('id_kategori_promo'),
        'id_spbu' => $this->input->post('id_spbu'),
        'deskripsi' => $this->input->post('diskripsi'),
        'poin' => $this->input->post('poin'),       
        'jumlah_promo' => $this->input->post('jumlah_promo'),       
        'used' => 0,       
        'waktu_mulai' => str_replace("T", " ", $this->input->post('waktu_mulai')),       
        'waktu_selesai' => str_replace("T", " ", $this->input->post('waktu_selesai')), 
        'gambar' => $dataUpload['file_name'],   
        'status' => 1  
      );
      $this->MPromo->create_data($data);
      $this->session->set_flashdata('sukses',true);
      $this->session->set_flashdata('pesanSukses','<h4><i class="fa fa-check"></i> Success !</h4><p>Promo has been entered to the database successfully.</p>');
      redirect('Promo','refresh');
    }else{
      $this->session->set_flashdata('gagal',true);
      $this->session->set_flashdata('pesanGagal','<h4><i class="fa fa-times"></i> Failed !</h4><p>'.$this->upload->display_errors().'</p>');
      redirect('Promo','refresh');
    } 
  }

  function selectSPBU(){
    echo json_encode($this->MPromo->getBbmNotInSpbu($this->input->post('id_spbu'))->result());
  }

  function change_status(){
    $id = $this->input->post('id');
    if($this->input->post('status') == 1){
        $status = 0;
    }else{
        $status = 1;
    }
    $res = $this->MPromo->change_status($id,$status);

    if ($res !== false){
        echo 1;
    }else{ 
        echo $res;
    }
  }

  function replaceString($method, $string){
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%22');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "#", "[", "]"," ");
    if($method == 'decode'){
      return str_replace($entities, $replacements, $string);
    }else if($method == 'encode'){
      return str_replace($replacements, $entities, $string);
    }
  }

  function getDataKategori(){
    $oldValue1 = $this->replaceString('decode',$this->uri->segment(3));
    foreach ($this->MPromo->getDataKategori()->result() as $value) {
      if($oldValue1 == $value->nama){
        echo "<option value='".$value->id."' selected>".$value->nama."</option>";  
      }else{
        echo "<option value='".$value->id."'>".$value->nama."</option>";  
      }
    }
  }

  public function uploadPicture($userfile){
    $config['upload_path'] = './assets/dist/img/promo/';
    $config['allowed_types'] = 'jpeg|jpg|png';
    $config['max_size'] = '1000';
    $config['max_width']  = '512';
    $config['max_height']  = '512';
 
    $this->load->library('upload', $config);
    
    if ( ! $this->upload->do_upload()){
      return false;
    }else{
      return true;
    }
  }

  function editPicutre(){
    $result = $this->uploadPicture($this->input->post('userfile'));
    if($result == true){
      $foto = $this->upload->data();
      $gambar = $this->input->post('gambar');
      unlink("./assets/dist/img/promo/$gambar");
      $this->MPromo->updatePictureUser($this->input->post('id_promo'), $foto['file_name']);
      $this->session->set_flashdata('sukses',true);
      $this->session->set_flashdata('pesanSukses','<h4><i class="fa fa-check"></i> Success !</h4><p>Picture has been entered to the database successfully.</p>');
      redirect('Promo','refresh');
    }else{
      $this->session->set_flashdata('gagal',true);
      $this->session->set_flashdata('pesanGagal','<h4><i class="fa fa-times"></i> Failed !</h4><p>'.$this->upload->display_errors().'</p>');
      redirect('Promo','refresh');
      
    }
  }

  function modelEditPicture(){
    $data = $this->MPromo->getPromoById($_POST['id']);
    foreach ($data->result() as $value) {
      $nama = $value->judul;
      $gambar = $value->gambar;
    }
    echo "<div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button>
            <h4 class='modal-title'>Promo Picture ".$nama."</h4>
        </div>
        <div class='modal-body'>
          <form action='".base_url()."Promo/editPicutre' method='POST' enctype='multipart/form-data'>
          <input type='hidden' name='id_promo' value='".$_POST['id']."'>
          <input type='hidden' name='gambar' value='".$gambar."'>
              <center><img src='".base_url()."assets/dist/img/promo/".$gambar."' class='img-responsive' height='42' width='30%'></center>
              <div class='form-group'>
                <label >Picture</label>
                <p>
                  <input type='file' class='form-control input-sm' name='userfile' required>
                </p>
              </div>
              <button type='' class='btn btn-sm' data-dismiss='modal'>Close</button>
              <button type='submit' class='btn btn-success btn-sm'>Save</button>
            </div>
          </form>
        </div>        
        ";
  }
  
}