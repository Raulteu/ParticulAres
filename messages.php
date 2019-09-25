<?php
	require_once __DIR__ . '/include/config.php';
	require_once __DIR__ . '/include/Message.php';
	require_once __DIR__ . '/include/FormularioMessages.php';
?>
<!DOCTYPE html>
<html>
<head>

	<script type="text/javascript" src = "js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src = "js/chat.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/jsMaxFileSize.js"></script>
	<script type="text/javascript" src="js/jsChatMessage.js"></script>
	<title>Chat</title>
</head>
<body>

<?php
	require_once __DIR__.'/include/comun/header.php';

	function getDownloadLink($message){
		//Si hay archivo
		if ($message->hasFile()){
			$route = __DIR__ . '/uploads/chat/'. $message->getId();
			echo '<a class="download" href="download.php?file='.$message->getId().'">⬇ '.  file_get_contents($route . '.data'). '</a>';
		}
	}
	
?>
	<h1 class= "title">Sala de chat</h1>

		<?php
			if (isset($_SESSION['login']) && $_SESSION['login'] == true) { 
				//Cuando selecionemos receptor lo almacenamos en la session para poder saber a quien nos referimos al enviar mensajes

				if (isset($_POST['new_chat'])){ 
					$users = User::getDemasUsuarios($_SESSION["id"]);
					$numUsers = sizeof($users);
					echo "<div class='nuevochat'>";
						for ($i=0; $i < $numUsers; $i++) { 
							echo "<div class='chatusuario'>";
							echo $users[$i]->getUsername();
							echo '<form method="POST" action="messages.php" id="'. $users[$i]->getId() .'">';
                				echo '<button class="button" type="submit" name="receptor" value="'. $users[$i]->getId() .'">Abrir</button>';
                			echo '</form></div>';
						}
					echo "</div>";
					unset($_POST['new_chat']);
				}
				else {
					echo "<div class='conversacion'>";
					echo "<div class='mensajes'>";
					if (isset($_POST['receptor']) && is_numeric($_POST['receptor'])) {
						$_SESSION['receptor'] = $_POST['receptor'];
					}
					if (isset($_SESSION['receptor']) && is_numeric($_SESSION['receptor'])){
						if ($_SESSION['receptor'] != $_SESSION['id']){
							$user = User::buscaUsuarioPorId($_SESSION["id"]);
							$mensajes = Message::historialMensajes($_SESSION['id'], $_SESSION['receptor']); //Se cogerian el como 1 al usu actual y el 2 una variable en SESSION que cambie en funcion de la conversacion que se haya selecionado
							$numMensajes = sizeof($mensajes);
							for ($i=0; $i < $numMensajes; $i++) { 
								if($_SESSION["id"] == $mensajes[$i]->getIdEmisor()){
									echo '<div class="msgOUT" id="'.$mensajes[$i]->getId().'">';
									getDownloadLink($mensajes[$i]);
									echo "<p>".$mensajes[$i]->getTexto()."</p> <span class='timeOUT'> ".$mensajes[$i]->getFecha()."</span>";
									echo '<button class="button mensaje" name="borrarcoment" id="'.$mensajes[$i]->getId().'" value="">🗑️</button></div>';
								}
								else{
									echo "<div class='msgIN'>";
									getDownloadLink($mensajes[$i]);
									echo "<p>".$mensajes[$i]->getTexto()."</p><span class='timeIN'>".$mensajes[$i]->getFecha()."</span></div>";
								}
							}
							echo "</div>";
							echo "<div class='formEnviar'>";
							$formId = "messages.php";
							$form = new FormularioMessages($formId, array('action' => "messages.php"));
							$form->gestiona();
							$receptor = User::buscaUsuarioPorId($_SESSION["receptor"]);
							echo "</div>";
							echo "<a href='chat.php'><button class='button center'>Atrás</button></a>
							<h2 class='title'>".$receptor->getNombreCompleto()."</h2>";
						}
						else
							echo "<h2>No puedes chatear contigo.</h2>";
						
					}
				}
			} else{
				echo "<h2>Debes estar logueado para ver un chat</h2>";
			}
?>
	</div>

<?php
	require_once __DIR__.'/include/comun/footer.php';
?>

</body>
</html>