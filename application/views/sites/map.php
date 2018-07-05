<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="app">
	<section class="hero is-white is-fullheight" v-if="!placeFound">
		<div class="hero-body">
			<div class="container has-text-centered">
				<p class="title"><i class="fas fa-sad-tear"></i></p>
				<p class="subtitle">- Not Found -</p>
				<p>
					<a class="button is-success" href="<?= base_url('site') ?>">
						<span class="icon">
							<i class="fas fa-home"></i>
						</span>
						<span>Home</span>
					</a>

					<a class="button is-info" href="<?= base_url('guest') ?>">
						<span class="icon">
							<i class="fas fa-book"></i>
						</span>
						<span>Guest Book</span>
					</a>
				</p>
			</div>
		</div>
	</section>

	<div class="card" ref="mapCard" style="margin: 10px 0 0 10px" :style="{ display: visibleCard }">
		<header class="card-header">
			<p class="card-header-title" v-if="!haveId">Search here..</p>
			<p class="card-header-title" v-if="haveId">Place by {{ name }}</p>
		</header>
		<div class="card-content" v-if="!haveId">
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
			<a href="<?= base_url('site/index') ?>" class="card-footer-item">Home</a>
			<a href="<?= base_url('guest') ?>" class="card-footer-item has-text-centered">Guest Book</a>
		</footer>
	</div>

	<div id="map" ref="map" style="height: 100%" v-if="placeFound"></div>

	<div id="infowindow" ref="mapInfoWindow" :style="{ display: visibleInfoWindow }">
		<span id="place-name" class="subtitle">{{ placeName }}</span><br><br>
		<p id="place-address">{{ placeAddress }}</p>
		<a class="button is-info" ref="buttonSave" @click="switchModal" v-if="!haveId && !saved" style="margin-top: 10px">
			<span class="icon">
				<i class="fas fa-bookmark"></i>
			</span>
			<span>Save This Place</span>
		</a>
		<a class="button is-success" v-if="!haveId && saved" style="margin-top: 10px">
			<span class="icon">
				<i class="fas fa-check"></i>
			</span>
			<span>Saved</span>
		</a>
	</div>

	<div class="modal" :class="{ 'is-active': visibleModal }">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Guest Book</p>
				<button class="delete" aria-label="close" @click="switchModal"></button>
			</header>
			<section class="modal-card-body">
				<div class="field">
					<label class="label">Nama</label>
					<div class="control has-icons-left">
						<input class="input" type="text" placeholder="Nama atau Inisial" v-model="name"></input>
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button class="button is-success" @click="savePlace" v-if="!inTheProcess" :disabled="!name">Save</button>
				<button class="button is-success is-loading" v-if="inTheProcess">Save</button>
				<button class="button" @click="switchModal">Cancel</button>
			</footer>
		</div>
	</div>
</div>

<script>
const app = new Vue({
	el: '#app',
	data: () => ({
		name: '',
		placeName: '',
		placeAddress: '',
		placeLat: '',
		placeLng: '',
		visibleCard: 'none',
		visibleInfoWindow: 'none',
		visibleModal: false,
		haveId: false,
		placeFound: true,
		inTheProcess: false,
		saved: false
	}),
	
	mounted () {
		this.fetchData()
	},

	methods: {
		initMap () {
			// 'app' -> 'const app = new Vue({})'

			const map = new google.maps.Map(this.$refs.map, {
				center: {
					lat: -6.595038,
					lng: 106.816635
				},
				zoom: 13,
				disableDefaultUI: true
			});

			let card = this.$refs.mapCard // Get mapCard element
			let input = this.$refs.mapInput // Get mapInput element
			let button = this.$refs.buttonSave

			map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);
			// map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(button);

			const autocomplete = new google.maps.places.Autocomplete(input)

			const infowindow = new google.maps.InfoWindow({
				maxWidth: 231
			});

			const marker = new google.maps.Marker({
				map: map,
				anchorPoint: new google.maps.Point(0, -29)
			});

			let infowindowContent = this.$refs.mapInfoWindow
			infowindow.setContent(infowindowContent)

			if (!this.haveId) {
				autocomplete.bindTo('bounds', map)

			} else {
				const latLng = new google.maps.LatLng(this.placeLat, this.placeLng)

				marker.setPosition(latLng)
				marker.setVisible(true)

				map.setCenter(latLng)
				map.setZoom(17)

				this.visibleInfoWindow = 'inline'
				infowindow.open(map, marker)
			}

			autocomplete.addListener('place_changed', function () {
				app.saved = false

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
				app.placeLat = place.geometry.location.lat()
				app.placeLng = place.geometry.location.lng()
				app.visibleInfoWindow = 'inline'

				infowindow.open(map, marker)
			});

			google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
				app.visibleCard = 'block'
			})
		},

		savePlace () {
			this.inTheProcess = true

			let data = 	'name=' + this.name + 
						'&place=' + this.placeName +
						'&address=' + this.placeAddress + 
						'&lat=' + this.placeLat + 
						'&lng=' + this.placeLng

			axios.post('<?= base_url() ?>' + 'api/storePlace', data)
				.then(res => {
					this.inTheProcess = false
					this.visibleModal = false
					this.saved = true
				})
				.catch(err => {
					console.log(err)
				})
		},

		fetchData () {
			const searchParam = new URLSearchParams(window.location.search)
			let id = searchParam.get('id')

			if (id === null) {
				this.initMap()

			} else {
				axios.get('<?= base_url() ?>' + 'api/getOnePlace/' + id)
					.then(res => {
						this.name = res.data.data.name
						this.placeName = res.data.data.place
						this.placeAddress = res.data.data.address
						this.placeLat = res.data.data.lat
						this.placeLng = res.data.data.lng

						this.haveId = true
						this.initMap()
					})
					.catch(err => {
						if (err.response.status === 404) {
							this.placeFound = false
						}
					})
			}
		},

		switchModal () {
			this.name = ''
			this.visibleModal = !this.visibleModal
		}
	}
})
</script>
