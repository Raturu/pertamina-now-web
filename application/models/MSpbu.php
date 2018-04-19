<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MSpbu extends CI_Model {

		public function getAllPromoAktif(){
			return $this->db->query("SELECT *, k.nama as nama_kategori from spbu s, promo p, kategori_promo k where s.id=p.id_spbu and s.status=1 and p.id_kategori_promo=k.id and waktu_mulai <= now() and waktu_selesai >= now()");
		}

		public function getAllPromoAktifByIdKategori($id_kategori){
			return $this->db->query("SELECT *, k.nama as nama_kategori from spbu s, promo p, kategori_promo k where s.id=p.id_spbu and p.id_kategori_promo=k.id and waktu_mulai <= now() and waktu_selesai >= now() and p.id_kategori_promo = '$id_kategori' ");
		}

		public function getKategori(){
			return $this->db->query("SELECT * from kategori_promo");
		}

		public function getPromoTransaksi($id){
			return $this->db->query("SELECT * from promo where id='$id'");
		}

		public function getNearSPBU($latitude, $longitude){
			return $this->db->query("SELECT *, ( 3959 * acos( cos( radians('$tatitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$tatitude') ) * sin( radians( latitude ) ) ) ) AS distance FROM spbu WHERE spbu.status=1 ORDER BY distance desc LIMIT 0 , 20;");
			// menggunakan desc brarti diurutkan paling jauh, dikarenakan array_push jadinya terbalik.
		}

		public function getListBBMByIdSPBU($id_spbu){
			return $this->db->query("SELECT s.id as id_spbu, s.nama, sb.id as id_spbu_bbm, sb.harga,b.id as id_bbm, b.jenis from spbu s, spbu_bbm sb, bbm b where s.id=sb.id_spbu and sb.id_bbm=b.id and s.id='$id_spbu'");
		}

		public function create_data($data){
			$this->db->insert('spbu',$data);
		}

		public function change_status($id,$status){
			$this->db->query("UPDATE spbu set status='$status' where id='$id'");
		}

	}