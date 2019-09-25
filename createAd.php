<?php

require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/FormularioAd.php';

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="js/leaflet/leaflet.css"/>
	<script src="js/leaflet/leaflet.js"></script>
	<script src="js/leaflet/esri-leaflet.js"></script>
	<link rel="stylesheet" href="js/leaflet/esri-leaflet-geocoder.css">
	<script src="js/leaflet/esri-leaflet-geocoder.js"></script>
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
 	<script type="text/javascript" src="js/jsCreateAd.js"></script>
	<title>Crear anuncio</title>
</head>

<body>

<div id="content">

	<?php

		require_once __DIR__.'/include/comun/header.php';

		if (isset($_SESSION['login']) && $_SESSION['login'] == true){
			if (isset($_SESSION['es_profesor']) && $_SESSION['es_profesor'] == true){
				$form = new FormAd();
				$form->gestiona();
			}
			else{
				echo "<h1>Debes ser un profesor para crear anuncios</h1>";
			}
		}
		else{
			echo "<h1>Debes iniciar sesión para ver esta página</h1>";
		}
		
	?>


</div>

<?php
	require_once __DIR__.'/include/comun/footer.php';
?>

<script type="text/javascript">
	 	

	var mymap = L.map('mapid').setView([40.4165000, -3.7025600], 14);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

	var searchControl = L.esri.Geocoding.geosearch({useMapBounds: false, expanded: true, placeholder: 'Busca la zona donde impartir clase'}).addTo(mymap);

  	var results = L.layerGroup().addTo(mymap);

  searchControl.on('results', function(data){
    results.clearLayers();
    results.addLayer(L.marker(data.results[0].latlng));
    document.getElementById('zonaLbl').innerText = "Selecionado: " + data.results[0].text;
    document.getElementById('zona').value = data.results[0].text;
    document.getElementById('coords').value = data.results[0].latlng.lat + "," +data.results[0].latlng.lng;
  });


	 </script>
</body>
</html>
