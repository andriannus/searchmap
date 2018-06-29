<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_guest extends CI_Model {

	public function getAll()
	{
		$this->db->order_by('date', 'DESC');
		$place = $this->db->get('tb_guestbook');
		return $place;
	}

	public function getOne($id)
	{
		$this->db->where('id', $id);
		$place = $this->db->get('tb_guestbook');
		return $place;
	}

	public function savePlace($data)
	{
		$this->db->insert('tb_guestbook', $data);
		if ($this->db->affected_rows()) {
			return true;

		} else {
			return false;
		}
	}
}