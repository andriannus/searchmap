<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pusher extends CI_Controller {

	public $pusher;

	public function __construct()
	{
		parent::__construct();
		$this->config();
	}

	// Konfigurasi Pusher
	public function config()
	{
		$options = [
			'cluster' => 'ap1',
			'useTLS' => true
		];

		// Silahkan ganti KEY_1, KEY_2, dan KEY_3
		// dengan KEY yang Anda dapat dari Pusher
		$this->pusher = new Pusher\Pusher(
			'KEY_1',
			'KEY_2',
			'KEY_3',
			$options
		);
	}

	// Trigger Tambah Tempat
	public function addPlace()
	{
		$result = $this->pusher->trigger('search-map', 'add-place', null);

		if (!$result) {
			$message = [
				'success' => false
			];

		} else {
			$message = [
				'success' => true
			];
		}

		$this->output->set_output(json_encode($message));
	}

	// Trigger Tambah Area
	public function addArea()
	{
		$result = $this->pusher->trigger('search-map', 'add-area', null);

		if (!$result) {
			$message = [
				'success' => false
			];

		} else {
			$message = [
				'success' => true
			];
		}

		$this->output->set_output(json_encode($message));
	}
}
