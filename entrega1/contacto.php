<!DOCTYPE html>
<html lang="es">
<head>
	<title>Contacto</title>
	<meta charset="utf-8">
</head>
<body>
	<?php require_once("links.php"); ?>
	<form action="mailto:contactaparticulares@gmail.com" method="POST">
		<fieldset>
			<legend>Contactenos para lo que necesite</legend>
			Nombre:<br>
			<input type="text" name="Nombre" required><br>
			Dirección de correo:<br>
			<input type="email" name="E-mail" required><br>
			Motivo de la consulta:<br>
			<input type="radio" name="Motivo" value="evaluacion" required> Evaluación<br>
			<input type="radio" name="Motivo" value="sugerencia"> Sugerencias<br>
			<input type="radio" name="Motivo" value="critica"> Criticas<br>
			<input type="checkbox" name="T&C" value="" required> Marque esta casilla para verificar que ha léido nuestros terminos y condiciones de servicio<br>
			<textarea name="Comentario" rows="10" cols="30"></textarea><br>
			<input type="submit" value="Enviar"/>
		</fieldset>
	</form>
</body>
</html>