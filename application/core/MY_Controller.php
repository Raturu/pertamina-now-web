<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller 
{ 
  function __construct()
  {
    parent::__construct();
  }
   //set the class variable.
  var $template  = array();
  var $data      = array();
   //Load layout    
  public function layout() {
     // making temlate and send data to view.
     // making temlate and send data to view.
   $this->template['head']   = $this->load->view('template/_parts/header_view', $this->data, true);
   $this->template['navigation']   = $this->load->view($this->navigation, $this->data, true);
   $this->template['content'] = $this->load->view($this->content, $this->data, true);
   $this->template['footer'] = $this->load->view('template/_parts/footer_view', $this->data, true);
   $this->template['foot'] = $this->load->view('template/_parts/foot_view', $this->data, true);
   $this->load->view('template/template_view', $this->template);
 }
}