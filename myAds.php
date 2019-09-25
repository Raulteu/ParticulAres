<!DOCTYPE html>
<html>

<head>

	<script type="text/javascript" src = "js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src = "js/myAds.js"></script>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>Index</title>
</head>
<body>

<?php
require_once __DIR__.'/include/comun/header.php';
?>
<div id="contenedor">
	<?php
require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/Advertisement.php';

if (isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['es_profesor'] == true)
{
	$anuncios = Advertisement::getAnunciosByAuthor($_SESSION['id']);
	foreach ($anuncios as $anuncio => $anun) {
		echo '
		<div class="minAd" id="'.$anun->getId().'">
			<div class="adName">
				<form method="GET" action="ad.php" id="minAd">
					<input type="hidden" name="ad_id" value="'.$anun->getId().'">
					<input class="submitLink" type="submit" value="'.$anun->getMateria().'">
				</form>';
				if(isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['es_profesor'] == true && $anun->getIdProfesor() == $_SESSION['id'])
				echo '<button class="button anuncio" name="borraranuncio" id="'.$anun->getId().'" value="">🗑️</button>';
		echo '
			</div>
			<div class="ad">	
				<article class="simpleBack">
					<p><strong>Nivel: </strong>'.$anun->getNivel().'&emsp;<strong>Zona: </strong>'.$anun->getZona().'</p>
				</article>
				<aside class="orangeBack">
					<p><strong>Precio: </strong>'.$anun->getPrecio().' € la hora</p>
				</aside>
			</div>
		</div>';
		}
	}


?>
</div>
<?php
	require_once __DIR__.'/include/comun/footer.php';
?>
</body>
</html>

