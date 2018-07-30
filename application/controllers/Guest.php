<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Guest Controller
|--------------------------------------------------------------------------
|
| Berhubungan dengan Guest Book
|
*/

class Guest extends CI_Controller {

	/*
	|
	| $app untuk menampung file layout
	| $nav untuk menampung file menu navigasi
	|
	*/
	public $app = 'core/layouts/app';
	public $nav = 'core/elements/navigation';

	public function __construct()
	{
		parent::__construct();

		// Load model
		$this->load->model('m_guest', 'guest');
	}

	// Halaman index
	public function index()
	{
		$data = [
			'title' => 'Guest Book - Search Map',
			'navigation' => $this->nav,
			'page' => 'guests/index'
		];

		$this->load->view($this->app, $data);
	}

	// Halaman Guest Book untuk area
	public function area()
	{
		$data = [
			'title' => 'Area | Guest Book - Search Map',
			'navigation' => $this->nav,
			'page' => 'guests/area'
		];

		$this->load->view($this->app, $data);
	}

	// Halaman Guest Book untuk tempat
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
