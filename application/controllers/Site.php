<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Site Controller
|--------------------------------------------------------------------------
|
| Default Controller
|
*/

class Site extends CI_Controller {

	// Menampung file layout
	public $app = 'core/layouts/app';

	// Menampilkan halaman awal
	public function index()
	{
		$data = [
			'title' => 'Welcome to Search Map',
			'navigation' => 'core/elements/navigation',
			'menu' => 'home',
			'page' => 'sites/index'
		];

		$this->load->view($this->app, $data);
	}

	public function my()
	{
		$data = [
			'title' => 'You Are Here Now - Search Map',
			'navigation' => 'core/elements/navigation',
			'menu' => 'my',
			'page' => 'sites/my'
		];

		$this->load->view($this->app, $data);
	}

	// Menampilkan halaman tidak ditemukan
	public function notFound()
	{
		$data = [
			'title' => 'Page Not Found - Search Map',
			'page' => 'sites/notfound'
		];

		$this->load->view($this->app, $data);
	}
}
