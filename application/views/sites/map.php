<div id="app">
	<section class="hero is-white is-fullheight" v-if="loadingMap">
		<div class="hero-body">
			<div class="container has-text-centered">
				<p class="title"><i class="fas fa-spinner fa-spin"></i></p>
				<p class="subtitle">Please wait..</p>
			</div>
		</div>
	</section>

	<div class="card" ref="mapCard" style="margin-left: 10px" :style="{ display: visibleCard }">
		<header class="card-header">
			<p class="card-header-title">Search here..</p>
		</header>
		<div class="card-content">
			<div class="content">
				<div class="field">
					<div class="control has-icons-left">
						<span class="icon is-small is-left">
							<i class="fas fa-map-marker-alt"></i>
						</span>
						<input class="input" type="text" ref="mapInput" placeholder="Enter a location">
					</div>
				</div>
			</div>
		</div>
		<footer class="card-footer">
			<a href="<?= base_url('site/index') ?>" class="card-footer-item">Back to Home</a>
		</footer>
	</div>

	<div id="map" ref="map" style="height: 100%"></div>

	<div id="infowindow" ref="mapInfoWindow" :style="{ display: visibleInfoWindow }">
		<span id="place-name" class="subtitle">{{ placeName }}</span><br><br>
		<span id="place-address">{{ placeAddress }}</span>
	</div>
</div>

<script>
const app = new Vue({
	el: '#app',
	data: () => ({
		placeName: '',
		placeAddress: '',
		loadingMap: true,
		visibleCard: 'none',
		visibleInfoWindow: 'none'
	}),

	mounted () {
		this.initMap()
	},

	methods: {
		initMap () {
			// 'app' -> 'const app = new Vue({})'

			const map = new google.maps.Map(this.$refs.map, {
				center: {
					lat: -6.595038,
					lng: 106.816635
				},
				zoom: 13
			});

			let card = this.$refs.mapCard // Get mapCard element
			let input = this.$refs.mapInput // Get mapInput element

			map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);

			const autocomplete = new google.maps.places.Autocomplete(input);

			autocomplete.bindTo('bounds', map);

			const infowindow = new google.maps.InfoWindow({
				maxWidth: 231
			});

			let infowindowContent = this.$refs.mapInfoWindow
			infowindow.setContent(infowindowContent)

			const marker = new google.maps.Marker({
				map: map,
				anchorPoint: new google.maps.Point(0, -29)
			});

			autocomplete.addListener('place_changed', function () {
				infowindow.close();
				marker.setVisible(false);
				let place = autocomplete.getPlace()

				if (!place.geometry) {
					window.alert("No details available for input: '" + place.name + "'");
					return;
				}

				if (place.geometry.viewport) {
					map.fitBounds(place.geometry.viewport)
				} else {
					map.setCenter(place.geometry.location)
					map.setZoom(17)
				}

				marker.setPosition(place.geometry.location)
				marker.setVisible(true)

				app.placeName = place.name
				app.placeAddress = place.formatted_address
				app.visibleInfoWindow = 'inline'

				infowindow.open(map, marker)
			});

			google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
				app.visibleCard = 'block',
				app.loadingMap = false
			})
		},
	}
})
</script>
