<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_guest', 'guest');
	}

	public function index()
	{
		$data = [
			'title' => 'Buku Tamu - SearchMap',
			'navigation' => 'core/elements/navigation',
			'page' => 'guests/index'
		];

		$this->load->view('core/layouts/app', $data);
	}

	public function place()
	{
		$place = $this->guest->getAll()->result();

		return $this->output->set_status_header(200)
							->set_output(json_encode([
									'success' => true,
									'message' => 'Success get all recommend place',
									'data' => $place
								]));
	}

	public function view($id)
	{
		$place = $this->guest->getOne($id)->row();

		if ($place === null) {
			return $this->output->set_status_header(404)
								->set_output(json_encode([
										'success' => false,
										'message' => 'Not found'
									]));

		} else {
			return $this->output->set_status_header(200)
								->set_output(json_encode([
										'success' => true,
										'message' => 'Success get one place',
										'data' => $place
									]));
		}
	}

	public function store()
	{
		$name = $this->input->post('name');
		$place = $this->input->post('place');
		$address = $this->input->post('address');
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');

		$data = [
			'name' => $name,
			'place' => $place,
			'address' => $address,
			'lat' => $lat,
			'lng' => $lng
		];

		$result = $this->guest->savePlace($data);

		if (!$result) {
			return $this->output->set_status_header(500)
								->set_output(json_encode([
										'success' => false,
										'message' => 'Error'
									]));

		} else {
			return $this->output->set_status_header(201)
								->set_output(json_encode([
										'success' => true,
										'message' => 'Success save place'
									]));
		}
	}
}