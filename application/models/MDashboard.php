<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MDashboard extends CI_Model {
	    public function getUserInTransaction(){
	    	$this->db->where("status_transaksi", 1);
	    	return $this->db->get("user");
	    }

	    public function bbmBuyed(){
	    	return $this->db->query("SELECT count(b.id) as count, b.jenis from transaksi t, spbu_bbm sb, bbm b where t.id_spbu_bbm=sb.id and sb.id_bbm=b.id group by b.jenis");
	    }
	}