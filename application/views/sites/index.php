<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="app">
	<section class="hero is-light is-fullheight">
		<div class="hero-body">
			<div class="container has-text-centered">
				<h1 class="title wow zoomIn" data-wow-duration="1s" data-wow-delay="1s">
					Welcome to - <i class="fas fa-map"></i> Search Map
				</h1>

				<a class="button is-large wow zoomIn" href="<?= base_url('site/map') ?>" data-wow-duration="1s" data-wow-delay="1.2s">
					<span class="icon">
						<i class="fas fa-map-marker-alt"></i>
					</span>
					<span>Find Your Place Here</span>
				</a>
				<br><br>
				<a class="button is-large wow zoomIn" href="<?= base_url('site/drawmap') ?>" data-wow-duration="1s" data-wow-delay="1.4s">
					<span class="icon">
						<i class="fas fa-pen"></i>
					</span>
					<span>Let's Draw a Map</span>
				</a>
			</div>
		</div>
	</section>
</div>