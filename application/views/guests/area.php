<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="guest">
	<section class="hero is-light is-bold" style="margin: 52px 0 10px 0">
		<div class="hero-body">
			<div class="container wow slideInLeft" data-wow-duration="1s">
				<h1 class="title">
					Area | Guest Book
					<i class="fas fa-book"></i>
				</h1>
				<p class="subtitle">Find recommend Areas from Guest</p>
			</div>
		</div>
	</section>

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
					<a href="<?= base_url('guest/place'); ?>" class="button is-primary is-outlined">
						<span class="icon">
							<i class="fas fa-map-marker-alt"></i>
						</span>
						<span>Places</span>
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

				<div class="table-responsive" v-if="found">
					<table class="table is-fullwidth is-striped is-bordered">
						<thead>
							<tr>
								<th width="25%">
									<i class="fas fa-user"></i>
									Guest Name
								</th>
								<th width="35%">
									<i class="fas fa-map-marker-alt"></i>
									Area Name
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
						<tbody v-for="(guest, index) in newGuests">
							<tr>
								<td>{{ guest.name }}</td>
								<td>{{ guest.area_name }}</td>

								<!-- Data yang ditampilkan akan difilter terlebih dahulu -->
								<td>{{ guest.date | moment }}</td>
								<td>
									<a
										class="button is-link"
										:href="'<?= base_url() ?>' + 'draw/' + guest.id"
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
			<i class="fas fa-frown fa-2x"></i>
		</p>
		<p class="subtitle">
			No Recomendations
		</p>
		<a class="button is-link" href="<?= base_url('draw') ?>">
			Draw New Area
		</a>

		<a class="button is-link is-outlined" href="<?= base_url('guest/place') ?>">
			Places
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

	<!-- Modal konfirmasi hapus data -->
	<div class="modal" :class="{ 'is-active': visibleModalDelete }">
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="box">
				<p class="title">Really?</p>
				<button class="button is-danger" @click="deleteArea">Yes</button>
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
| https://vue.js.org
|
*/

const guest = new Vue({
	el: '#guest',
	data: () => ({
		guests: [],
		newGuests: [],
		count: '',
		query: '',
		idArea: '',
		found: true,
		loading: false,
		visibleModalDelete: false
	}),

	mounted() {
		this.getData()
	},

	methods: {
		// Method untuk mengambil data area
		getData () {
			this.loading = true

			axios.get('<?= base_url() ?>' + 'api/getAllAreas')
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

		// Method untuk filter pencarian berdasarkan field 'nama' dan 'area'
		fetchData () {
			this.newGuests = []
			let query = this.query.toLowerCase()
			this.guests.map((guest) => {
				if (guest.name.toLowerCase().indexOf(query) !== -1 || guest.area_name.toLowerCase().indexOf(query) !== -1) {
					this.newGuests.push(guest)
				}
			})

			if (this.newGuests.length < 1) {
				this.found = false

			} else {
				this.found = true
			}
		},

		// Method untuk menghapus area
		deleteArea () {
			axios.post('<?= base_url() ?>' + 'api/destroyArea/' + this.idArea)
				.then(res => {
					if (!res.data.success) {
						alert('Error')

					} else {
						location.reload()
					}
				})
				.catch(err => {
					console.log(err)
				})
		},

		// Method untuk menampilkan konfirmasi hapus area
		switchModal (id) {
			if (id === null) {
				this.idArea = ''

			} else {
				this.idArea = id
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