<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MDataUser extends CI_Model {

		public function create_data($data){
			if($this->db->insert('user',$data)){
				$id_user = $this->db->insert_id();
				$this->createAPIkey($id_user);
				return $id_user;	
			}else{
				return $this->db->error();
			}
		}

		public function createAPIkey($id){
			$key = $this->generateRandomString();
			$data = array(
				'id_user' => $id,
				'key_user' => $key,
				'level' => 0,
				'ignore_limits' => 0,
				'is_private_key' => 0,
				'ip_addresses' => NULL,
				'date_created' => date("Y-m-d h:i:s")
			);
			$this->db->insert('user_key',$data);
		}

		public function getAPIKeyById($id){
			$data = $this->db->query("SELECT key_user from user_key where id_user = '$id'");
			foreach ($data->result() as $value) {
				$key_user = $value->key_user;
			}
			return $key_user;
		}

		private function generateRandomString() {
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < 93; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}

		public function getAllData(){
			return $this->db->get('user');
		}

		public function getDataById($id){
			return $this->db->query("SELECT * FROM user WHERE id='$id'");
		}

		public function editPassword($id,$password){
			$sql = "UPDATE user set password = ?, date_update_verifikasi = NULL WHERE id = ?";
			$this->db->query($sql, array(md5("$password"),$id));
		}

		public function delete_data($id){
			$this->db->where('id',$id);
			$this->db->delete('user');
		}

		public function cekUsername($username){
			$sql = "SELECT * FROM user where username = ?";
			return $this->db->query($sql, array($username));
		}

	}