<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {

	public $app = 'core/layouts/app';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_guest', 'guest');
	}

	public function index($id = false)
	{
		if ($id) {
			$place = $this->guest->getOnePlace($id)->row();

			if (!empty($place)) {
				$data = [
					'title' => $place->place . ' - Search Map',
					'page' => 'maps/view',
					'place' => $place
				];

				$this->load->view($this->app, $data);

			} else {
				redirect('404');
			}

		} else {
			$data = [
				'title' => 'Find Place what You Want - Search Map',
				'page' => 'maps/index'
			];

			$this->load->view($this->app, $data);
		}
	}

	public function all()
	{
		$data = [
			'title' => 'Find Place what You Want - Search Map',
			'page' => 'maps/all'
		];

		$this->load->view($this->app, $data);
	}
}
