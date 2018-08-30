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
				<p class="subtitle">Find recommend Places from Guest</p>
			</div>
		</div>
	</section>

	<div id="content" style="display: none;">
		<section class="section">
			<div class="columns">
				<div
					class="column is-8 is-offset-2 wow zoomIn"
					data-wow-duration="1s"
					data-wow-delay="0.6s"
					v-if="!loading && count > 0"
				>
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

					<!-- Pencarian -->
					<div class="field">
						<div class="control has-icons-right">
							<input class="input" type="text" v-model="query" placeholder="Cari disini..." @input="fetchData()">
							<span class="icon is-small is-right">
								<i class="fas fa-search"></i>
							</span>
						</div>
					</div>
					
					<!-- Jika kueri pencarian tidak ditemukan -->
					<div class="box" v-if="!found">
						<p class="title">Query "{{ query }}" Not Found</p>
					</div>

					<!-- Isi data -->
					<div class="box" v-if="found" v-for="(guest, index) in newGuests">
						<article class="media">
							<div class="media-content">
								<div class="content">
									<p class="heading">
										<strong>{{ guest.name }}</strong>,
										<em>{{ guest.date | moment }}</em>
									</p>
									<p class="subtitle">{{ guest.place }}</p>
								</div>
							</div>

							<div class="media-right">
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
							</div>
						</article>
					</div>
				</div>
			</div>
		</section>

		<div class="has-text-centered" v-if="!loading && count < 1">
			<p class="title">
				<i class="fas fa-frown fa-2x"></i>
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

		<!-- Loading -->
		<div class="has-text-centered" v-if="loading">
			<p class="title">
				<i class="fas fa-spinner fa-spin"></i>
			</p>
			<p class="subtitle">
				Load Data..
			</p>
		</div>
	</div>

	<!-- Modal konfirmasi hapus data -->
	<div class="modal" :class="{ 'is-active': visibleModalDelete }">
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="box">
				<p class="title">Really?</p>
				<button class="button is-danger" @click="deletePlace">Yes</button>
				<button class="button" @click="switchModal(null)">No</button>
			</div>
		</div>
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
| https://vuejs.org
|
*/

const guest = new Vue({
	el: '#guest',
	data: () => ({
		guests: [],
		newGuests: [],
		count: '',
		query: '',
		idPlace: '',
		found: true,
		loading: false,
		visibleModalDelete: false,
	}),

	mounted() {
		this.getData()
	},

	methods: {
		// Method untuk mengambil data tempat
		getData () {
			document.getElementById('content').style.display = 'block'
			
			this.loading = true

			axios.get('<?= base_url() ?>' + 'api/getAllPlaces')
				.then(res => {
					this.guests = res.data.data
					this.count = res.data.data.length
					this.fetchData()
					this.loading = false
				})
				.catch(err => {
					console.log(err)
				})
		},

		// Method untuk filter pencarian berdasarkan field 'nama' dan 'place'
		fetchData () {
			this.newGuests = []
			let query = this.query.toLowerCase()
			this.guests.map((guest) => {
				if (guest.name.toLowerCase().indexOf(query) !== -1 || guest.place.toLowerCase().indexOf(query) !== -1) {
					this.newGuests.push(guest)
				}
			})

			if (this.newGuests.length < 1) {
				this.found = false

			} else {
				this.found = true
			}
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
			let htmlOverflow = document.getElementsByTagName('html')[0]

			if (id === null) {
				this.idPlace = ''

			} else {
				this.idPlace = id
			}

			this.visibleModalDelete = !this.visibleModalDelete

			if (!this.visibleModalDelete) {
				htmlOverflow.style.overflow = 'auto'

			} else {
				htmlOverflow.style.overflow = 'hidden'
			}
		}
	},

	// Filter data tertentu
	filters: {
		// Output akan diubah dengan bantuan dari Moment.js
		moment: (date) => moment(date).fromNow()
	}
})
</script>