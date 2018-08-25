<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="register">
	<section class="hero is-white is-fullheight">
		<div class="hero-body">
			<div class="container">
				<div class="columns">
					<div class="column is-4 is-offset-4">
						<div class="box">
							<p class="title has-text-centered">Register</p>

							<div class="field">
								<label class="label">Name</label>
								<div class="control">
									<input class="input" type="text" placeholder="Input name here.." name="name" v-model="name"></input>
								</div>
							</div>

							<div class="field">
								<label class="label">E-mail</label>
								<div class="control">
									<input class="input" type="email" placeholder="Input e-mail here.." name="email" v-model="email"></input>
								</div>
							</div>

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
									Already have an account?
									<a class="has-text-info" href="<?= base_url('login'); ?>">login</a>
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
const register = new Vue({
	el: '#register',
	data: () => ({
		name: '',
		email: '',
		username: '',
		password: ''
	}),

	methods: {

	}
})
</script>
