<?php
require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/Advertisement.php';
require_once __DIR__.'/include/Events.php';

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="js/leaflet/leaflet.css" />
	<script src="js/leaflet/leaflet.js"></script>
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/jsAddToCalendar.js"></script>
	<title>Anuncio</title>
</head>

<body>
<?php
	//Asume que el anuncio siempre es válido pero no siempre es asi
	//Habría que meter todo el html en php pero me parece horrendo
	
	if (isset($_GET['ad_id'])) {
		$anuncio = Advertisement::getanuncio($_GET['ad_id']); // id_anuncio
		$horarios = Events::getHorarios($_GET['ad_id']);
	} else
		echo "<script>window.location.href = 'index.php'</script>"; //Chapuza temporal

	if(isset($_SESSION['login']) && isset($_SESSION['login']) == true){
		$suscripciones = Events::getSuscrispciones($_SESSION['id']);
	}

	if (!$anuncio)
		echo "<script>window.location.href = 'index.php'</script>";
	require_once __DIR__.'/include/comun/header.php';
	
?>
<div id="contenedor">
<?php
	$profesor = User::buscaUsuarioPorId($anuncio->getIdProfesor());
	echo '<div class="fullAd">
			<div class="adName">
				<h1>'.$anuncio->getMateria().'</h1>
			</div>
			<div class="ad">	
				<article class="simpleBack">
					<p><strong>Profesor:</strong></p>
					<div class="flex">
						<p>'.$profesor->getNombreCompleto().'&emsp;</p>
							<a class="flex" href=showProfile.php?id='.$anuncio->getIdProfesor().'><button class="button" name="verperfil">Ver Perfil</button></a>';
					if (isset($_SESSION['login']) && isset($_SESSION['login']) == true
						&& isset($_SESSION['es_profesor']) && $_SESSION['es_profesor'] == false
						&& isset($_SESSION['id']) && $anuncio->getIdProfesor() != $_SESSION['id']){
						echo '
						<form class="flex" method="POST" action="messages.php" id="'. $anuncio->getIdProfesor() .'">
							<button class="button" type="submit" name="receptor" value="'. $anuncio->getIdProfesor() .'">Abrir conversación</button>
						</form>';
					}
					echo '
					</div>
					<p><strong>Nivel:</strong></p>
					<p>'.$anuncio->getNivel().'</p>
					<p><strong>Descripción:</strong></p>
					<p class="adDescription">'.$anuncio->getDescripcion().'</p>
					<p><strong>Zona:</strong></p><p>'.$anuncio->getZona().'</p>';
					$coords = explode(",",$anuncio->getCoords());
					$lat = $coords[0];
					$lng = $coords[1];
?>
					<div id="mapid"></div>
<?php
				echo '
				</article>
				<aside id="asideHorarios" class="orangeBack">
					<p><strong>Precio:</strong></p>
					<p>'.$anuncio->getPrecio().' € la hora</p>
					<p><strong>Horario:</strong></p>
					<p>Del '.date("d-m-Y",strtotime($horarios[0]['fecha_ini'])).' al '.date("d-m-Y",strtotime($horarios[0]['fecha_fin']))."\n</p>";
					foreach ($horarios as &$horario) {
						echo "<div class='horario'>".
							Events::getDiaTraducido($horario['dia']);
						echo "<p>Hora: ".substr($horario['hora_ini'], 0, 5)." Duracion: ".substr($horario['duracion'], 0, 5)."h</p><p>Cada ";
						if ($horario['intervalo'] == 1)
							echo "semana";
						else
							echo $horario['intervalo']." semanas";
						echo "</p>";
						if(isset($_SESSION['login']) && isset($_SESSION['login']) == true){
							if (in_array($horario["id"], $suscripciones)){
								echo '<p><strong>Clase ya añadida</strong></p>';
							} else 
								echo '<button id="claseId'.$horario["id"].'" class="button botonHorario">Añadir al calendario</button>';
						} else 
							echo '<p>Debes iniciar sesion añadir eventos</p>';
						echo '</div>';
					}

				echo '
				</aside>
			</div>
		</div>';
?>
</div>

<?php
	require_once __DIR__.'/include/comun/footer.php';		
?>	

<script type="text/javascript">
		let mymap = L.map('mapid').setView(["<?php echo str_replace(',', '.', $lat) ?>", "<?php echo str_replace(',', '.', $lng) ?>"], 14);
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

	L.circle(["<?php echo str_replace(',', '.', $lat) ?>", "<?php echo str_replace(',', '.', $lng) ?>"], 500, {
		color: 'red',
		fillColor: '#f03',
		fillOpacity: 0.5
	}).addTo(mymap);
	</script>
</body>
	
</html>