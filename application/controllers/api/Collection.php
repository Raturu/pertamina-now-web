<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Collection extends REST_Controller {
  function __construct()
  {
    parent::__construct();
  	$this->load->model("MDataUser");
  }

  public function createUser_post(){
    $data = array(
        'nama' => $this->post('nama'),
        'ktp' => $this->post('ktp'),
        'jenis_kelamin' => $this->post('jenis_kelamin'),
        'tanggal_lahir' => $this->post('tanggal_lahir'),
        'tempat_lahir' => $this->post('tempat_lahir'),
        'email' => $this->post('email'),
        'no_tlp' => $this->post('no_tlp'),
        'username' => $this->post('username'),
        'password' => md5($this->post('password')),
        'rule' => $this->post('rule')
      );
    $id_user = $this->MDataUser->create_data($data);
    if(is_array($id_user) == false){
      unset($data);
      $data = $this->MDataUser->getDataById($id_user);
      $key_user = $this->MDataUser->getAPIKeyById($id_user);
      $this->response(
        [
          'nama' => $this->post('nama'),
          'ktp' => $this->post('ktp'),
          'jenis_kelamin' => $this->post('jenis_kelamin'),
          'tanggal_lahir' => $this->post('tanggal_lahir'),
          'tempat_lahir' => $this->post('tempat_lahir'),
          'email' => $this->post('email'),
          'no_tlp' => $this->post('no_tlp'),
          'username' => $this->post('username'),
          'password' => md5($this->post('password')),
          'rule' => $this->post('rule'),
          'API_key' => $key_user
        ],
        REST_Controller::HTTP_OK
      );
    }else{
      $this->response(
        [
          'error' => $id_user['message']
        ], REST_Controller::HTTP_BAD_REQUEST);
    }
  }

  public function getAllData_get(){
    $users = $this->MDataUser->getAllData()->result_array();
    $this->response($users, REST_Controller::HTTP_OK);
  }
}