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

							<div class="field" v-if="isShow">
								<div class="notification is-danger">
									<button class="delete" @click="resetShow"></button>
									{{ message }}
								</div>
							</div>

							<div class="field">
								<label class="label">Username</label>
								<div class="control">
									<input
										class="input"
										type="text"
										placeholder="Input username here.."
										name="username"
										v-model="username"
									>
								</div>
							</div>

							<div class="field">
								<label class="label">Password</label>
								<div class="control">
									<input class="input" type="password" placeholder="Input password here.." name="password" v-model="password"></input>
								</div>
							</div>

							<div class="field">
								<button
									class="button is-dark is-fullwidth"
									:class="{ 'is-loading': isLoading }"
									:disabled="!username || !password"
									@click="submitForm"
								>Submit</button>
							</div>

							<div class="field has-text-centered">
								<p>
									Don't have an account?
									<a class="has-text-info" href="<?= base_url('register'); ?>">register</a>
								</p>
							</div>

							<div class="field has-text-centered">
								<p>
									<a class="button" href="<?= base_url('site') ?>">Home</a>
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
		password: '',
		message: '',
		isShow: false,
		isLoading: false
	}),

	methods: {
		submitForm () {
			this.isLoading = true

			let data = 	'username=' + this.username +
									'&password=' + this.password

			axios.post('<?= base_url() ?>' + 'auth/loginProcess', data)
				.then(res => {
					this.isLoading = false

					if (!res.data.success) {
						this.password = ''
						this.message = res.data.message
						this.isShow = true
					
					} else {
						console.log(res.data.message)
						window.location.replace('<?= base_url() ?>')
					}
				})
				.catch(err => {
					console.log(err)
				})
		},

		resetShow () {
			this.message = ''
			this.isShow = false
		}
	}
})
</script>
