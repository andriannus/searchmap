<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	public $table = 'tb_user';

	public function index()
	{
		$query = $this->db->get($this->table);
		return $query;
	}

	public function view($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get($this->table);
		return $query;
	}
}