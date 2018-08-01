<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="guest">
	<section class="hero is-light is-bold" style="margin: 52px 0 10px 0">
		<div class="hero-body">
			<div class="container wow slideInLeft" data-wow-duration="1s">
				<h1 class="title">
					Place | Guest Book
					<i class="fas fa-book"></i>
				</h1>
				<p class="subtitle">Find recommend Place from Guest</p>
			</div>
		</div>
	</section>

	<section class="section" v-if="!loading && count > 0">
		<div class="columns">
			<div class="column is-8 is-offset-2 wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s">

				<p class="title">{{ count }} Recommendations</p>
				<p class="subtitle">
					<a href="<?= base_url('guest/area'); ?>" class="button is-primary is-outlined">
						<span class="icon">
							<i class="fas fa-map"></i>
						</span>
						<span>Areas</span>
					</a>

					<a href="<?= base_url('map/all'); ?>" class="button is-link is-outlined">
						<span class="icon">
							<i class="fas fa-eye"></i>
						</span>
						<span>Show All</span>
					</a>
				</p>
				<div class="table-responsive">
					<table class="table is-fullwidth is-striped is-bordered">
						<thead>
							<tr>
								<th width="25%">
									<i class="fas fa-user"></i>
									Guest Name
								</th>
								<th width="35%">
									<i class="fas fa-map-marker-alt"></i>
									Place Name
								</th>
								<th width="20%">
									<i class="fas fa-clock"></i>
									Date Created
								</th>
								<th width="20%">
									<i class="fas fa-certificate"></i>
									Action
								</th>
							</tr>
						</thead>
						<tbody v-for="(guest, index) in guests">
							<tr>
								<td>{{ guest.name }}</td>
								<td>{{ guest.place }}</td>

								<!-- Data yang ditampilkan akan difilter terlebih dahulu -->
								<td>{{ guest.date | moment }}</td>
								<td>
									<a
										class="button is-link"
										:href="'<?= base_url() ?>' + 'map/' + guest.id"
									>
										<span class="icon">
											<i class="fas fa-eye"></i>
										</span>
									</a>

									<button
										class="button is-danger"
										@click="switchModal(guest.id)"
									>
										<span class="icon">
											<i class="fas fa-trash"></i>
										</span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<div class="has-text-centered" v-if="!loading && count < 1">
		<p class="title">
			<i class="fas fa-frown"></i>
		</p>
		<p class="subtitle">
			No Recomendations
		</p>
		<a class="button is-link" href="<?= base_url('map') ?>">
			Add New Place
		</a>

		<a class="button is-link is-outlined" href="<?= base_url('guest/area') ?>">
			Areas
		</a>
	</div>

	<div class="has-text-centered" v-if="loading">
		<p class="title">
			<i class="fas fa-spinner fa-spin"></i>
		</p>
		<p class="subtitle">
			Load Data..
		</p>
	</div>

	<div class="modal" :class="{ 'is-active': visibleModalDelete }">
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="box">
				<p class="title">Really?</p>
				<button class="button is-danger" @click="deletePlace">Yes</button>
				<button class="button" @click="switchModal(null)">No</button>
			</div>
		</div>
		<button class="modal-close is-large" aria-label="close" @click="switchModal(null)"></button>
	</div>
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

const guest = new Vue({
	el: '#guest',
	data: () => ({
		guests: {},
		count: '',
		loading: false,
		visibleModalDelete: false,
		idPlace: ''
	}),

	mounted() {
		this.fetchData()
	},

	methods: {
		// Method untuk menampilkan data tempat
		fetchData () {
			this.loading = true

			axios.get('<?= base_url() ?>' + 'api/getAllPlaces')
				.then(res => {
					this.guests = res.data.data
					this.count = res.data.data.length
					this.loading = false
				})
				.catch(err => {
					console.log(err)
				})
		},

		// Method untuk menghapus tempat
		deletePlace () {
			axios.post('<?= base_url() ?>' + 'api/destroyPlace/' + this.idPlace)
				.then(res => {
					if (!res.data.success) {
						alert('Error')

					} else {
						location.reload() // Reload halaman
					}
				})
				.catch(err => {
					console.log(err)
				})
		},

		// Method untuk menampilkan konfirmasi hapus data
		switchModal (id) {
			if (id === null) {
				this.idPlace = ''

			} else {
				this.idPlace = id
			}

			this.visibleModalDelete = !this.visibleModalDelete
		}
	},

	// Filter data tertentu
	filters: {
		// Output akan diubah dengan bantuan dari Moment.js
		moment: (date) => moment(date).fromNow()
	}
})
</script>