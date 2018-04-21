<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MDashboard extends CI_Model {
	    public function getUserInTransaction(){
	    	$this->db->where("status_transaksi", 1);
	    	return $this->db->get("user");
	    }
	}