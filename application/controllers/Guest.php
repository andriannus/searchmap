<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest extends CI_Controller {

	public $app = 'core/layouts/app';
	public $nav = 'core/elements/navigation';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_guest', 'guest');
	}

	public function index()
	{
		$data = [
			'title' => 'Guest Book - Search Map',
			'navigation' => $this->nav,
			'page' => 'guests/index'
		];

		$this->load->view($this->app, $data);
	}

	public function area()
	{
		$data = [
			'title' => 'Area | Guest Book - Search Map',
			'navigation' => $this->nav,
			'page' => 'guests/area'
		];

		$this->load->view($this->app, $data);
	}

	public function place()
	{
		$data = [
			'title' => 'Place | Guest Book - Search Map',
			'navigation' => $this->nav,
			'page' => 'guests/place'
		];

		$this->load->view($this->app, $data);
	}
}
