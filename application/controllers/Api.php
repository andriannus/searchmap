<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_guest', 'guest');
	}

	public function getAllPlaces()
	{
		$place = $this->guest->getAllPlaces()->result();

		return $this->output
					->set_status_header(200)
					->set_output(json_encode([
							'success' => true,
							'message' => 'Success get all recommend place',
							'data' => $place
						]));
	}

	public function getAllAreas()
	{
		$area = $this->guest->getAllAreas()->result();

		return $this->output
					->set_status_header(200)
					->set_output(json_encode([
							'success' => true,
							'message' => 'Success get all recommend area',
							'data' => $area
						]));
	}

	public function getOnePlace($id)
	{
		$place = $this->guest->getOnePlace($id)->row();

		if ($place === null) {
			return $this->output
						->set_status_header(404)
						->set_output(json_encode([
								'success' => false,
								'message' => 'Not found'
							]));

		} else {
			return $this->output
						->set_status_header(200)
						->set_output(json_encode([
								'success' => true,
								'message' => 'Success get one place',
								'data' => $place
							]));
		}
	}

	public function getOneArea($id)
	{
		$area = $this->guest->getOneArea($id)->row();

		if ($area === null) {
			return $this->output
						->set_status_header(404)
						->set_output(json_encode([
								'success' => false,
								'message' => 'Not found'
							]));

		} else {
			return $this->output
						->set_status_header(200)
						->set_output(json_encode([
								'success' => true,
								'message' => 'Success get one area',
								'data' => $area
							]));
		}
	}

	public function storePlace()
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

		$result = $this->guest->storePlace($data);

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
								'message' => 'Success save place'
							]));
		}
	}

	public function storeArea()
	{
		$name = $this->input->post('name');
		$area_name = $this->input->post('area_name');
		$area_type = $this->input->post('area_type');
		$area = $this->input->post('area');

		$data = [
			'name' => $name,
			'area_name' => $area_name,
			'area_type' => $area_type,
			'area' => $area
		];

		$result = $this->guest->storeArea($data);

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
								'message' => 'Success save place'
							]));
		}
	}

	public function destroyPlace($id)
	{
		$result = $this->guest->deletePlace($id);

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
								'message' => 'Success delete place'
							]));
		}
	}

	public function destroyArea($id)
	{
		$result = $this->guest->deleteArea($id);

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
								'message' => 'Success delete area'
							]));
		}
	}
}
