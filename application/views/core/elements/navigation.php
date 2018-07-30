<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="app">
	<nav class="navbar is-fixed-top is-light" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<a class="navbar-item wow slideInLeft" href="<?= base_url() ?>" data-wow-duration="1s">
				SEARCH MAP
			</a>

			<a role="button" class="navbar-burger has-text-dark" :class="{ 'is-active': isActive }" aria-label="menu" aria-expanded="false" @click="switchMenu">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>

		<div class="navbar-menu" :class="{ 'is-active': isActive }">
			<div class="navbar-start">
				<a
					class="navbar-item wow slideInDown <?= (isset($menu) && $menu === 'home' ? 'is-active' : ''); ?>"
					href="<?= base_url() ?>"
					data-wow-duration="1s"
					data-wow-delay="0.2s"
				>
					<i class="fas fa-home"></i>&nbsp;
					Home
				</a>
				<a class="navbar-item wow slideInDown" href="<?= base_url('map') ?>" data-wow-duration="1s" data-wow-delay="0.4s">
					<i class="fas fa-map"></i>&nbsp;
					Map
				</a>
				<a class="navbar-item wow slideInDown" href="<?= base_url('draw') ?>" data-wow-duration="1s" data-wow-delay="0.6s">
					<i class="fas fa-pen"></i>&nbsp;
					Draw Map
				</a>
			</div>

			<div class="navbar-end">
				<div class="navbar-item wow slideInDown" data-wow-duration="1s" data-wow-delay="0.8s">
					<div class="field is-grouped">
						<p class="control">
							<a class="button is-info" href="<?= base_url('guest') ?>">
								<span class="icon">
									<i class="fas fa-book"></i>
								</span>
								<span>Guest Book</span>
							</a>

							<a class="button is-dark" href="https://github.com/andriannus/searchmap" target="_blank">
								<span class="icon">
									<i class="fab fa-github"></i>
								</span>
								<span>Github</span>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</nav>
</div>

<script>
/*
|--------------------------------------------------------------------------
| Vue.js
|--------------------------------------------------------------------------
|
| new Vue({}) -> Instance Vue.js
|
| Digunakan untuk mengawali Vue.js
| 
| el 			-> Target yang akan dimanupulasi oleh Vue.js
| data 		-> Data (variabel) pada Vue.js
| methods	-> Menampung Method yang akan digunakan
| 
| {{}}		-> Menampilkan data (variabel)
| @click	-> Melakukan method tertentu ketika bagian tersebut diklik
|
| Untuk lebih lengkapnya, silahkan kunjungi:
| https://vue.js.org
|
*/

const app = new Vue({
	el: '#app', // tag HTML dengan id = app
	data: () => ({
		isActive: false
	}),

	methods: {
		switchMenu () {
			this.isActive = !this.isActive
		}
	}
})
</script>