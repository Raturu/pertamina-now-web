<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core/Admin_Controller.php');
class SPBUBBM extends Admin_Controller {
  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('id') == ""){
      redirect('Auth');
    }
  	$this->load->model("MBbm");
  }
  
  public function index() {
    $this->data['current_page'] = $this->uri->uri_string();
    $this->content = 'admin/bbm';     
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
    $arr = array($iter => 'id', $iter+=1 => 'jenis');

    $sort_by = $arr[$col];
    $sort_type = $_REQUEST['sSortDir_0'];

        
    $qry = "select * from bbm s where (s.jenis LIKE '%".$sSearch."%')  ORDER BY ".$sort_by." ".$sort_type." LIMIT ".$start.", ".$length;
    $res = $this->db->query($qry);

    $qry = "select count(s.id) as count from bbm s where (s.jenis LIKE '%".$sSearch."%')";
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
            $rec['aaData'][$k] = array(
                $iterasi => 't|no||'.$i++,
                $iterasi+=1 => 't|jenis|e|'.$value->jenis,
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
        'jenis' => $this->input->post('jenis')
      );
      $id_user = $this->MBbm->create_data($data);
      $this->session->set_flashdata('sukses',true);
      $this->session->set_flashdata('pesanSukses','<h4><i class="fa fa-check"></i> Success !</h4><p>BBM has been entered to the database successfully.</p>');
      redirect('BBM','refresh');
  }
  
}