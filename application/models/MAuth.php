<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MAuth extends CI_Model {

		public function cekData($username,$password){
			$sql = "SELECT u.*, uk.key_user FROM user u, user_key uk WHERE u.id = uk.id_user and username = ? and password = ?";
			return $this->db->query($sql, array($username,md5($password)));
		}

	}