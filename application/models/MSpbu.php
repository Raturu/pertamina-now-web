<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MSpbu extends CI_Model {

		public function getAllPromoAktif(){
			return $this->db->query("SELECT * from spbu s, promo p where s.id=p.id_spbu and waktu_mulai <= now() and waktu_selesai >= now()");
		}

		public function getTransaksiByIdUser($id_user){
			return $this->db->query("SELECT b.jenis, t.waktu_transaksi, t.total_pembelian, sb.harga, t.total_pembayaran, s.nama, s.alamat, s.kota, s.provinsi, s.latitude, s.longitude, t.id_promo from transaksi t, spbu_bbm sb, bbm b, spbu s where t.id_spbu_bbm=sb.id and sb.id_spbu=s.id and sb.id_bbm=b.id and t.id_user='$id_user'");
		}

		public function getPromoTransaksi($id){
			return $this->db->query("SELECT * from promo where id='$id'");
		}

	}