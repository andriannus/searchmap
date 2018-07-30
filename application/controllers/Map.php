<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Map Controller
|--------------------------------------------------------------------------
|
| Berhubungan dengan tempat (place)
|
*/

class Map extends CI_Controller {

	// Menampung file layout
	public $app = 'core/layouts/app';

	public function __construct()
	{
		parent::__construct();

		// Load model
		$this->load->model('M_guest', 'guest');
	}

	/*
	|
	| Menampilkan map atau tempat tertentu
	| 
	| Parameter $id digunakan untuk menentukan aksi selanjutnya
	|
	*/
	public function index($id = false)
	{
		// Jika terdapat $id
		if ($id) {
			// Menjalankan function tertentu pada model
			$place = $this->guest->getOnePlace($id)->row();

			// Jika $id ditemukan
			if (!empty($place)) {
				$data = [
					'title' => $place->place . ' - Search Map',
					'page' => 'maps/view',
					'place' => $place
				];

				$this->load->view($this->app, $data);

			// Jika $id tidak ditemukan
			} else {
				redirect('404');
			}

		// Jika tidak terdapat $id
		} else {
			$data = [
				'title' => 'Find Place what You Want - Search Map',
				'page' => 'maps/index'
			];

			$this->load->view($this->app, $data);
		}
	}

	// Menampilkan semua tempat yang sudah disimpan pada database
	public function all()
	{
		$data = [
			'title' => 'Find Place what You Want - Search Map',
			'page' => 'maps/all'
		];

		$this->load->view($this->app, $data);
	}
}
