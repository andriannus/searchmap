<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="app">
	<div class="card" ref="mapCard" style="margin: 10px 0 0 10px" :style="{ display: visibleCard }">
		<header class="card-header">
			<p class="card-header-title">Place by {{ name }}</p>
		</header>
		<footer class="card-footer">
			<a href="<?= base_url() ?>" class="card-footer-item">Home</a>
			<a href="<?= base_url('guest/place') ?>" class="card-footer-item has-text-centered">Guest Book</a>
		</footer>
	</div>

	<div id="map" ref="map" style="height: 100%"></div>

	<div id="infowindow" ref="mapInfoWindow" :style="{ display: visibleInfoWindow }">
		<span id="place-name" class="subtitle">{{ placeName }}</span><br><br>
		<p id="place-address">{{ placeAddress }}</p>
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

const app = new Vue({

	// app.--- Menuju kepada Vue.js

	el: '#app',
	data: () => ({
		// Default data didapatkan dari Controller
		name: '<?= $place->name ?>',
		placeName: '<?= $place->place ?>',
		placeAddress: '<?= $place->address ?>',
		placeLat: <?= $place->lat ?>,
		placeLng: <?= $place->lng ?>,
		map: '',
		latLng: '',
		infowindow: '',
		card: '',
		visibleCard: 'none',
		visibleInfoWindow: 'none',
	}),
	
	mounted() {
		this.initMap();
	},

	methods: {
		initMap() {
			// Google Maps LatLng
			this.latLng = new google.maps.LatLng(this.placeLat, this.placeLng);

			this.map = new google.maps.Map(this.$refs.map, {
				center: this.latLng,
				zoom: 17,
				disableDefaultUI: true,
			});

			this.card = this.$refs.mapCard; // Get mapCard element

			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(this.card);

			// Google Maps InfoWindow (pop up pada marker)
			this.InfoWindow = new google.maps.InfoWindow({
				maxWidth: 231
			});

			// Google Maps Marker
			const marker = new google.maps.Marker({
				map: this.map,
				position: this.latLng,
				anchorPoint: new google.maps.Point(0, -29)
			});

			// Isi dari InfoWindow
			let infowindowContent = this.$refs.mapInfoWindow;
			this.InfoWindow.setContent(infowindowContent);

			// Show InfoWindow
			this.visibleInfoWindow = 'inline';
			this.InfoWindow.open(this.map, marker);

			// Ketika Marker diklik
			marker.addListener('click', function () {
				this.InfoWindow.open(this.map, marker);
			});
			
			// Ketika Maps selesai dimuat
			google.maps.event.addListenerOnce(this.map, 'tilesloaded', () => {
				this.visibleCard = 'block' // Menentukan nilai pada variabel Vue.js
			})
		},
	},
});
</script>
