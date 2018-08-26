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

	public function checkEmail()
	{
		$email = $this->input->post('email');

		$result = $this->auth->getEmail($email);

		if ($result->num_rows() > 0) {
			return $this->output
									->set_status_header(200)
									->set_output(json_encode([
											'status' => false,
											'message' => 'E-mail cannot be used'
										]));

		} else {
			return $this->output
									->set_status_header(200)
									->set_output(json_encode([
											'status' => true,
											'message' => 'E-mail can be used'
										]));
		}
	}

	public function checkUsername()
	{
		$username = $this->input->post('username');

		$result = $this->auth->getUsername($username);

		if ($result->num_rows() > 0) {
			return $this->output
									->set_status_header(200)
									->set_output(json_encode([
											'status' => false,
											'message' => 'Username cannot be used'
										]));

		} else {
			return $this->output
									->set_status_header(200)
									->set_output(json_encode([
											'status' => true,
											'message' => 'Username can be used'
										]));
		}
	}

	public function loginProcess()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$where = [
			'username' => $username,
			'password' => md5($password)
		];

		$result = $this->auth->view($where);

		if ($result->num_rows() == 0) {
			return $this->output
									->set_status_header(200)
									->set_output(json_encode([
											'success' => false,
											'message' => 'Incorrect username or password'
										]));

		} else {
			$user = $result->row();

			$data = [
				'name' => $user->name,
				'username' => $username,
				'login' => TRUE
			];

			$this->session->set_userdata($data);

			return $this->output
									->set_status_header(200)
									->set_output(json_encode([
											'success' => true,
											'message' => $user
										]));
		}
	}

	public function registerProcess()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$data = [
			'name' => $name,
			'email' => $email,
			'username' => $username,
			'password' => md5($password)
		];

		$result = $this->auth->store($data);

		if (!$result) {
			return $this->output
									->set_status_header(500)
									->set_output(json_encode([
											'success' => false,
											'message' => 'Error'
										]));

		} else {
			return $this->output
									->set_status_header(201)
									->set_output(json_encode([
											'success' => true,
											'message' => 'Account created'
										]));
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('site');
	}
}