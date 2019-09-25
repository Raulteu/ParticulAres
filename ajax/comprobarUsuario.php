<?php
	require_once __DIR__.'/../include/User.php';
	if (isset($_GET['user']))
	{
		$usuario = User::buscaUsuario($_GET["user"]);
		if(!$usuario){
			echo "disponible";
		} else {
			echo "existe";
		}
	}
	else echo "error";
?>