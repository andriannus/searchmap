<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="area">
	<div class="card" ref="mapCard" style="margin: 5px 0 0 5px" :style="{ display: visibleCard }">
		<header class="card-header">
			<p class="card-header-title">Menus</p>
		</header>

		<div class="card-content">
			<div class="content">
				<div class="field">
					<a href="<?= base_url('site') ?>" class="button is-large is-dark" title="Home">
						<span class="icon">
							<i class="fas fa-home"></i>
						</span>
					</a>
					<a href="<?= base_url('guest/area') ?>" class="button is-large is-info" title="Guest Book">
						<span class="icon">
							<i class="fas fa-book"></i>
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="card" ref="mapCardDelete" style="margin: 5px 0 0 5px" :style="{ display: visibleCardDelete }">
		<header class="card-header">
			<p class="card-header-title">Save or Delete?</p>
		</header>
		<div class="card-content">
			<div class="content">
				<div class="field" v-if="!saved">
					<button class="button is-large is-success" title="Save Area" @click="switchModal">
						<span class="icon">
							<i class="fas fa-save"></i>
						</span>
					</button>
					<button class="button is-large is-danger" ref="buttonRemove" title="Delete Area">
						<span class="icon">
							<i class="fas fa-trash"></i>
						</span>
					</button>
				</div>

				<div class="field" v-if="saved">
					<button class="button is-success">
						<span class="icon">
							<i class="fas fa-check"></i>
						</span>
						<span>Saved</span>
					</button>
				</div>
			</div>
		</div>
		<footer class="card-footer">
			<a href="<?= base_url('site') ?>" class="card-footer-item">Home</a>
			<a href="<?= base_url('guest/area') ?>" class="card-footer-item has-text-centered">Guest Book</a>
		</footer>
	</div>

	<div id="map" ref="map" style="height: 100%; display: hidden"></div>

	<!-- Modal Save -->
	<div class="modal" :class="{ 'is-active': visibleModal }">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Guest Book</p>
				<button class="delete" aria-label="close" @click="switchModal"></button>
			</header>
			<section class="modal-card-body">
				<div class="field">
					<label class="label">Name</label>
					<div class="control has-icons-left">
						<input class="input" type="text" placeholder="Name or Initial" v-model="name"></input>
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</div>
				</div>
				<div class="field">
					<label class="label">Area Name</label>
					<div class="control has-icons-left">
						<input class="input" type="text" placeholder="Area Name" v-model="areaName"></input>
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button class="button is-success" @click="saveArea" v-if="!inTheProcess" :disabled="!name || !areaName">Save</button>
				<button class="button is-success is-loading" v-if="inTheProcess">Save</button>
				<button class="button" @click="switchModal">Cancel</button>
			</footer>
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

const area = new Vue({
	el: '#area',
	data: () => ({
		map: '',
		drawingManager: '',
		circle: '',
		rectangle: '',
		polyline: '',
		polygon: '',
		name: '',
		areaName: '',
		areaLoc: '',
		areaType: '',
		newShape: '',
		visibleCard: 'none',
		visibleCardDelete: 'none',
		visibleModal: false,
		inTheProcess: false,
		saved: false
	}),
	
	mounted () { // Silahkan lihat LifeCycle Vue.js
		this.initMap()
	},

	methods: {
		initMap () {
			// 'area' -> 'const app = new Vue({})'

			// Menyimpan data map pada Vue.js
			this.map = new google.maps.Map(this.$refs.map // atribut 'ref' dengan value 'map', {
				center: {
					lat: -6.595038,
					lng: 106.816635
				},
				zoom: 13,
				disableDefaultUI: true // Menghilangkan tombol - tombol default Google Maps
			});

			const drawingModeOptions = {
				editable: false
			}

			this.drawingManager = new google.maps.drawing.DrawingManager({
				drawingMode: google.maps.drawing.OverlayType.POLYLINE,
				drawingControlOptions: {
					// Shape apa saja yang dapat dibuat
					drawingModes: ['polyline', 'rectangle', 'circle', 'polygon',]
				},
				polylineOptions: drawingModeOptions,
				rectangleOptions: drawingModeOptions,
				circleOptions: drawingModeOptions,
				polygonOptions: drawingModeOptions,
				map: this.map
			})

			// Ketika shape (apapun) selesai dibuat
			google.maps.event.addListener(this.drawingManager, 'overlaycomplete', function (shape) {
				area.drawingManager.setMap(null),
				area.newShape = shape.overlay,
				area.visibleCard = 'none',
				area.visibleCardDelete = 'block'
			})

			// Ketika polyline selesai dibuat
			google.maps.event.addListener(this.drawingManager, 'polylinecomplete', function (polyline) {
				let arrayPolyline = []
				let data = polyline.getPath().getArray()
				
				for (let i=0; i<data.length; i++) {
					arrayPolyline.push(data[i].lat() + ', ' + data[i].lng())
				}

				area.areaType = 'polyline'
				area.areaLoc = JSON.stringify(arrayPolyline)
			})

			// Ketika rectangle selesai dibuat
			google.maps.event.addListener(this.drawingManager, 'rectanglecomplete', function (rectangle) {
				let jsonRectangle = {
					west: rectangle.bounds.b.b,
					east: rectangle.bounds.b.f,
					south: rectangle.bounds.f.b,
					north: rectangle.bounds.f.f
				}

				area.areaType = 'rectangle'
				area.areaLoc = JSON.stringify(jsonRectangle) // Mengubah Array/Object menjadi sebuah String
			})

			// Ketika circle selesai dibuat
			google.maps.event.addListener(this.drawingManager, 'circlecomplete', function (circle) {
				let jsonCircle = {
					center: {
						lat: circle.center.lat(),
						lng: circle.center.lng(),
					},	
					radius: circle.radius
				}

				area.areaType = 'circle'
				area.areaLoc = JSON.stringify(jsonCircle) // Mengubah Array/Object menjadi sebuah String
			})

			// Ketika polygon selesai dibuat
			google.maps.event.addListener(this.drawingManager, 'polygoncomplete', function (polygon) {
				let arrayPolygon = []
				let data = polygon.getPath().getArray()
				
				for (let i=0; i<data.length; i++) {
					arrayPolygon.push(data[i].lat() + ', ' + data[i].lng())
				}

				area.areaType = 'polygon'
				area.areaLoc = JSON.stringify(arrayPolygon) // Mengubah Array/Object menjadi sebuah String
			})

			// Silahkan lihat tag HTML dengan atribut 'ref' = 'buttonRemove'
			// Ketika tag tersebut diklik
			google.maps.event.addDomListener(this.$refs.buttonRemove, 'click', function () {
				area.drawingManager.setMap(area.map),
				area.newShape.setMap(null),
				area.visibleCard = 'block',
				area.visibleCardDelete = 'none'
			})

			let card = this.$refs.mapCard // Silahkan lihat tag HTML dengan atribut 'ref' = 'mapCard'
			let cardDelete = this.$refs.mapCardDelete
			let button = this.$refs.buttonSave

			// Menampilkan card atau cardDelete pada Map
			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);
			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(cardDelete);

			// Ketika Maps selesai dimuat
			google.maps.event.addListenerOnce(this.map, 'tilesloaded', function () {
				area.visibleCard = 'block'
			})
		},

		// Menyimpan data area
		saveArea () {
			this.inTheProcess = true

			let data = 	'name=' + this.name + 
									'&area_name=' + this.areaName +
									'&area_type=' + this.areaType +
									'&area=' + this.areaLoc

			// Axios post (sama seperti jQuery AJAX)
			axios.post('<?= base_url() ?>' + 'api/storeArea', data)
				// then / catch -> Promise JavaScript
				.then(res => {
					this.inTheProcess = false
					this.visibleModal = false
					console.log(res)
					this.saved = true
				})
				.catch(err => {
					console.log(err)
				})
		},

		switchModal () {
			this.name = ''
			this.visibleModal = !this.visibleModal
		}
	}
})
</script>
