<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Collection extends REST_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model("MDataUser");
      $this->load->model("MAuth");
      $this->load->model("MSpbu");
      $this->load->library('nexmo');
      $this->nexmo->set_format('json');
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
              'poin' => 0,
              'API_key' => $key_user
            ],
            REST_Controller::HTTP_OK
          );
        }else{
          $this->response(
            [
              "status" => false,
              'error' => $id_user['message']
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
        $this->response(
            [
              "status" => false,
              'error' => "Username already exists"
            ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }

    public function updatePassword_post(){
      $this->checkExpiredKey();
      if($this->post('password') != ''){
        $id_user = $this->getIdFromKey();
        $this->MDataUser->editPassword($id_user,$this->post('password'));
        $this->response(
              [
                "status" => true,
                "message" => "Success update password"
              ],
              REST_Controller::HTTP_OK);
      }else{
        $this->response(
            [
              "status" => false,
              "error" => "POST password not found"
            ],
            REST_Controller::HTTP_NOT_FOUND);
      }
    }

    public function updateProfil_post(){
      $this->checkExpiredKey();
      $id_user = $this->getIdFromKey();
      $data = $this->MDataUser->getDataById($id_user);
      foreach ($data->result() as $value) {
        $usernameAwal = $value->username;
      }
      if($usernameAwal == $this->post('username')){
        $data = array(
            'nama' => $this->post('nama'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
            'tanggal_lahir' => $this->post('tanggal_lahir'),
            'tempat_lahir' => $this->post('tempat_lahir'),
            'email' => $this->post('email'),
            'no_tlp' => $this->post('no_tlp'),
            'username' => $this->post('username')
          );
        $this->MDataUser->updateProfil($id_user,$data);
        $this->response(
              [
                "status" => true,
                "message" => "Success update profile"
              ],
              REST_Controller::HTTP_OK);
      }else{
        if($this->MDataUser->cekUsername($this->post('username'))->num_rows() == null){
          $data = array(
              'nama' => $this->post('nama'),
              'jenis_kelamin' => $this->post('jenis_kelamin'),
              'tanggal_lahir' => $this->post('tanggal_lahir'),
              'tempat_lahir' => $this->post('tempat_lahir'),
              'email' => $this->post('email'),
              'no_tlp' => $this->post('no_tlp'),
              'username' => $this->post('username')
            );
          $this->MDataUser->updateProfil($id_user,$data);
          $this->response(
                [
                  "status" => true,
                  "message" => "Success update profile"
                ],
                REST_Controller::HTTP_OK);
        }else{
          $this->response(
              [
                "status" => false,
                "error" => "Username already exists"
              ],
              REST_Controller::HTTP_BAD_REQUEST);
        }
      }
    }

    public function getAllDataUser_get(){
      $this->checkExpiredKey();
      $users = $this->MDataUser->getAllData()->result_array();
      $this->response($users, REST_Controller::HTTP_OK);
    }

    public function login_post(){
      $data = $this->MAuth->cekData($this->post('username'), $this->post('password'));
      if($data->num_rows() != null){
        foreach ($data->result() as $value) {
          $this->checkExpiredKey($value->key_user);
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
            REST_Controller::HTTP_NOT_FOUND);
        }else{
          $this->response(
            [
              "status" => false,
              "error" => "Username and password do not match"
            ],
            REST_Controller::HTTP_BAD_REQUEST);
        }
      }
    }

    public function sendPhoneNumber_post(){
      $no_tlp = str_replace("+", "", $this->post('no_tlp'));
      $dataUser = $this->MDataUser->getUserByPhone($this->post('no_tlp'));
      if($dataUser->num_rows() != null){
        foreach ($dataUser->result() as $value) {
          $id_user = $value->id;
        }
        $key = $this->MDataUser->getAPIKeyById($id_user);
        $response = $this->nexmo->verify_request($no_tlp, "Pertamina Now");
        if($response['status'] == 0){
          $this->response(
            [
              "status" => true,
              "key" => $key,
              'request_id' => $response['request_id']
            ],
            REST_Controller::HTTP_OK);
        }else{
          $this->response(
            [
              "status" => false,
              'error' => $response['error_text']
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
        $data = array(
            'nama' => null,
            'jenis_kelamin' => null,
            'tanggal_lahir' => null,
            'tempat_lahir' => null,
            'email' => null,
            'no_tlp' => $this->post('no_tlp'),
            'username' => null,
            'password' => null,
            'rule' => 0
          );
        $id_user = $this->MDataUser->create_data($data);
        if(is_array($id_user) == false){
          $response = $this->nexmo->verify_request($no_tlp, "Pertamina Now");
          $key_user = $this->MDataUser->getAPIKeyById($id_user);
          if($response['status'] == 0){
            $this->response(
            [
              "status" => true,
              "key" => $key_user,
              'request_id' => $response['request_id']
            ],
            REST_Controller::HTTP_OK);
          }else{
            $this->response(
              [
                "status" => false,
                'error' => $response['error_text']
              ], REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $this->response(
            [
              "status" => false,
              'error' => $id_user['message']
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

      }
    }

    public function verifySmsCode_post(){
      $response = $this->nexmo->verify_check($this->post('request_id'), $this->post('code'));
      if($response['status'] == 0){
        $this->checkExpiredKey();
        $id_user = $this->getIdFromKey();
        $dataUser = $this->MDataUser->getDataById($id_user);
        $key_user = $this->MDataUser->getAPIKeyById($id_user);
        foreach ($dataUser->result() as $value) {
          $this->response(
              [
                'nama' => $value->nama,
                'ktp' => $value->ktp,
                'jenis_kelamin' => $value->jenis_kelamin,
                'tanggal_lahir' => $value->tanggal_lahir,
                'tempat_lahir' => $value->tempat_lahir,
                'email' => $value->email,
                'no_tlp' => $value->no_tlp,
                'saldo' => $value->saldo,
                'poin' => $value->poin,
                'API_key' => $key_user
              ],
              REST_Controller::HTTP_OK
            );
        }
      }else{
        $this->response(
            [
              "status" => false,
              'error' => $response['error_text']
            ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }

    public function checkKTP_get(){
      $this->checkExpiredKey();
      $id_user = $this->getIdFromKey();
      $data = $this->MDataUser->getDataById($id_user);
      foreach ($data->result() as $value) {
        $ktp = $value->ktp;
      }
      if($ktp == ""){
        $this->response(
            [
              "status" => false,
              "error" => "KTP SN null"
            ],
            REST_Controller::HTTP_NOT_FOUND);
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
      $this->checkExpiredKey();
      $id_user = $this->getIdFromKey();
      $data = $this->MDataUser->inputKTP($id_user,$this->post('ktp'));
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
            REST_Controller::HTTP_BAD_REQUEST);
      }
    }

    public function kategoriPromo_get(){
      $this->checkExpiredKey();
      $data = $this->MSpbu->getKategori();
      if ($data->num_rows() != null) {
        $result = array();
        foreach ($data->result() as $value) {
          $temp = array(
            'id' => $value->id,
            'nama' => $value->nama
          );
          array_push($result, $temp);
          unset($temp);
        }
        $this->response($result, REST_Controller::HTTP_OK);
      }else{
        $this->response(
            [
              "status" => false,
              "error" => "No category promo"
            ],
            REST_Controller::HTTP_NOT_FOUND);
      }
    }

    public function topUp_post(){
      $this->checkExpiredKey();
      $id_user = $this->getIdFromKey();
      $this->MDataUser->topUp($id_user, $this->post('amount'));
      $this->response(
            [
              "status" => true,
              "message" => "Success top up"
            ],
            REST_Controller::HTTP_OK);
    }

    public function nearbySPBU_post(){
      $this->checkExpiredKey();
      $data = $this->MSpbu->getNearSPBU($this->post('latitude'), $this->post('longitude'));
      $result = array();
      foreach ($data->result() as $value) {
        $temp = array(
          'id_spbu' => $value->id,
          'no_spbu' => $value->no_spbu,
          'nama_spbu' => $value->nama,
          'alamat_spbu' => $value->alamat,
          'kota_spbu' => $value->kota,
          'provinsi_spbu' => $value->provinsi,
          'latitude' => $value->latitude,
          'longitude' => $value->longitude
        );
        array_push($result, $temp);
        unset($temp);
      }
      $this->response($result,REST_Controller::HTTP_OK);
    }

    public function pointUser_get(){
      $this->checkExpiredKey();
      $id_user = $this->getIdFromKey();
      $point = $this->MDataUser->getPointByIdUser($id_user);
      $this->response(
          [
            "status" => true,
            "balance" => $point
          ],
          REST_Controller::HTTP_OK);
    }

    public function balance_get(){
      $this->checkExpiredKey();
      $id_user = $this->getIdFromKey();
      $balance = $this->MDataUser->getBalanceByIdUser($id_user);
      $this->response(
            [
              "status" => true,
              "balance" => $balance
            ],
            REST_Controller::HTTP_OK);
    }

    public function promoSPBU_post(){
      $this->checkExpiredKey();
      if('null' != $this->post('id_kategori')){
        $data = $this->MSpbu->getAllPromoAktifByIdKategori($this->post('id_kategori'));
      }else{
        $data = $this->MSpbu->getAllPromoAktif();
      }
      if($data->num_rows() != null){
        $result = array();
        foreach ($data->result() as $value) {
          $temp = array(
            'id_spbu' => $value->id_spbu,
            'no_spbu' => $value->no_spbu,
            'nama_spbu' => $value->nama,
            'alamat_spbu' => $value->alamat,
            'kota_spbu' => $value->kota,
            'provinsi_spbu' => $value->provinsi,
            'latitude' => $value->latitude,
            'longitude' => $value->longitude,
            'poin' => $value->poin,
            'jumlah_prmo' => $value->jumlah_promo,
            'used' => $value->used,
            'waktu_mulai' => $value->waktu_mulai,
            'waktu_selesai' => $value->waktu_selesai,
            'judul' => $value->judul,
            'deskripsi' => $value->deskripsi,
            'gambar' => base_url().'assets/dist/img/promo/'.$value->gambar,
            'kategori' => $value->nama_kategori
          );
          array_push($result, $temp);
          unset($temp);
        }
        $this->response($result, REST_Controller::HTTP_OK);
      }else{
        $this->response(
            [
              "status" => false,
              "error" => "No promo"
            ],
            REST_Controller::HTTP_NOT_FOUND);
      }
    }

    public function transaksi_get(){
      $this->checkExpiredKey();
      $id_user = $this->getIdFromKey();
      $dataTransaksi = $this->MDataUser->getTransaksiByIdUser($id_user);
      if($dataTransaksi->num_rows() != null){
        $result = array();
        foreach ($dataTransaksi->result() as $value) {
          if($value->id_promo != null){
            $dataPromo = $this->MSpbu->getPromoTransaksi($value->id_promo);
            foreach ($dataPromo->result() as $key) {
              $poin = $key->poin;
            }
          }else{
            $poin = 0;
          }
          $temp = array(
            'jenis_bbm' => $value->jenis,
            'waktu_transaksi' => $value->waktu_transaksi,
            'total_pembelian' => $value->total_pembelian,
            'harga' => $value->harga,
            'total_pembayaran' => $value->total_pembayaran,
            'nama_spbu' => $value->nama,
            'alamat_spbu' => $value->alamat,
            'kota_spbu' => $value->kota,
            'provinsi_spbu' => $value->provinsi,
            'latitude' => $value->latitude,
            'longitude' => $value->longitude,
            'poin' => $poin
          );
          
          array_push($result, $temp);
          unset($temp);
        }
        $this->response($result, REST_Controller::HTTP_OK);
      }else{
        $this->response(
            [
              "status" => false,
              "error" => "No transaction"
            ],
            REST_Controller::HTTP_NOT_FOUND);
      }
    }

    public function listBBM_post(){
      $data = $this->MSpbu->getListBBMByIdSPBU($this->post('id_spbu'));
      if ($data->num_rows() != null) {
        $result = array();
        foreach ($data->result() as $value) {
          $temp = array(
            'id_spbu' => $value->id_spbu,
            'id_bbm' => $value->id_bbm,
            'id_spbu_bbm' => $value->id_spbu_bbm,
            'harga' => $value->harga,
            'nama_bbm' => $value->jenis
          );
          array_push($result, $temp);
          unset($temp);
        }
        $this->response($result, REST_Controller::HTTP_OK);
      }else{
        $this->response(
            [
              "status" => false,
              "error" => "No bbm"
            ],
            REST_Controller::HTTP_NOT_FOUND);
      }
    }

    public function requestBuy_post(){
      $data = $this->MDataUser->getUserByKTP($this->post('uid'));
      if($data->num_rows() != null){
        foreach ($data->result() as $value) {
          if ($value->saldo == 0) {
            $this->response(
                [
                  "status"=>"NO_BALANCE",
                  "max_buy"=> 0
                ],
                REST_Controller::HTTP_OK);
          }
          if($value->status_transaksi == '1'){
            $this->response(
                [
                  "status"=> "ERROR",
                  "max_buy"=> 0
                ],
                REST_Controller::HTTP_OK);
          }
          if($this->post('free_mode') == 'TRUE'){
            $this->response(
                [
                  "status" => "OK",
                  "max_buy" => $value->saldo
                ],
                REST_Controller::HTTP_OK);
          }else{
            if($this->post('request_value') <= $value->saldo){
              $this->response(
                  [
                    "status" => "OK",
                    "max_buy" => $this->post('request_value')
                  ],
                  REST_Controller::HTTP_OK);
            }else{
              $this->response(
                  [
                      "status"=> "NO_BALANCE",
                      "max_buy"=> 0
                  ],
                  REST_Controller::HTTP_OK);
            }
          }          
        }
      }else{
        $this->response(
            [
              "status"=> "ERROR",
              "max_buy"=> 0
            ],
            REST_Controller::HTTP_OK);
      }
    }

    private function getIdFromKey(){
      $data = getallheaders();
      $key = base64_decode($data['x-api-key']);
      $temp = explode("*", $key);
      return $temp[0];
    }

    private function checkExpiredKey($key = null){
      if($key == null){
        $data = getallheaders();
        $data = $this->MDataUser->getUserKey($data['x-api-key']);
      }else{
        $data = $this->MDataUser->getUserKey($key);
      }
      foreach ($data->result() as $value) {
        $expired = $value->expired;
        $key1 = $value->key_user;
      }
      if(strtotime($expired) < strtotime(date("Y-m-d h:i:s"))){
        $this->response(
            [
              "status" => false,
              "error" => "Key expired"
            ],
            REST_Controller::HTTP_FORBIDDEN);
      }
    }

    public function renewKey_post(){
      $data = getallheaders();
      $this->MDataUser->renewKey($data['x-api-key']);
      $this->response(
            [
              "status" => true,
              "message" => "Success renewals"
            ],
            REST_Controller::HTTP_OK);
    }
}