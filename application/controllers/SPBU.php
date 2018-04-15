<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core/Admin_Controller.php');
class SPBU extends Admin_Controller {
  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('id') == ""){
      redirect('Auth');
    }
  	$this->load->model("MSpbu");
  }
  
  public function index() {
    $this->data['current_page'] = $this->uri->uri_string();
    $this->content = 'admin/spbu';     
    $this->navigation = 'template_admin/_parts/navigation/admin_view'; 
    // passing middle to function. change this for different views.
    $this->data['page_title'] = 'Data SPBU | Pertamina Now';
    $this->layout();
  }

  public function get_data(){
    $start  = $_REQUEST['iDisplayStart'];
    $length = $_REQUEST['iDisplayLength'];
    $sSearch = $_REQUEST['sSearch'];

    $col = $_REQUEST['iSortCol_0'];
    $iter = 0;
    $arr = array($iter => 'id', $iter++ => 'no_spbu', $iter++ => 'nama', $iter++ => 'alamat', $iter++ => 'kota', $iter++ => 'provinsi', $iter++ => 'latitude', $iter++ => 'longitude');

    $sort_by = $arr[$col];
    $sort_type = $_REQUEST['sSortDir_0'];

        
    $qry = "select * from spbu s where (s.no_spbu LIKE '%".$sSearch."%' or s.nama LIKE '%".$sSearch."%' or s.alamat LIKE '%".$sSearch."%' or s.kota LIKE '%".$sSearch."%' or s.provinsi LIKE '%".$sSearch."%' or s.latitude LIKE '%".$sSearch."%' or s.longitude LIKE '%".$sSearch."%')  ORDER BY ".$sort_by." ".$sort_type." LIMIT ".$start.", ".$length;
    $res = $this->db->query($qry);

    $qry = "select count(s.id) as count from spbu s where (s.no_spbu LIKE '%".$sSearch."%' or s.nama LIKE '%".$sSearch."%' or s.alamat LIKE '%".$sSearch."%' or s.kota LIKE '%".$sSearch."%' or s.provinsi LIKE '%".$sSearch."%' or s.latitude LIKE '%".$sSearch."%' or s.longitude LIKE '%".$sSearch."%')";
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
                $iterasi => 't|id||'.$i++,
                $iterasi++ => 't|no_spbu|e|'.$value->id,
                $iterasi++ => 't|no_spbu|e|'.$value->no_spbu,
                $iterasi++ => 't|nama|e|'.$value->nama,
                $iterasi++ => 't|alamat|e|'.$value->alamat,
                $iterasi++ => 't|kota|e|'.$value->kota,
                $iterasi++ => 't|provinsi|e|'.$value->provinsi,
                $iterasi++ => 't|latitude|e|'.$value->latitude,
                $iterasi++ => 't|longitude|e|'.$value->longitude,
                $iterasi++ => 't|longitude|e|'.$value->id
            );
            $k++;
            $start++;
        }
    }
    echo json_encode($rec);
  }
  
}