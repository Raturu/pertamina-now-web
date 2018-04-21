<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core/Admin_Controller.php');
class Transaction extends Admin_Controller {
  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('id') == ""){
      redirect('Auth');
    }
  	$this->load->model("MTransaction");
  }
  
  public function index() {
    $this->data['current_page'] = $this->uri->uri_string();
    $this->content = 'admin/transaction';     
    $this->navigation = 'template_admin/_parts/navigation/admin_view'; 
    // passing middle to function. change this for different views.
    $this->data['page_title'] = 'Data Transaction | Pertamina Now';
    $this->layout();
  }

  public function get_data(){
    $start  = $_REQUEST['iDisplayStart'];
    $length = $_REQUEST['iDisplayLength'];
    $sSearch = $_REQUEST['sSearch'];

    $col = $_REQUEST['iSortCol_0'];
    $iter = 0;
    $arr = array($iter => 't.id', $iter+=1 => 'u.nama', $iter+=1 => 's.nama', $iter+=1 => 'b.jenis', $iter+=1 => 'p.judul', $iter+=1 => 'p.poin', $iter+=1 => 't.waktu_transaksi', $iter+=1 => 't.total_pembelian', $iter+=1 => 't.total_pembayaran');

    $sort_by = $arr[$col];
    $sort_type = $_REQUEST['sSortDir_0'];

        
    $qry = "select t.id, u.nama as nama_user, s.nama as nama_spbu, b.jenis as nama_bbm, p.judul, p.poin, t.waktu_transaksi, t.total_pembelian, t.total_pembayaran from transaksi t left join promo p on t.id_promo=p.id inner join user u on u.id=t.id_user inner join spbu_bbm sb on t.id_spbu_bbm=sb.id inner join spbu s on s.id=sb.id_spbu inner join bbm b on b.id=sb.id_bbm and (u.nama LIKE '%".$sSearch."%' or s.nama LIKE '%".$sSearch."%' or b.jenis LIKE '%".$sSearch."%' or p.judul LIKE '%".$sSearch."%' or p.poin LIKE '%".$sSearch."%' or t.waktu_transaksi LIKE '%".$sSearch."%' or t.total_pembelian LIKE '%".$sSearch."%' or t.total_pembayaran LIKE '%".$sSearch."%') ORDER BY ".$sort_by." ".$sort_type." LIMIT ".$start.", ".$length;
    $res = $this->db->query($qry);

    $qry = "select count(*) as count from transaksi t left join promo p on t.id_promo=p.id inner join user u on u.id=t.id_user inner join spbu_bbm sb on t.id_spbu_bbm=sb.id inner join spbu s on s.id=sb.id_spbu inner join bbm b on b.id=sb.id_bbm and (u.nama LIKE '%".$sSearch."%' or s.nama LIKE '%".$sSearch."%' or b.jenis LIKE '%".$sSearch."%' or p.judul LIKE '%".$sSearch."%' or p.poin LIKE '%".$sSearch."%' or t.waktu_transaksi LIKE '%".$sSearch."%' or t.total_pembelian LIKE '%".$sSearch."%' or t.total_pembayaran LIKE '%".$sSearch."%')";
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
            if($value->judul == ""){$judul = "-";}else{$judul = $value->judul;}
            if($value->poin == ""){$poin = "-";}else{$poin = $value->poin;}
            $rec['aaData'][$k] = array(
                $iterasi => 't|no||'.$i++,
                $iterasi+=1 => 't|nama_user||'.$value->nama_user,
                $iterasi+=1 => 't|nama_spbu||'.$value->nama_spbu,
                $iterasi+=1 => 't|nama_bbm|e|'.$value->nama_bbm,
                $iterasi+=1 => 't|judul||'.$judul,
                $iterasi+=1 => 't|poin||'.$poin,
                $iterasi+=1 => 't|waktu_transaksi||'.$value->waktu_transaksi,
                $iterasi+=1 => 't|total_pembelian||'.$value->total_pembelian,
                $iterasi+=1 => 't|total_pembayaran||'.$value->total_pembayaran,
                $iterasi+=1 => 't|id||'.$value->id
            );
            $k++;
            $start++;
        }
    }
    echo json_encode($rec);
  }
  
}