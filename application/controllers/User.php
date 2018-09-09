<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public $app = 'core/layouts/app';
	public $nav = 'core/elements/navigation';

	public function __construct()
	{
		parent::__construct();

		// Load model
		$this->load->model('M_user', 'user');
	}

	public function index()
	{
		$data = [
			'title' => 'Login - Search Map',
			'page' => 'sites/login'
		];

		$this->load->view($this->app, $data);
	}

	public function view($username)
	{
		$result = $this->user->view($username);

		if ($result->num_rows() == 0) {
			redirect('404');

		} else {
			$query = $result->row();

			$data = [
				'title' => $query->name . ' | Search Map',
				'navigation' => $this->nav,
				'page' => 'users/profile',
				'user' => $query
			];

			$this->load->view($this->app, $data);
		}
	}

	public function place($username)
	{
		$user = $this->user->view($username)->row();

		$data = [
			'title' => 'Reccomended Places by ' . $user->name . ' - Search Map',
			'navigation' => $this->nav,
			'page' => 'users/place',
			'user' => $user
		];

		$this->load->view($this->app, $data);
	}
}
