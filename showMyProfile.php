<?php

require_once __DIR__.'/include/config.php';

?>

<!DOCTYPE html>
<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>MI PERFIL</title>
</head>

<body>


<?php
require_once __DIR__.'/include/comun/header.php';

echo '<div id="contenedor">';

if (isset($_SESSION['login']) && $_SESSION['login'] === true){
	$id = $_SESSION['id'];
	$user = User::buscaUsuarioPorId($id);
	if ($user){
		echo '<div class="login">';
		echo  '<div class="ad">';
			echo "<h1>" . $user->getNombre() . " " . $user->getApellidos() . "</h1>
			<a class='flex' href='editMyProfile.php'><button class='button' type='submit' name='receptor' value='editMyProfile.php'>Editar perfil</button></a>";
		echo '</div>';
		//Muestra la imagen si existe
		echo '<div>';
		if (file_exists(__DIR__ . "/uploads/user/" . $user->getId()))
			echo '<img class="profilePic userData" src="uploads/user/' . $user->getId() . '"/>';
		else
			echo '<img class="profilePic userData" src="uploads/user/default"/>';
			
		echo '<div class="marginLeft">';
		echo '<p><strong>Edad:</strong></p>';
		echo '<p>' . $user->getEdad() . '</p>';
		echo '<p><strong>E-mail de contacto:</strong></p>';
		echo '<p>'.$user->getEmail().'</p>';
		echo '<p><strong>Móvil:</strong></p>';
		echo '<p>'.$user->getMovil().'</p>';
		echo '<p><strong>Descripcion: </strong></p>';
		echo '<p>'.$user->getDescripcion().'</p>';

		

		echo '</div>';
		echo '</div>';
		echo '</div>';
	
		



		if ($_SESSION['es_profesor'] == true){
			echo '<p><strong>Puntuación media:</strong></p>';

			$n = round($user->getPuntuacionMedia());


			for($i=0;$i<$n;$i++){
				echo '<span>★</span>';
			}
			for($i;$i<5;$i++){
				echo '<span>☆</span>';
			}

			//Muestra los comentarios para este usuario
			$comentarios = Comment::historialComentarios($user->getId());
			if ($comentarios) {
				foreach ($comentarios as $comentario) {
					echo '<div class="comment">';
					echo '<strong>'.$comentario->getNombreEmisor().' '.$comentario->getApellidosEmisor().':</strong>';
					echo '<p>'.$comentario->getTexto().'</strong>';
					echo '</div>';
					//Aquí se puede poner un botón de elminiar comentario. Para evitar abusos lo mismo en vez de eliminar se puede cambiar el contenido 
					//a [eliminado] o algo así
				}
			}
		}
	}
} else {
	echo "<h1>Error</h1>";
}

unset($_POST['verperfil']);





?>
</div>



<?php
	require_once __DIR__.'/include/comun/footer.php';
?>



</body>
</html>