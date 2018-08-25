<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public $app = 'core/layouts/app';

	public function __construct()
	{
		parent::__construct();

		// Load model
		$this->load->model('M_auth', 'auth');
	}

	public function login()
	{
		$data = [
			'title' => 'Login - Search Map',
			'page' => 'sites/login'
		];

		$this->load->view($this->app, $data);
	}

	public function register()
	{
		$data = [
			'title' => 'Register - Search Map',
			'page' => 'sites/register'
		];

		$this->load->view($this->app, $data);
	}

	public function loginProcess()
	{
		//
	}

	public function registerProcess()
	{
		//
	}
}