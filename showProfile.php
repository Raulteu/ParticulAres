<?php

require_once __DIR__.'/include/User.php';
require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/FormularioEnviarPuntuacion.php';

?>

<!DOCTYPE html>
<html>
<head>

	<script type="text/javascript" src = "js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src = "js/showProfile.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Ver perfil</title>
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

</head>

<body>


<?php
require_once __DIR__.'/include/comun/header.php';

echo '<div id="contenedor">';

if (isset($_GET['id'])){
		$id = $_GET['id'];
		$user = User::buscaUsuarioPorId($id);
		if ($user)
		{
			$isLogged = isset($_SESSION['login']) && $_SESSION['login'] == true;

			//Redirección a mi perfil si abro el mio
			if ($isLogged && $_SESSION['id'] == $user->getId())
				echo "<script>window.location.href = 'showMyProfile.php';</script>";
				echo '<div class="admin">';
			echo '<div class="ad">';
			echo "<h1>".$user->getNombre()." ". $user->getApellidos(). "</h1>";
			echo '</div>';
			//Muestra la imagen si existe
			echo '<div>';
			if (file_exists(__DIR__ . "/uploads/user/" . $user->getId()))
				echo '<img class="profilePic userData" src="uploads/user/' . $user->getId() . '"/>';
			else
				echo '<img class="profilePic userData" src="uploads/user/default"/>';

			echo '<div class="marginLeft">';
			echo '<p><strong>Edad:</strong></p>';
			echo '<p>'.$user->getEdad().'</p>';
			echo '<p><strong>E-mail de contacto:</strong></p>';
			echo '<p>'.$user->getEmail().'</p>';
			echo '<p><strong>Móvil:</strong></p>';
			echo '<p>'.$user->getMovil().'</p>';
			echo '</div>';
			echo '</div>';

			echo '<div>';
			echo '<p><strong>Descripcion: </strong></p>';
			echo '<p>'.$user->getDescripcion().'</p>';
			echo '</div>';
			echo '</div>';

			echo '<p><strong>Puntuación media:</strong></p>';
			$fullScore = $user->getPuntuacionMedia();
			$n = round($fullScore);

			for($i=0; $i<$n; $i++) {
				echo '<span>★</span>';
			}
			for($i; $i<5; $i++) {
				echo '<span class>&#9734</span>';
			}

			echo '<span> ('.$fullScore.')</span>';

			if(User::yaHaPuntuado($_SESSION['id'], $user->getId()) == 0) {

				?><div>
					<?php
						$form = new EnviarPuntuacion("puntuar");
						$form->gestiona();
					?>
				</div>
				<?php
			}
			else {
				echo '<p><strong>Ya has puntuado</strong></p>';
			}

			if (isset($_SESSION['login']) && $_SESSION['login'] == true){
				echo'<form method="POST" action="messages.php" id="'. $user->getId() .'">
				<button class="button" type="submit" name="receptor" value="'. $user->getId() .'">Abrir conversación</button>
				</form>';
			}
			if (isset($_SESSION['login']) && $_SESSION['login'] == true){
				echo "<p>Pon tu comentario:</p>";
				$form = new FormularioComentarios('showProfile.php', array('action' => "showProfile.php?id=$id"));
				$form->gestiona();
			}
			else{
				echo "<h3>Debes estar logueado para escribir un comentario</h3>";
			}

			//Muestra los comentarios para este usuario
			$comentarios = Comment::historialComentarios($user->getId());
			if ($comentarios) {
				foreach ($comentarios as $comentario) {
					echo '<div class="comment" id="'.$comentario->getId().'">';
					echo '<strong>'.$comentario->getNombreEmisor().' '.$comentario->getApellidosEmisor().':</strong>';
					echo '<p>'.$comentario->getTexto().'</p>';
					if(isset($_SESSION['login']) && $_SESSION['login'] == true && $comentario->getIdEmisor() == $_SESSION['id'])
						echo '<button class="button comentario" name="borrarcoment" id="'.$comentario->getId().'" value="">🗑️</button>';
					echo '</div>';	
				}
			}
		}
}

else{
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