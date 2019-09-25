<?php

require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/Advertisement.php';

	$anuncios = Advertisement::getBestAnuncios();
	foreach ($anuncios as $anuncio => $anun) {
		echo '
		<div class="minAd">
			<div class="adName">
				<form method="GET" action="ad.php" id="minAd">
					<input type="hidden" name="ad_id" value="'.$anun->getId().'">
					<input class="submitLink" type="submit" value="'.$anun->getMateria().'">
				</form>
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



?>

