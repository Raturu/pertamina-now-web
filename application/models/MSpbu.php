<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MSpbu extends CI_Model {

		public function getAllPromoAktif(){
			return $this->db->query("SELECT *, k.nama as nama_kategori from spbu s, promo p, kategori_promo k where s.id=p.id_spbu and p.id_kategori_promo=k.id and waktu_mulai <= now() and waktu_selesai >= now()");
		}

		public function getAllPromoAktifByIdKategori($id_kategori){
			return $this->db->query("SELECT *, k.nama as nama_kategori from spbu s, promo p, kategori_promo k where s.id=p.id_spbu and p.id_kategori_promo=k.id and waktu_mulai <= now() and waktu_selesai >= now() and p.id_kategori_promo = '$id_kategori' ");
		}

		public function getKategori(){
			return $this->db->query("SELECT * from kategori_promo");
		}

		public function getTransaksiByIdUser($id_user){
			return $this->db->query("SELECT b.jenis, t.waktu_transaksi, t.total_pembelian, sb.harga, t.total_pembayaran, s.nama, s.alamat, s.kota, s.provinsi, s.latitude, s.longitude, t.id_promo from transaksi t, spbu_bbm sb, bbm b, spbu s where t.id_spbu_bbm=sb.id and sb.id_spbu=s.id and sb.id_bbm=b.id and t.id_user='$id_user'");
		}

		public function getPromoTransaksi($id){
			return $this->db->query("SELECT * from promo where id='$id'");
		}

		public function getBalanceByIdUser($id_user){
			$this->db->SELECT("saldo");
			$this->db->where('id',$id_user);
			$data = $this->db->get('user');
			foreach ($data->result() as $value) {
				return $value->saldo;
			}
		}

		public function getPointByIdUser($id_user){
			$this->db->SELECT("poin");
			$this->db->where('id',$id_user);
			$data = $this->db->get('user');
			foreach ($data->result() as $value) {
				return $value->poin;
			}
		}

	}