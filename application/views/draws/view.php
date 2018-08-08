<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="area">
	<div class="card" ref="mapCard" style="margin: 5px 0 0 5px" :style="{ display: visibleCard }">
		<header class="card-header">
			<p class="card-header-title">Area by - {{ name }} -</p>
		</header>

		<div class="card-content">
			<div class="content">
				<div class="field">
					<p class="title">Area Name</p>
					<p class="subtitle">{{ areaName }}</p>
				</div>
			</div>
		</div>

		<footer class="card-footer">
			<a href="<?= base_url('site/index') ?>" class="card-footer-item">Home</a>
			<a href="<?= base_url('guest/area') ?>" class="card-footer-item has-text-centered">Guest</a>
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
| https://vue.js.org
|
*/

const area = new Vue({
	el: '#area',
	data: () => ({
		id: <?= $area->id ?>, // Didapatkan dari Controller,
		map: '',
		circle: '',
		rectangle: '',
		polyline: '',
		polygon: '',
		name: '',
		areaName: '',
		areaLoc: '',
		areaType: '',
		visibleCard: 'none'
	}),
	
	mounted () {
		this.fetchData()
	},

	methods: {
		initMap () {
			// 'area' -> 'const app = new Vue({})'

			this.map = new google.maps.Map(this.$refs.map, {
				disableDefaultUI: true
			});

			let card = this.$refs.mapCard

			this.map.controls[google.maps.ControlPosition.LEFT_TOP].push(card);

			google.maps.event.addListenerOnce(this.map, 'tilesloaded', function () {
				area.visibleCard = 'block'
			})
		},

		fetchData () {
			// Axios get (sama seperti jQuery AJAX)
			// Digunakan untuk mengambil data dari Api Controller
			axios.get('<?= base_url() ?>' + 'api/getOneArea/' + this.id)
				.then(res => {
					this.initMap() // Menjalankan method initMap

					this.name = res.data.data.name
					this.areaName = res.data.data.area_name

					let area = res.data.data
					let type = area.area_type

					// Jika tipe shape polyline
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

					// Jika tipe shape rectangle
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

					// Jika tipe shape circle
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

					// Jika tipe shape polygon
					if (type === 'polygon') {
						let polygon = JSON.parse(area.area) // Mengubah string menjadi Array/Object
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

						// Google Maps LatLng
						// split digunakan untuk memisahkan sebuah string berdasarkan kondisi pada parameternya
						const latLng = new google.maps.LatLng(parseFloat(polygon[0].split(', ')[0]), parseFloat(polygon[0].split(', ')[1]))

						this.map.setCenter(latLng)
						this.map.setZoom(13)
					}
				})
				.catch(err => {
					console.log(err)
				})
		}
	}
})
</script>
