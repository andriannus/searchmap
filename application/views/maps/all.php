<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="app">
	<div class="card" ref="mapCard" style="margin: 10px 0 0 10px" :style="{ display: visibleCard }">
		<header class="card-header">
			<p class="card-header-title">All Places</p>
		</header>
		<footer class="card-footer">
			<a href="<?= base_url() ?>" class="card-footer-item">Home</a>
			<a href="<?= base_url('guest/place') ?>" class="card-footer-item has-text-centered">Guest Book</a>
		</footer>
	</div>

	<div id="map" ref="map" style="height: 100%"></div>
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

const app = new Vue({
	el: '#app',
	data: () => ({
		map: '',
		infoWindow: '',
		infoWindowContent: [],
		marker: [],
		baseUrl: '<?= base_url() ?>',
		visibleCard: 'none',
	}),
	
	mounted() {
		this.initMap();
	},

	methods: {
		initMap() {
			this.map = new google.maps.Map(this.$refs.map, {
				center: {
					lat: -2.279866,
					lng: 117.369878
				},
				zoom: 5,
				disableDefaultUI: true,
			});

			let card = this.$refs.mapCard // Get mapCard element

			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);

			this.infoWindow = new google.maps.InfoWindow({
				maxWidth: 231
			});
			
			// Ketika Maps berhasil dimuat
			google.maps.event.addListenerOnce(this.map, 'tilesloaded', () => {
				this.visibleCard = 'block';
			});

			// Menjalankan method tertentu
			this.fetchData();
		},

		fetchData() {
			// Axios get (sama seperti jQuery AJAX)
			// Digunakan untuk mengambil data dari Api Controller
			axios.get(`${this.baseUrl}api/getAllPlaces`)
				.then((res) => {
					const places = res.data.data;

					// Perulangan berdasarkan data pada database
					for (let i=0; i<places.length; i++) {
						this.infoWindowContent[i] = this.getInfoWindowContent(places[i]);

						// Menentukan koordinat dengan Google Maps LatLng
						let latLng = new google.maps.LatLng(places[i].lat, places[i].lng);

						// Menampilkan Marker
						this.marker[i] = new google.maps.Marker({
							position: latLng,
							map: this.map
						});

						// app.---
						// Digunakan untuk menentukan nilai dari variabel Vue.js dari Google Maps
						this.marker[i].addListener('click', () => {
							this.infoWindow.setContent(this.infoWindowContent[i]);
							this.infoWindow.open(this.map, this.marker[i]);
							this.map.setCenter(this.marker[i].getPosition());
							this.map.setZoom(15);
						})
					}
				})
				.catch((err) => {
					alert('Terjadi Error. Silahkan refresh halaman');
				})
		},

		// Method untuk membuat isi dari InfoWindow
		getInfoWindowContent(loc) {
			let content = `
										<div id="infowindow">
											<span class="subtitle">${ loc.place }</span><br><br>
											<p>${ loc.address }</p>
										</div>	
										`;

			return content; // Mengembalikan nilai dari variabel
		},
	},
});
</script>
