<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="guest">
	<section class="hero is-light is-bold" style="margin: 52px 0 10px 0">
		<div class="hero-body">
			<div class="container wow slideInLeft" data-wow-duration="1s">
				<h1 class="title">
					Guest Book
					<i class="fas fa-book"></i>
				</h1>
				<p class="subtitle">Find Places or Areas from Guest</p>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="columns">
			<div class="column is-8 is-offset-2 has-text-centered">
				<p class="title wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
					Please Select the Guest Book Menus Below
				</p>

				<a href="<?= base_url('guest/place') ?>" class="button is-large wow zoomIn" data-wow-duration="1s" data-wow-delay="0.4s">
					<span class="icon">
						<i class="fas fa-map-marker-alt"></i>
					</span>
					<span>Place</span>
				</a>

				<a href="<?= base_url('guest/area') ?>" class="button is-large wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s">
					<span class="icon">
						<i class="fas fa-map"></i>
					</span>
					<span>Area</span>
				</a>
			</div>
		</div>
	</section>
</div>
