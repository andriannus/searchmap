<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="profile">
	<section class="hero is-light is-bold" style="margin: 52px 0 10px 0">
		<div class="hero-body">
			<div class="container wow slideInLeft" data-wow-duration="1s">
				<h1 class="title">
					<?= $user->name; ?>
				</h1>
				<p class="subtitle">
					<em>Describe your profile</em>
				</p>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="columns">
			<div class="column is-4 is-offset-4 has-text-centered">
				<div class="columns">
					<div class="column">
						<div class="box button-box">
							<p>
								<span class="is-size-1 has-text-danger">
									<i class="fas fa-map-marker-alt"></i>
								</span>
							</p>
							<small>My Places</small>
						</div>
					</div>

					<div class="column">
						<div class="box button-box">
							<p>
								<span class="is-size-1 has-text-success">
									<i class="fas fa-map"></i>
								</span>
							</p>
							<small>My Areas</small>
						</div>
					</div>
				</div>

				<div class="columns">
					<div class="column">
						<div class="box button-box">
							<p>
								<span class="is-size-1 has-text-dark">
									<i class="fas fa-user"></i>
								</span>
							</p>
							<small>Profile</small>
						</div>
					</div>

					<div class="column">
						<div class="box button-box">
							<p>
								<span class="is-size-1 has-text-primary">
									<i class="fas fa-bell"></i>
								</span>
							</p>
							<small>Notification</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
