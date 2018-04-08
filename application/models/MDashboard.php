<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MDashboard extends CI_Model {
	    
	    public function unfinishUser(){
	    	$sql = "SELECT sum(qtyso) as count, id_user_assign FROM sor_por_tracker WHERE id_user_assign != 'finish' and status=1 group by id_user_assign";
	    	return $this->db->query($sql);
	    }

	    public function finishMonth(){
	    	$sql = "SELECT sum(qtyso) as count, day(datetime) as day FROM sor_por_tracker WHERE id_user_assign = 'finish' and month(datetime)=month(now()) and year(datetime)=year(now()) and status=1 group by day(datetime)";
	    	return $this->db->query($sql);
	    }

	    public function finishYear(){
	    	$sql = "SELECT sum(qtyso) as count, month(datetime) as month FROM sor_por_tracker WHERE id_user_assign = 'finish' and year(datetime)=year(now()) and status = 1 group by month(datetime)";
	    	return $this->db->query($sql);
	    }
	}