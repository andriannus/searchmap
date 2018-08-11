<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="app">
	<section class="hero is-dark is-bold is-large">
		<div class="hero-body">
			<div class="container has-text-centered">
				<h1 class="title wow zoomIn" data-wow-duration="1s">
					Welcome To
				</h1>
				<h2 class="subtitle wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
					<i class="fas fa-map"></i> Search Map
				</h2>
			</div>
		</div>
	</section>

	<section class="hero is-medium">
		<div class="hero-body">
			<div class="container">
				<div class="has-text-centered wow zoomIn" data-wow-duration="1s">
					<p class="title">
						Menus
					</p>
					<p class="subtitle">
						Which One Do You Choose
					</p>
				</div>

				<br>

				<div class="columns">
					<div class="column is-10 is-offset-1">
						<div class="columns">
							<div class="column wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
								<div class="box">
									<div class="media">
										<div class="media-left">
											<span class="icon">
												<i class="fas fa-crosshairs is-size-4 has-text-link"></i>
											</span>
										</div>

										<div class="media-content">
											<div class="content">
												<p>
													<strong>Loc</strong>
												</p>
												<p>
													Where am I?
												</p>
												<a class="button is-link" href="<?= base_url('my') ?>">
													<span>Click Here</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="column wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
								<div class="box">
									<div class="media">
										<div class="media-left">
											<span class="icon">
												<i class="fas fa-map-marker-alt is-size-4 has-text-danger"></i>
											</span>
										</div>

										<div class="media-content">
											<div class="content">
												<p>
													<strong>Map</strong>
												</p>
												<p>
													Find Your Place...
												</p>
												<a class="button is-danger" href="<?= base_url('map') ?>">
													<span>Click Here</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="column wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">
								<div class="box">
									<div class="media">
										<div class="media-left">
											<span class="icon">
												<i class="fas fa-pen is-size-4 has-text-success"></i>
											</span>
										</div>

										<div class="media-content">
											<div class="content">
												<p>
													<strong>Draw</strong>
												</p>
												<p>
													Let's Draw a Map...
												</p>
												<a class="button is-success" href="<?= base_url('draw') ?>">
													<span>Click Here</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="column wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.8s">
								<div class="box">
									<div class="media">
										<div class="media-left">
											<span class="icon">
												<i class="fas fa-book is-size-4 has-text-primary"></i>
											</span>
										</div>

										<div class="media-content">
											<div class="content">
												<p>
													<strong>Guest</strong>
												</p>
												<p>
													Guest Book Here...
												</p>
												<a class="button is-primary" href="<?= base_url('guest') ?>">
													<span>Click Here</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<footer class="footer">
		<div class="content">
			<div class="columns">
				<div class="column">
					<p class="subtitle">
						<strong>Search Map</strong> by <a href="https://www.linkedin.com/in/andriannus">Andre Simamora</a>
					</p>
					<p>
						Find places and Draw on Map using Google Maps API
					</p>
					<div class="buttons">
						<a class="button is-dark" href="https://facebook.com/andriannus.p">
							<span class="icon">
								<i class="fab fa-facebook"></i>
							</span>
						</a>

						<a class="button is-dark" href="https://instagram.com/andriannus">
							<span class="icon">
								<i class="fab fa-instagram"></i>
							</span>
						</a>

						<a class="button is-dark" href="https://twitter.com/andriannus">
							<span class="icon">
								<i class="fab fa-twitter"></i>
							</span>
						</a>
					</div>
				</div>

				<div class="column">
					<p class="subtitle">
						<strong>Source Code</strong> on <a href="https://github.com/andriannus/searchmap" target="_blank">Github</a>
					</p>
					<p>
						<iframe
							src="https://ghbtns.com/github-btn.html?user=andriannus&repo=searchmap&type=star&count=true&size=large"
							frameborder="0" scrolling="0" width="160px" height="30px"
						></iframe>
					</p>
					<p>Licensed <a href="https://github.com/andriannus/searchmap/blob/master/LICENSE">MIT</a></p>
				</div>

				<div class="column">
					<p class="subtitle">
						<strong>Thanks To</strong>
					</p>
					<div class="field is-grouped is-grouped-multiline">
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-dark">codeigniter</span>
								<span class="tag">3.1.9</span>
							</div>
						</div>

						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-dark">vue.js</span>
								<span class="tag">2.5.16</span>
							</div>
						</div>

						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-dark">moment.js</span>
								<span class="tag">2.22.2</span>
							</div>
						</div>

						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-dark">wow.js</span>
								<span class="tag">latest</span>
							</div>
						</div>

						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-dark">bulma</span>
								<span class="tag">0.7.1</span>
							</div>
						</div>

						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-dark">animate.css</span>
								<span class="tag">latest</span>
							</div>
						</div>

						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-dark">google apis</span>
								<span class="tag">v3</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>
