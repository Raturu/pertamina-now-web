<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MSpbubbm extends CI_Model {

		public function getSpbu(){
			$this->db->where('status', 1);
			return $this->db->get('spbu');
		}

		public function getBbm(){
			$this->db->where('status', 1);
			return $this->db->get('bbm');
		}
		
		public function getBbmNotInSpbu($id_spbu){
			return $this->db->query("SELECT * from bbm where status = 1 and id not in(select id_bbm from spbu_bbm where id_spbu='$id_spbu')");
		}

		public function create_data($data){
			$this->db->insert('spbu_bbm',$data);
		}

		public function change_status($id,$status){
			$this->db->query("UPDATE spbu_bbm set status='$status' where id='$id'");
		}

	}