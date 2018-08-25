<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="login">
	<section class="hero is-white is-fullheight">
		<div class="hero-body">
			<div class="container">
				<div class="columns">
					<div class="column is-4 is-offset-4">
						<div class="box">
							<p class="title has-text-centered">Login</p>

							<div class="field">
								<label class="label">Username</label>
								<div class="control">
									<input class="input" type="text" placeholder="Input username here.." name="username" v-model="username"></input>
								</div>
							</div>

							<div class="field">
								<label class="label">Password</label>
								<div class="control">
									<input class="input" type="password" placeholder="Input password here.." name="password" v-model="password"></input>
								</div>
							</div>

							<div class="field">
								<button class="button is-dark is-fullwidth">Submit</button>
							</div>

							<div class="field has-text-centered">
								<p>
									Don't have an account?
									<a class="has-text-info" href="<?= base_url('register'); ?>">register</a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
const login = new Vue({
	el: '#login',
	data: () => ({
		username: '',
		password: ''
	}),

	methods: {

	}
})
</script>
