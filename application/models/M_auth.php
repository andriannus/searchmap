<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

	public $table = 'tb_user';

	public function getEmail($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get($this->table);
		return $query;
	}

	public function getUsername($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get($this->table);
		return $query;
	}

	public function view($where)
	{
		$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query;
	}
	
	public function store($data)
	{
		$this->db->insert($this->table, $data);

		if ($this->db->affected_rows()) {
			return true;

		} else {
			return false;
		}
	}
}