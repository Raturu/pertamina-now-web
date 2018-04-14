<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MSpbu extends CI_Model {

		public function getAllPromoAktif(){
			return $this->db->query("SELECT * from spbu s, promo p where s.id=p.id_spbu and waktu_mulai <= now() and waktu_selesai >= now()");
		}

	}