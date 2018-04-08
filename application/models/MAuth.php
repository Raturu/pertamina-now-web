<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MAuth extends CI_Model {

		public function cekData($username,$password){
			$sql = "SELECT * FROM user WHERE username = ? and password = ?";
			return $this->db->query($sql, array($username,md5($password)));
		}

	}