<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Draw Controller
|--------------------------------------------------------------------------
|
| Berhubungan dengan menggambar peta menggunakan bangun datar
|
*/

class Draw extends CI_Controller {

	/*
	| Membuat variabel yang menampung file layout
	|
	| Hal ini dilakukan untuk membuat fitur seperti template Blade pada Laravel
	| tetapi tidak sepenuhnya sama
	|
	*/
	public $app = 'core/layouts/app';

	public function __construct()
	{
		parent::__construct();

		// Load model
		$this->load->model('M_guest', 'guest');
	}

	/*
	|
	| Menampilkan map atau area tertentu
	| 
	| Parameter $id digunakan untuk menentukan aksi selanjutnya
	|
	*/
	public function index($id = false)
	{
		// Jika terdapat $id
		if ($id) {
			// Menjalankan function tertentu pada model
			$area = $this->guest->getOneArea($id)->row();

			// Jika $id ditemukan
			if (!empty($area)) {
				$data = [
					'title' => $area->name . ' - Search Map',
					'page' => 'draws/view',
					'area' => $area
				];

				$this->load->view($this->app, $data);

			// Jika $id tidak ditemukan
			} else {
				redirect('404');
			}

		// Jika tidak terdapat $id
		} else {
			$data = [
				'title' => 'Draw Your Area - Search Map',
				'page' => 'draws/index'
			];

			$this->load->view($this->app, $data);
		}
	}

	// Fitur ini belum dibuat
	public function all()
	{
		echo "All";
	}
}
