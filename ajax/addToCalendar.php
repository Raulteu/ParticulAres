<?php

require_once __DIR__.'/../include/Events.php';
require_once __DIR__.'/../include/config.php';



if (isset($_GET['id'])){
	$id_clase = substr($_GET['id'], 7);
	$evento = Events::addToCalendar($_SESSION['id'], $id_clase);
	if($evento != null){
		echo $evento;
	} else {
		echo "error";
	}
} else
	echo "error";
?>