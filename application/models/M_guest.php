<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_guest extends CI_Model {

	public $tb_place = 'tb_guestbook';
	public $tb_area = 'tb_guestbookarea';

	public function getAllPlaces()
	{
		$this->db->order_by('date', 'DESC');
		$place = $this->db->get($this->tb_place);
		return $place;
	}

	public function getOnePlace($id)
	{
		$this->db->where('id', $id);
		$place = $this->db->get($this->tb_place);
		return $place;
	}

	public function getAllAreas()
	{
		$this->db->order_by('date', 'DESC');
		$area = $this->db->get($this->tb_area);
		return $area;
	}

	public function getOneArea($id)
	{
		$this->db->where('id', $id);
		$area = $this->db->get($this->tb_area);
		return $area;
	}

	public function storePlace($data)
	{
		$this->db->insert($this->tb_place, $data);
		if ($this->db->affected_rows()) {
			return true;

		} else {
			return false;
		}
	}

	public function storeArea($data)
	{
		$this->db->insert($this->tb_area, $data);
		if ($this->db->affected_rows()) {
			return true;

		} else {
			return false;
		}
	}

	public function deletePlace($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tb_place);
		if ($this->db->affected_rows()) {
			return true;

		} else {
			return false;
		}
	}

	public function deleteArea($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tb_area);
		if ($this->db->affected_rows()) {
			return true;

		} else {
			return false;
		}
	}
}