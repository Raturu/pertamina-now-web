<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MCategoryPromo extends CI_Model {

		public function create_data($data){
			$this->db->insert('kategori_promo',$data);
		}

		public function change_status($id,$status){
			$this->db->query("UPDATE kategori_promo set status='$status' where id='$id'");
		}
	}