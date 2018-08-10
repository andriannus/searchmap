<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Membuat title secara dinamis -->
	<title><?= $title ?></title>

	<!-- Meta HTML -->
	<meta property="author" content="Andre Simamora">
	<meta name='robots' content='index,follow'>
	<meta name='description' content='Find places and Draw on Map using Google Maps API'>
	<meta name='keywords' content='google maps, php, codeigniter, javascript, vue'>

	<!-- Meta Geo -->
	<meta property="geo.placename" content="Indonesia">
	<meta property="geo.country" content="id">

	<!-- Meta Social Media -->
	<meta property="og:title" content="Welcome to Search Map">
	<meta property="og:type" content="information">
	<meta property="og:url" content="https://search-map.000webhostapp.com/">
	<meta property="og:image" content="<?= base_url('assets/images/fav.png'); ?>">
	<meta property="og:description" content="Find places and Draw on Map using Google Maps API">
	<meta property="og:site_name" content="Search Map">

	<link rel="icon" type="image/png" href="<?= base_url('assets/images/fav.png'); ?>"/>

	<!-- Load asset CSS dan JavaScript. Koneksi internet diperlukan -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

	<script src="<?= base_url('assets/js/wow.min.js'); ?>"></script>
	<script src="https://unpkg.com/vue@2.5.16/dist/vue.min.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="https://momentjs.com/downloads/moment.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&libraries=places,drawing"></script>

	<style>
		html {
			overflow: auto;
		}
		
		.table-responsive {
			overflow: auto;
		}

		#btn-to-top {
			display: none;
			position: fixed;
			right: 20px;
			bottom: 35px;
		}
	</style>
</head>
<body>
	<?php
		// Jika pada halaman terdapat navigasi
		if (isset($navigation)) {
			$this->load->view($navigation);
		}
	?>
	
	<!-- Menampilkan halaman tertentu -->
	<?php $this->load->view($page) ?>

	<!-- Button back to top -->
	<button id="btn-to-top" class="button is-dark" onclick="backToTop()">
		<span class="icon">
			<i class="fas fa-chevron-up"></i>
		</span>
	</button>

	<script>
	// Variabel untuk <body> dan #btn-to-top
	let body = document.getElementsByTagName('body')[0]
	let btnToTop = document.getElementById('btn-to-top')

	// Fungsi untuk menampilkan button
	function showBtnToTop () {
		if (body.scrollTop > 400) {
			btnToTop.style.display = 'block'
		
		} else {
			btnToTop.style.display = 'none'
		}
	}

	// Fungsi untuk kembali ke atas
	function backToTop () {
		body.scrollTop = 0
	}

	// Jalankan fungsi ketika user melakukan scroll
	window.onscroll = () => showBtnToTop()

	// Default untuk menggunakan Wow.js
	wow = new WOW({}).init();
	</script>
</body>
</html>
