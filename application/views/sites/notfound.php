<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="hero is-white is-fullheight" v-if="!areaFound">
	<div class="hero-body">
		<div class="container has-text-centered">
			<p class="title">Error 404</p>
			<p class="subtitle">- Page Not Found -</p>
			<p>
				<a class="button is-success" href="<?= base_url('site') ?>">
					<span class="icon">
						<i class="fas fa-home"></i>
					</span>
					<span>Home</span>
				</a>

				<a class="button is-info" href="<?= base_url('guest') ?>">
					<span class="icon">
						<i class="fas fa-book"></i>
					</span>
					<span>Guest Book</span>
				</a>
			</p>
		</div>
	</div>
</section>
