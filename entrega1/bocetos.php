<!DOCTYPE html>
<html lang="es">
<head>
  <title>Detalles</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="estilos.css">
  
</head>
<body>
	<?php require_once("links.php"); ?>
	<h1>Bocetos</h1>
	<p><a href="bocetos_particulAres.pdf">Ver en versión .pdf</a></p>
	<p>Contenido:</p>
	<ul>
		<li> <a href="#header">Header y footer</a></li>
		<li> <a href="#inicio">Inicio</a></li>
		<li> <a href="#registro">Registro</a></li>
		<li> <a href="#miCuenta">Mi cuenta</a></li>
		<li> <a href="#perfilProfe">Perfil de profesor</a></li>
		<li> <a href="#anuncios">Anuncios</a></li>
		<li> <a href="#about">Sobre nosotros y cómo funciona</a></li>
	</ul>
	
	<h2 id="header">Header y Footer</h2>
		<img class="imgBoceto" src="img/bocetos/Header.png" alt="Imagen del Header">
		<p>Este es el header. “Logo” es una imagen del logo de nuestra empresa; “materia”, “nivel” y “fecha”
		son campos para buscar tutores, y la imagen a su derecha es un botón con una lupa para introducir los datos.</p>
		<p>“Cómo funciona” nos lleva a una página explicando todo. “Iniciar sesión” y “registrarse” nos llevan a la
		página de inicio de sesión y registro respectivamente. Si has iniciado sesión ya aparece un botón con 
		“Mi cuenta”, y “Cerrar sesión”, en vez de esos 2.</p>
		  
		<img class="imgBoceto" src="img/bocetos/Footer.png" alt="Imagen del Footer">
		<p>Este es el footer. Muestra enlaces a otras páginas como por ejemplo la de términos y condiciones, y 
		enlaces a diversas redes sociales.</p>
		
	<h2 id="inicio">Inicio</h2>
		<img class="imgBoceto" src="img/bocetos/Inicio.png" alt="Imagen del Inicio">
		<p>Esta es la página de inicio que se vería al entrar. El header es una versión simplificada, ya que los 
		parámetros de búsqueda aparecen más abajo.</p>
		<p>En destacados aparecen algunos de los tutores con más puntuación.</p>
		
	<h2 id="registro">Registro</h2>
		<img class="imgBoceto" src="img/bocetos/registrar.png" alt="Imagen del registro">
		<p>Esta es la página de registro. Aparecen estos campos obligatorios y otros campos que pudieran ser necesarios.
		Al pinchar la foto aparece un selector de archivo para subir nuestra imagen. Si se selecciona “¿Eres profesor?”, 
		el botón de siguiente nos lleva a la página a continuación.</p>

		<img class="imgBoceto" src="img/bocetos/pago.png" alt="Imagen del pago">
		<p>Nos permite elegir la forma de pago, datos de la cuenta… Esta solo aparece si somos profesores.</p>
		
	<h2 id="miCuenta">Mi cuenta</h2>
		<img class="imgBoceto" src="img/bocetos/MiCuentaAlumno.png" alt="Imagen de la cuenta del alumno">
		<p>Esta página es la que aparece cuando damos a “Mi cuenta” siendo usuarios. Nos permitirá editar los campos si 
		pulsamos editar, y los guardará al pulsar en “Guardar cambios”. También nos permite cambiar la foto y elegir la ubicación.</p>
		
		<img class="imgBoceto" src="img/bocetos/MiCuentaProfesor.png" alt="Imagen de la cuenta del profesor">
		<p>Esta es la que aparece al dar a “Mi cuenta” siendo profesor. Nos permite editar más campos que a un alumno, y nos 
		permite editar el calendario. Es susceptible a cambios.</p>
		
	<h2 id="perfilProfe">Perfil profesor</h2>
		<img class="imgBoceto" src="img/bocetos/PerfilProfesores.png" alt="Imagen del perfil del profesor">
		<p>Esto es como un alumno vería un a un profesor. Todos los datos son bastante autodescriptivos, y las valoraciones 
		son de otros alumnos, y aparecen como una puntuación junto a un comentario. También podemos dejar desde esta misma 
		página nuestra valoración.</p>
		
	<h2 id="anuncios">Anuncios</h2>
		<img class="imgBoceto" src="img/bocetos/Anuncio.png" alt="Imagen de un anuncio">
		<p>Este es un anuncio tal cual aparecería a un alumno. El cuadro de la derecha sería una forma de pedir la clase,
		y ver el precio al que saldría, y donde podemos ir viendo varios parámetros.</p>
		
		<img class="imgBoceto" src="img/bocetos/Añadir anuncio.png" alt="Imagen de añadir anuncio">
		<p>Esta es una página en la que los profesores pueden crear sus anuncios. Es probable que añadamos más campos a este
		formulario. Los profesores pueden elegir también si están dispuestos a desplazarse, o si desean cobrar más por desplazamiento.</p>
		
	<h2 id="about">Sobre nosotros y cómo funciona</h2>
		<img class="imgBoceto" src="img/bocetos/Sobre nosotros-como funciona.png" alt="Imagen de 'Sobre nosotros'">
		<p>Esta es la página de “Cómo funciona”, donde tendremos texto y img con información sobre estos 3 temas.</p>
		
</body>
</html>