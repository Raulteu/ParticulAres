<?php
	require_once __DIR__.'/include/config.php';

	//Doble seguridad: unset + destroy
	unset($_SESSION["login"]);
	unset($_SESSION["esAdmin"]);
	unset($_SESSION["nombre"]);
	unset($_SESSION['receptor']);
	unset($_SESSION['id']);

	session_destroy();
	echo "<script>window.location.href = 'index.php'</script>";
?>
