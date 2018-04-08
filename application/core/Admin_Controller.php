<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_Controller extends CI_Controller 
 { 
   //set the class variable.
   var $template  = array();
   var $data      = array();
   //Load layout    
   public function layout() {
     // making temlate and send data to view.
     $this->template['head']   = $this->load->view('template_admin/_parts/head_view', $this->data, true);
     $this->template['navigation']   = $this->load->view($this->navigation, $this->data, true);
     
     $this->template['content'] = $this->load->view($this->content, $this->data, true);
     $this->template['footer'] = $this->load->view('template_admin/_parts/footer_view', $this->data, true);
     $this->template['foot'] = $this->load->view('template_admin/_parts/foot_view', $this->data, true);
     $this->load->view('template_admin/template_view', $this->template);
   }
}