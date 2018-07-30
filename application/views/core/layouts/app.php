<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Membuat title secara dinamis -->
	<title><?= $title ?></title>

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

	<script>
	// Default untuk menggunakan Wow.js
	wow = new WOW({}).init();
	</script>
</body>
</html>
