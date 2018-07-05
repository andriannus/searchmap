<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="area">
	<section class="hero is-white is-fullheight" v-if="!areaFound">
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

	<div class="card" ref="mapCard" style="margin: 5px 0 0 5px" :style="{ display: visibleCard }">
		<header class="card-header">
			<p class="card-header-title" v-if="!haveId">Menus</p>
			<p class="card-header-title" v-if="haveId">Area by - {{ name }} -</p>
		</header>

		<div class="card-content" v-if="!haveId">
			<div class="content">
				<div class="field">
					<a href="<?= base_url('site/index') ?>" class="button is-large is-dark" title="Home">
						<span class="icon">
							<i class="fas fa-home"></i>
						</span>
					</a>
					<a href="<?= base_url('guest/index') ?>" class="button is-large is-info" title="Guest Book">
						<span class="icon">
							<i class="fas fa-book"></i>
						</span>
					</a>
				</div>
			</div>
		</div>

		<div class="card-content" v-if="haveId">
			<div class="content">
				<div class="field">
					<p class="title">Area Name</p>
					<p class="subtitle">{{ areaName }}</p>
				</div>
			</div>
		</div>

		<footer class="card-footer" v-if="haveId">
			<a href="<?= base_url('site/index') ?>" class="card-footer-item">Home</a>
			<a href="<?= base_url('area') ?>" class="card-footer-item has-text-centered">Back</a>
		</footer>
	</div>

	<div class="card" ref="mapCardDelete" style="margin: 5px 0 0 5px" :style="{ display: visibleCardDelete }">
		<header class="card-header">
			<p class="card-header-title" v-if="!haveId">Save or Delete?</p>
		</header>
		<div class="card-content" v-if="!haveId">
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
			<a href="<?= base_url('site/index') ?>" class="card-footer-item">Home</a>
			<a href="<?= base_url('guest/index') ?>" class="card-footer-item has-text-centered">Guest Book</a>
		</footer>
	</div>

	<div id="map" ref="map" style="height: 100%; display: hidden" v-if="areaFound"></div>

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
		haveId: false,
		areaFound: true,
		inTheProcess: false,
		saved: false
	}),
	
	mounted () {
		// this.initMap()
		this.fetchData()
	},

	methods: {
		initMap () {
			// 'area' -> 'const app = new Vue({})'

			this.map = new google.maps.Map(this.$refs.map, {
				center: {
					lat: -6.595038,
					lng: 106.816635
				},
				zoom: 13,
				disableDefaultUI: true
			});

			const drawingModeOptions = {
				editable: false
			}

			this.drawingManager = new google.maps.drawing.DrawingManager({
				drawingMode: google.maps.drawing.OverlayType.POLYLINE,
				drawingControlOptions: {
					drawingModes: ['polyline', 'rectangle', 'circle', 'polygon',]
				},
				polylineOptions: drawingModeOptions,
				rectangleOptions: drawingModeOptions,
				circleOptions: drawingModeOptions,
				polygonOptions: drawingModeOptions,
				map: this.map
			})

			google.maps.event.addListener(this.drawingManager, 'overlaycomplete', function (shape) {
				area.drawingManager.setMap(null),
				area.newShape = shape.overlay,
				area.visibleCard = 'none',
				area.visibleCardDelete = 'block'
			})

			google.maps.event.addListener(this.drawingManager, 'polylinecomplete', function (polyline) {
				let arrayPolyline = []
				let data = polyline.getPath().getArray()
				
				for (let i=0; i<data.length; i++) {
					arrayPolyline.push(data[i].lat() + ', ' + data[i].lng())
				}

				area.areaType = 'polyline'
				area.areaLoc = JSON.stringify(arrayPolyline)
			})

			google.maps.event.addListener(this.drawingManager, 'rectanglecomplete', function (rectangle) {
				let jsonRectangle = {
					west: rectangle.bounds.b.b,
					east: rectangle.bounds.b.f,
					south: rectangle.bounds.f.b,
					north: rectangle.bounds.f.f
				}

				area.areaType = 'rectangle'
				area.areaLoc = JSON.stringify(jsonRectangle)
			})

			google.maps.event.addListener(this.drawingManager, 'circlecomplete', function (circle) {
				let jsonCircle = {
					center: {
						lat: circle.center.lat(),
						lng: circle.center.lng(),
					},	
					radius: circle.radius
				}

				area.areaType = 'circle'
				area.areaLoc = JSON.stringify(jsonCircle)
			})

			google.maps.event.addListener(this.drawingManager, 'polygoncomplete', function (polygon) {
				let arrayPolygon = []
				let data = polygon.getPath().getArray()
				
				for (let i=0; i<data.length; i++) {
					arrayPolygon.push(data[i].lat() + ', ' + data[i].lng())
				}

				area.areaType = 'polygon'
				area.areaLoc = JSON.stringify(arrayPolygon)
			})

			google.maps.event.addDomListener(this.$refs.buttonRemove, 'click', function () {
				area.drawingManager.setMap(area.map),
				area.newShape.setMap(null),
				area.visibleCard = 'block',
				area.visibleCardDelete = 'none'
			})

			let card = this.$refs.mapCard // Get mapCard element
			let cardDelete = this.$refs.mapCardDelete
			let button = this.$refs.buttonSave

			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);
			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(cardDelete);

			google.maps.event.addListenerOnce(this.map, 'tilesloaded', function () {
				area.visibleCard = 'block'
			})
		},

		saveArea () {
			this.inTheProcess = true

			let data = 	'name=' + this.name + 
						'&area_name=' + this.areaName +
						'&area_type=' + this.areaType +
						'&area=' + this.areaLoc

			axios.post('<?= base_url() ?>' + 'api/storeArea', data)
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

		fetchData () {
			const searchParam = new URLSearchParams(window.location.search)
			let id = searchParam.get('id')

			if (id === null) {
				this.initMap()

			} else {
				axios.get('<?= base_url() ?>' + 'api/getOneArea/' + id)
					.then(res => {
						this.initMap()
						this.drawingManager.setMap(null)

						this.name = res.data.data.name
						this.areaName = res.data.data.area_name

						let area = res.data.data
						let type = area.area_type

						if (type === 'polyline') {
							let polyline = JSON.parse(area.area)
							let arrayCoord = []
							for (let i=0; i<polyline.length; i++) {
								let coord = {
									lat: parseFloat(polyline[i].split(', ')[0]),
									lng: parseFloat(polyline[i].split(', ')[1])
								}
								arrayCoord.push(coord)
							}

							console.log(arrayCoord)

							this.polyline = new google.maps.Polyline({
								path: arrayCoord,
								map: this.map
							})

							const latLng = new google.maps.LatLng(parseFloat(polyline[0].split(', ')[0]), parseFloat(polyline[0].split(', ')[1]))

							this.map.setCenter(latLng)
							this.map.setZoom(13)
						}

						if (type === 'rectangle') {
							let rectangle = JSON.parse(area.area)
							this.rectangle = new google.maps.Rectangle({
								bounds: {
									north: rectangle.north,
									south: rectangle.south,
									east: rectangle.east,
									west: rectangle.west
								},
								map: this.map
							})

							const latLng = new google.maps.LatLng(rectangle.south, rectangle.west)

							this.map.setCenter(latLng)
							this.map.setZoom(15)
						}

						if (type === 'circle') {
							let circle = JSON.parse(area.area)
							this.circle = new google.maps.Circle({
								center: circle.center,
								radius: circle.radius,
								map: this.map
							})

							const latLng = new google.maps.LatLng(circle.center.lat, circle.center.lng)

							this.map.setCenter(latLng)
							this.map.setZoom(15)
						}

						if (type === 'polygon') {
							let polygon = JSON.parse(area.area)
							let arrayCoord = []
							for (let i=0; i<polygon.length; i++) {
								let coord = {
									lat: parseFloat(polygon[i].split(', ')[0]),
									lng: parseFloat(polygon[i].split(', ')[1])
								}
								arrayCoord.push(coord)
							}

							arrayCoord.push({
								lat: parseFloat(polygon[0].split(', ')[0]),
								lng: parseFloat(polygon[0].split(', ')[1])
							})

							this.polygon = new google.maps.Polygon({
								paths: arrayCoord,
								map: this.map
							})

							const latLng = new google.maps.LatLng(parseFloat(polygon[0].split(', ')[0]), parseFloat(polygon[0].split(', ')[1]))

							this.map.setCenter(latLng)
							this.map.setZoom(13)
						}

						this.haveId = true

					})
					.catch(err => {
						if (err.response.status === 404) {
							this.areaFound = false
						}
						console.log(err)
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
