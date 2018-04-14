<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends CI_Controller {
  function __construct()
  {
    parent::__construct();
  	$this->load->model("MAuth");
  }
  function dateSerialToDateTime($date) {
      return ((($date > 25568) ? $date : 25569) * 86400) - ((70 * 365 + 19) * 86400);
  }
  function phpinfo(){
    phpinfo();
  }
  public function index($username = null) {
    /*$date = $this->dateSerialToDateTime(43046);
    echo $date."<br>";
    echo date('Y', $date)."-".date('m', $date)."-".date('d', $date);*/
    if($this->session->userdata('captcha') == ""){
      $data['captcha'] = $this->createCaptcha();
    }else{
      $data['captcha'] = $this->session->userdata('captcha');
    }
    
    if($username!=null){
      $data['username'] = $username;
    }
    $this->load->view('auth',$data);
  }

  public function createCaptcha(){
    $options = array(
      'img_path' => './capimg/',
      'img_url' => base_url('capimg'),
      'img_width' => '180',
      'img_height' => '40',
      'font_path'     => './system/fonts/texb.ttf',
      'font_size'     => 25,
      'word_length'   => 4,
      'expiration' => 7200
    );

    $cap = create_captcha($options);
    $this->session->set_userdata('keycode',md5($cap['word']));
    $this->session->set_userdata('captcha',$cap['image']);
    return $cap['image'];
  }

  public function successLogin($id,$nama,$username,$email){
    $this->session->unset_userdata('captcha');  
    $this->session->unset_userdata("usernameTemp");
    $this->session->unset_userdata("passwordTemp");
    $this->session->unset_userdata("captchaTemp"); 
    $data['id'] = $id;
    $data['nama'] = $nama;
    $data['username'] = $username;
    $data['email'] = $email;
    $this->session->set_userdata($data);
    redirect('Dashboard','refresh');
  }


  public function login(){
      $username = $this->input->post("username");
      $password = $this->input->post("password");
      $captcha = $this->input->post("captcha");
      $this->session->set_userdata("usernameTemp",$username);
      $this->session->set_userdata("passwordTemp",$password);
      $this->session->set_userdata("captchaTemp",$captcha);
      if(true){
        $data = $this->MAuth->cekData($username,$password);
        if($data->num_rows() != null){
          foreach ($data->result() as $value) {
            $email = $value->email;
            $id = $value->id;
            $nama = $value->nama;
          }
          $this->successLogin($id,$nama,$username,$email);
        }else{
          $this->session->set_flashdata('gagal',true);
          $this->session->set_flashdata('message',"The username you entered couldn't be found or your password was incorrect. <br> Please try again.");
          redirect('Auth','refresh');
        }
      }else{
        $this->session->set_flashdata('gagal',true);
        $this->session->set_flashdata('message','The answer you entered for the CAPTCHA was not correct.');
        redirect('Auth','refresh');
      }
  }

  public function checkCode(){
    $id = $this->input->post('id');
    $kode_verifikasi = $this->input->post('kode_verifikasi');
    $data = $this->MAuth->checkCodeUser($id,$kode_verifikasi);
    if($data->num_rows() != null){
      $this->MAuth->updateDateVerifikasi($id);
      $this->session->unset_userdata('idTemp');
      $this->session->unset_userdata('emailTemp');
      foreach ($data->result() as $value) {
        $nama = $value->nama;
        $username = $value->username;
        $password = $value->password;
        $email = $value->email;
      }
      $this->successLogin($id,$nama,$username,$password,$email);
    }else{
      $this->session->set_flashdata('verifikasi_gagal',true);
      redirect('Auth','refresh');
    }
  }

  public function checkCaptcha(){
    if(md5($this->input->post("captcha")) == $this->session->userdata("keycode")){
      return true;
    }else{
      return false;
    }
  }

  public function reCaptcha(){
    $this->session->unset_userdata('captcha');  
    redirect('Auth','refresh');
  }

  public function logout(){
    if(!empty($this->session->userdata('id'))){
      $dataSession = $this->session->all_userdata();
      $this->session->unset_userdata($dataSession['id']);
      $this->session->unset_userdata($dataSession['nama']);
      $this->session->unset_userdata($dataSession['username']);
      $this->session->unset_userdata($dataSession['email']);
      $this->session->sess_destroy();
    }
    redirect('Auth','refresh');
  }
  
}