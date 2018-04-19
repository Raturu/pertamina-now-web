<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MBbm extends CI_Model {

		public function create_data($data){
			$this->db->insert('bbm',$data);
		}
	}