<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public $app = 'core/layouts/app';

	public function index()
	{
		$data = [
			'title' => 'Welcome to Search Map',
			'navigation' => 'core/elements/navigation',
			'page' => 'sites/index'
		];

		$this->load->view($this->app, $data);
	}

	public function map()
	{
		$data = [
			'title' => 'Find Place what You Want - Search Map',
			'page' => 'sites/map'
		];

		$this->load->view($this->app, $data);
	}

	public function drawMap()
	{
		$data = [
			'title' => 'Draw Your Area - Search Map',
			'page' => 'sites/drawmap'
		];

		$this->load->view($this->app, $data);
	}

	public function notFound()
	{
		$data = [
			'title' => 'Page Not Found - Search Map',
			'page' => 'sites/notfound'
		];

		$this->load->view($this->app, $data);
	}
}
