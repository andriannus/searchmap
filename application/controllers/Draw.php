<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Draw extends CI_Controller {

	public $app = 'core/layouts/app';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_guest', 'guest');
	}

	public function index($id = false)
	{
		if ($id) {
			$area = $this->guest->getOneArea($id)->row();

			if (!empty($area)) {
				$data = [
					'title' => $area->name . ' - Search Map',
					'page' => 'draws/view',
					'area' => $area
				];

				$this->load->view($this->app, $data);

			} else {
				redirect('404');
			}

		} else {
			$data = [
				'title' => 'Draw Your Area - Search Map',
				'page' => 'draws/index'
			];

			$this->load->view($this->app, $data);
		}
	}

	public function all()
	{
		echo "All";
	}
}
