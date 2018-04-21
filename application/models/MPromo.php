<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MPromo extends CI_Model {

		public function getPromoById($id){
			$this->db->where('id',$id);
			return $this->db->get('promo');
		}

		public function getDataKategori(){
			$this->db->where('status',1);
			return $this->db->get("kategori_promo");
		}

		public function change_status($id,$status){
			$this->db->query("UPDATE promo set status='$status' where id='$id'");
		}

		public function updatePictureUser($id_promo, $filename){
			$this->db->query("UPDATE promo set gambar='$filename' where id='$id_promo'");
		}

		public function getSPBU(){
			return $this->db->query("SELECT * from spbu where status =1 ");
		}

		public function create_data($data){
			$this->db->insert('promo',$data);
		}
	}