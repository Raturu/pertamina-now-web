<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'core/Admin_Controller.php');
class Dashboard extends Admin_Controller {
  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('id') == ""){
      redirect('Auth');
    }
  	$this->load->model("MDashboard");
  }
  
  public function index() {
    $this->data['current_page'] = $this->uri->uri_string();
    $this->data['bbmBuyed'] = $this->MDashboard->bbmBuyed();
    $this->data['countBbmBuyed'] = $this->MDashboard->countBbmBuyed();
    $this->data['transactionSPBU'] = $this->MDashboard->transactionSPBU();
    $this->data['countTransactionSPBU'] = $this->MDashboard->countTransactionSPBU();
    $this->data['countActiveUser'] = $this->MDashboard->countActiveUser();
    $this->data['countAllUser'] = $this->MDashboard->countAllUser();
    $this->data['countAllTransactionCurrentMonth'] = $this->MDashboard->countAllTransactionCurrentMonth();
    $this->data['countLimitBBM'] = $this->MDashboard->countLimitBBM();

    $this->content = 'admin/dashboard';     
    $this->navigation = 'template_admin/_parts/navigation/admin_view'; 
    // passing middle to function. change this for different views.
    $this->data['page_title'] = 'Dashboard | Pertamina Now';
    $this->layout();
  }

  function daysInMonth($year, $month) {
    return date("t", mktime (0,0,0,$month,1,$year));
  }
  
  public function getIntransaction(){
    echo $this->MDashboard->getUserInTransaction()->num_rows();
  }

  public function modalLimitBBM(){
    $data = "";
    $i = 1;
    foreach ($this->MDashboard->limitBBM()->result() as $key) {
      $data .= "<tr><td>".$i."</td><td>".$key->nama_spbu."</td><td>".$key->nama_bbm."</td><td>".$key->level."</td><td>".$key->min_tank."</td></tr>";
      $i += 1;
    }

    echo "<div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button>
            <h4 class='modal-title'>Low Level Tank in SPBU</h4>
        </div>
        <div class='modal-body'>
          <table class='table'>
            <tr>
              <th>No</th>
              <th>SPBU Name</th>
              <th>BBM Name</th>
              <th>Level (liter)</th>
              <th>Min Tank</th>
            </tr>
            ".$data."
          </table>
        </div>

        
        ";
  }
}