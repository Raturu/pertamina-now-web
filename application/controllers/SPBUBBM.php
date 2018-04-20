<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core/Admin_Controller.php');
class SPBUBBM extends Admin_Controller {
  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('id') == ""){
      redirect('Auth');
    }
  	$this->load->model("MSpbubbm");
  }
  
  public function index() {
    $this->data['current_page'] = $this->uri->uri_string();
    $this->data['spbu'] = $this->MSpbubbm->getSpbu();
    $this->content = 'admin/spbubbm';     
    $this->navigation = 'template_admin/_parts/navigation/admin_view'; 
    // passing middle to function. change this for different views.
    $this->data['page_title'] = 'Data SPBU BBM | Pertamina Now';
    $this->layout();
  }

  public function get_data(){
    $start  = $_REQUEST['iDisplayStart'];
    $length = $_REQUEST['iDisplayLength'];
    $sSearch = $_REQUEST['sSearch'];

    $col = $_REQUEST['iSortCol_0'];
    $iter = 0;
    $arr = array($iter => 'id', $iter+=1 => 'nama_spbu', $iter+=1 => 'nama_bbm', $iter+=1 => 'level', $iter+=1 => 'max_tank', $iter+=1 => 'min_tank', $iter+=1 => 'harga');

    $sort_by = $arr[$col];
    $sort_type = $_REQUEST['sSortDir_0'];

        
    $qry = "select s.nama as nama_spbu, b.jenis as nama_bbm, sb.* from spbu s, spbu_bbm sb, bbm b where s.id=sb.id_spbu and sb.id_bbm=b.id and (s.nama LIKE '%".$sSearch."%' or b.jenis LIKE '%".$sSearch."%' or sb.level LIKE '%".$sSearch."%' or sb.max_tank LIKE '%".$sSearch."%'  or sb.min_tank LIKE '%".$sSearch."%' or sb.harga LIKE '%".$sSearch."%') ORDER BY ".$sort_by." ".$sort_type." LIMIT ".$start.", ".$length;
    $res = $this->db->query($qry);

    $qry = "select count(sb.id) as count from spbu s, spbu_bbm sb, bbm b where s.id=sb.id_spbu and sb.id_bbm=b.id and (s.nama LIKE '%".$sSearch."%' or b.jenis LIKE '%".$sSearch."%' or sb.level LIKE '%".$sSearch."%' or sb.max_tank LIKE '%".$sSearch."%'  or sb.min_tank LIKE '%".$sSearch."%' or sb.harga LIKE '%".$sSearch."%')";
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
            if($value->status == 1){$status = '<button class="btn btn-success btn-xs active-data"style="height:20px;" status="'.$value->status.'" rel="'.$value->id.'" data-name="'.$value->nama_spbu." ".$value->nama_bbm.'">Active</button>';}else{$status = '<button class="btn btn-danger btn-xs active-data"style="height:20px;" status="'.$value->status.'" rel="'.$value->id.'" data-name="'.$value->nama_spbu." ".$value->nama_bbm.'">Inactive</button>';}
            $rec['aaData'][$k] = array(
                $iterasi => 't|no||'.$i++,
                $iterasi+=1 => 't|nama_spbu||'.$value->nama_spbu,
                $iterasi+=1 => 't|nama_bbm||'.$value->nama_bbm,
                $iterasi+=1 => 't|level|e|'.$value->level,
                $iterasi+=1 => 't|max_tank|e|'.$value->max_tank,
                $iterasi+=1 => 't|min_tank|e|'.$value->min_tank,
                $iterasi+=1 => 't|harga|e|'.$value->harga,
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
        if($this->db->update('bbm',$data))
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
      $data = array(
        'id_spbu' => $this->input->post('id_spbu'),
        'id_bbm' => $this->input->post('id_bbm'),
        'level' => $this->input->post('level'),
        'max_tank' => $this->input->post('max_tank'),
        'min_tank' => $this->input->post('min_tank'),       
        'harga' => $this->input->post('harga')       
      );
      $this->MSpbubbm->create_data($data);
      $this->session->set_flashdata('sukses',true);
      $this->session->set_flashdata('pesanSukses','<h4><i class="fa fa-check"></i> Success !</h4><p>SPBU BBM has been entered to the database successfully.</p>');
      redirect('SPBUBBM','refresh');
  }

  function selectSPBU(){
    echo json_encode($this->MSpbubbm->getBbmNotInSpbu($this->input->post('id_spbu'))->result());
  }

  function change_status(){
    $id = $this->input->post('id');
    if($this->input->post('status') == 1){
        $status = 0;
    }else{
        $status = 1;
    }
    $res = $this->MSpbubbm->change_status($id,$status);

    if ($res !== false){
        echo 1;
    }else{ 
        echo $res;
    }
  }
  
}