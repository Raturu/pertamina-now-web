<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MBbm extends CI_Model {

		public function create_data($data){
			$this->db->insert('bbm',$data);
		}

		public function change_status($id,$status){
			$this->db->query("UPDATE bbm set status='$status' where id='$id'");
		}
	}