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
const app = new Vue({
	el: '#app',
	data: () => ({
		map: '',
		infoWindow: '',
		infoWindowContent: [],
		marker: [],
		visibleCard: 'none'
	}),
	
	mounted () {
		this.initMap()
	},

	methods: {
		initMap () {
			this.map = new google.maps.Map(this.$refs.map, {
				center: {
					lat: -2.279866,
					lng: 117.369878
				},
				zoom: 5,
				disableDefaultUI: true
			});

			let card = this.$refs.mapCard // Get mapCard element

			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);

			this.infoWindow = new google.maps.InfoWindow({
				maxWidth: 231
			})
			
			google.maps.event.addListenerOnce(this.map, 'tilesloaded', function () {
				app.visibleCard = 'block'
			})

			this.fetchData()
		},

		fetchData () {
			axios.get('<?= base_url() ?>' + 'api/getAllPlaces')
				.then(res => {
					const places = res.data.data

					for (let i=0; i<places.length; i++) {
						this.infoWindowContent[i] = this.getInfoWindowContent(places[i])
						let latLng = new google.maps.LatLng(places[i].lat, places[i].lng)

						this.marker[i] = new google.maps.Marker({
							position: latLng,
							map: this.map
						})

						this.marker[i].addListener('click', function () {
							app.infoWindow.setContent(app.infoWindowContent[i])
							app.infoWindow.open(app.map, app.marker[i])
							app.map.setCenter(app.marker[i].getPosition())
							app.map.setZoom(15)
						})
					}
				})
				.catch(err => {

				})
		},

		getInfoWindowContent (loc) {
			let content = `
										<div id="infowindow">
											<span class="subtitle">${ loc.place }</span><br><br>
											<p>${ loc.address }</p>
										</div>	
										`

			return content
		}
	}
})
</script>
