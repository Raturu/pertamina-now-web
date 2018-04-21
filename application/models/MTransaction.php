<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MTransaction extends CI_Model {
		public function addTransaction($data) {
			$this->db->insert('transaksi',$data);
		}
	}