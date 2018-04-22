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

	    public function countBbmBuyed(){
	    	$data =  $this->db->query("SELECT count(*) as count from transaksi t, spbu_bbm sb, bbm b where t.id_spbu_bbm=sb.id and sb.id_bbm=b.id");
	    	foreach ($data->result() as $value) {
	    		return $value->count;
	    	}
	    }

	    public function transactionSPBU(){
	    	return $this->db->query("SELECT count(s.id) as count, s.nama from transaksi t, spbu_bbm sb, spbu s where t.id_spbu_bbm=sb.id and sb.id_spbu=s.id group by s.nama limit 5");
	    }

	    public function countTransactionSPBU(){
	    	$data =  $this->db->query("SELECT count(*) as count from transaksi t, spbu_bbm sb, spbu s where t.id_spbu_bbm=sb.id and sb.id_spbu=s.id");
	    	foreach ($data->result() as $value) {
	    		return $value->count;
	    	}
	    }

	    public function countActiveUser(){
	    	$data =  $this->db->query("SELECT count(*) as count from user where ktp is not null");
	    	foreach ($data->result() as $value) {
	    		return $value->count;
	    	}
	    }

	    public function countAllUser(){
	    	$data =  $this->db->query("SELECT count(*) as count from user");
	    	foreach ($data->result() as $value) {
	    		return $value->count;
	    	}
	    }

	    public function countAllTransactionCurrentMonth(){
	    	$data =  $this->db->query("SELECT count(*) as count FROM `transaksi` WHERE month(waktu_transaksi) = month(now()) and year(waktu_transaksi) = year(now())");
	    	foreach ($data->result() as $value) {
	    		return $value->count;
	    	}
	    }

	    public function countLimitBBM(){
	    	$data =  $this->db->query("SELECT count(*) as count from spbu_bbm where level <= min_tank");
	    	foreach ($data->result() as $value) {
	    		return $value->count;
	    	}
	    }

	    public function limitBBM(){
	    	return $this->db->query("SELECT s.nama as nama_spbu, b.jenis as nama_bbm, sb.level, sb.min_tank from spbu_bbm sb, spbu s, bbm b where sb.id_spbu=s.id and sb.id_bbm=b.id and level <= min_tank");
	    }
	}