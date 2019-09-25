<?php

require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/FormularioEditProfile.php';


?>

<!DOCTYPE html>
<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/jsEditProfile.js"></script>
	<title>MI PERFIL</title>
</head>

<body>


<?php
require_once __DIR__.'/include/comun/header.php';

echo '<div id="contenedor">';

	if (isset($_SESSION['login']) && $_SESSION['login'] == true)
	{
		$form = new FormEditProfile();
		$form->gestiona();
	}
	else
		echo '<h1 class="error">Debes estar logueado para ver esta página</h1>';
?>
</div>



<?php
	require_once __DIR__.'/include/comun/footer.php';
?>



</body>
</html>