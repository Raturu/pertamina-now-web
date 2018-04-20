<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MSpbubbm extends CI_Model {

		public function getSpbu(){
			return $this->db->get('spbu');
		}

		public function getBbm(){
			return $this->db->get('bbm');
		}
		

	}