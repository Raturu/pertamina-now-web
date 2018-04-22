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
}