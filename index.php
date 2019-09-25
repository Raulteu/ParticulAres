<!-- INICIO

- Buscar
Recoger de la base de datos los anuncios especificados

- Novedades
Cargar de la base de datos los últimos anuncios de profesores
 -->

<?php
	require_once __DIR__.'/include/config.php';
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>Index</title>
</head>
<body>
	
<?php
	require_once __DIR__.'/include/comun/header.php';
?>
<div id="contenedor">
	<h2>¿Qué hacemos?</h2>
  	<p>¡Da o recibe clases particulares! Carteles por las calles, números de teléfono sin verificar que pasan por mucha gente, etc. 
  	Te proponemos esta página web, donde tanto personas que quieran dar clases, como las que quieren recibirlas, 
	puedan ponerse en contacto, organizar bien los horarios y elegir su profesor o alumno según sus preferencias y 
	disponibilidad.</p> 

	<div class='search-index'> 
<?php
	$form = new FormBusqueda;
	$form->gestiona();
?>
	</div>

	<div class='novedades'>
	<h2> Novedades </h2>
<?php
	require("novedades.php");
?>
	</div>
	
</div>
	

<?php
	require_once __DIR__.'/include/comun/footer.php';
?>
</body>
</html>