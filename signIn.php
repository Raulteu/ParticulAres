<?php

require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/FormularioRegistro.php';

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Entrar</title>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/jsSignIn.js"></script>
<script type="text/javascript" src="js/jsMaxFileSize.js"></script>
</head>

<body>
<?php require_once __DIR__.'/include/comun/header.php'; ?>
	<div id="contenedor">
<?php
	$form = new FormRegistro();
	$form->gestiona();
?>
	</div>
<?php	require_once __DIR__.'/include/comun/footer.php';?>
</body>
</html>