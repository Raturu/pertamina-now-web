<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MSpbubbm extends CI_Model {

		public function getSpbu(){
			$this->db->where('status', 1);
			return $this->db->get('spbu');
		}

		public function getSpbuById($id_spbu_bbm){
			$this->db->where('id', $id_spbu_bbm);
			return $this->db->get('spbu_bbm');
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

		public function editBBM($id_spbu_bbm,$id_bbm){
			$this->db->query("UPDATE spbu_bbm set id_bbm = '$id_bbm' where id = '$id_spbu_bbm' ");
		}


	}