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
const app = new Vue({
	el: '#app',
	data: () => ({
		name: '<?= $place->name ?>',
		placeName: '<?= $place->place ?>',
		placeAddress: '<?= $place->address ?>',
		placeLat: <?= $place->lat ?>,
		placeLng: <?= $place->lng ?>,
		visibleCard: 'none',
		visibleInfoWindow: 'none'
	}),
	
	mounted () {
		this.initMap()
	},

	methods: {
		initMap () {
			const latLng = new google.maps.LatLng(this.placeLat, this.placeLng)

			const map = new google.maps.Map(this.$refs.map, {
				center: latLng,
				zoom: 17,
				disableDefaultUI: true
			});

			let card = this.$refs.mapCard // Get mapCard element

			map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);

			const infowindow = new google.maps.InfoWindow({
				maxWidth: 231
			});

			const marker = new google.maps.Marker({
				map: map,
				position: latLng,
				anchorPoint: new google.maps.Point(0, -29)
			});

			let infowindowContent = this.$refs.mapInfoWindow
			infowindow.setContent(infowindowContent)

			this.visibleInfoWindow = 'inline'
			infowindow.open(map, marker)

			marker.addListener('click', function () {
				infowindow.open(map, marker)
			})
			
			google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
				app.visibleCard = 'block'
			})
		}
	}
})
</script>
