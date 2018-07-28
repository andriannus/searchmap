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

				<div class="columns">
					<div class="column is-6 is-offset-3">
						<div class="columns">
							<div class="column">
								<a class="button is-large is-fullwidth wow zoomIn" href="<?= base_url('map') ?>" data-wow-duration="1s" data-wow-delay="1.2s">
									<span class="icon">
										<i class="fas fa-map-marker-alt"></i>
									</span>
									<span>Find Your Place Here</span>
								</a>
							</div>

							<div class="column">
								<a class="button is-large is-fullwidth wow zoomIn" href="<?= base_url('draw') ?>" data-wow-duration="1s" data-wow-delay="1.4s">
									<span class="icon">
										<i class="fas fa-pen"></i>
									</span>
									<span>Let's Draw a Map</span>
								</a>
							</div>
						</div>
					</div>
				</div>						
			</div>
		</div>
	</section>
</div>