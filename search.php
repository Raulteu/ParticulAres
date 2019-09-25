<?php

require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/Advertisement.php';

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Búsqueda</title>
</head>

<body>

<?php require_once __DIR__.'/include/comun/header.php'; ?>

	<div id="contenedor">
<?php
        //Solo comprueba estos 2 de momento
        $_GET['materia'] = isset($_GET['materia']) ? $_GET['materia'] : '';
        $_GET['nivel'] = isset($_GET['nivel']) ? $_GET['nivel'] : '';
       
        $anuncios = Advertisement::buscaAnuncio($_GET['materia'], $_GET['nivel']);
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
	</div>
<?php	require_once __DIR__.'/include/comun/footer.php';?>
</body>
</html>