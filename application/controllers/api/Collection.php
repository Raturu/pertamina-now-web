<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Collection extends REST_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model("MDataUser");
      $this->load->model("MAuth");
    }
    public function createUser_post(){
      $cekUsername = $this->MDataUser->cekUsername($this->post('username'));
      if($cekUsername->num_rows() == null){
        $data = array(
            'nama' => $this->post('nama'),
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
              'jenis_kelamin' => $this->post('jenis_kelamin'),
              'tanggal_lahir' => $this->post('tanggal_lahir'),
              'tempat_lahir' => $this->post('tempat_lahir'),
              'email' => $this->post('email'),
              'no_tlp' => $this->post('no_tlp'),
              'username' => $this->post('username'),
              'rule' => $this->post('rule'),
              'API_key' => $key_user
            ],
            REST_Controller::HTTP_OK
          );
        }else{
          $this->response(
            [
              "status" => false,
              'error' => $id_user['message']
            ], REST_Controller::HTTP_OK);
        }
      }else{
        $this->response(
            [
              "status" => false,
              'error' => "Username already exists"
            ], REST_Controller::HTTP_OK);
      }
    }
    public function getAllData_get(){
      $users = $this->MDataUser->getAllData()->result_array();
      $this->response($users, REST_Controller::HTTP_OK);
    }
    public function login_post(){
      $data = $this->MAuth->cekData($this->post('username'), $this->post('password'));
      if($data->num_rows() != null){
        foreach ($data->result() as $value) {
          $this->response(
            [
              'nama' => $value->nama,
              'ktp' => $value->ktp,
              'jenis_kelamin' => $value->jenis_kelamin,
              'tanggal_lahir' => $value->tanggal_lahir,
              'tempat_lahir' => $value->tempat_lahir,
              'email' => $value->email,
              'no_tlp' => $value->no_tlp,
              'username' => $value->username,
              'rule' => $value->rule,
              'saldo' => $value->saldo,
              'API_key' => $value->key_user
            ],
            REST_Controller::HTTP_OK
          );
        }
      }else{
        $data = $this->MDataUser->cekUsername($this->post('username'));
        if ($data->num_rows() == 0) {
          $this->response(
            [
              "status" => false,
              "error" => "Username not found"
            ],
            REST_Controller::HTTP_OK);
        }else{
          $this->response(
            [
              "status" => false,
              "error" => "Username and password do not match"
            ],
            REST_Controller::HTTP_OK);
        }
      }
    }
    public function checkKTP_post(){
      $data = $this->MDataUser->getKTP($this->post('id'));
      foreach ($data->result() as $value) {
        $ktp = $value->ktp;
      }
      if($ktp == ""){
        $this->response(
            [
              "status" => false,
              "error" => "KTP SN null"
            ],
            REST_Controller::HTTP_OK);
      }else{
        $this->response(
            [
              "status" => true,
              "message" => $ktp
            ],
            REST_Controller::HTTP_OK);
      }
    }
    public function inputKTP_post(){
      $data = $this->MDataUser->inputKTP($this->post('id'),$this->post('ktp'));
      if(is_array($data) == false){
        $this->response(
            [
              "status" => true,
              "message" => "KTN SN inputed successfully"
            ],
            REST_Controller::HTTP_OK);
      }else{
        $this->response(
            [
              "status" => false,
              "error" => $data['message']
            ],
            REST_Controller::HTTP_OK);
      }
    }
}