<?php
	require_once __DIR__.'/include/config.php';
	require_once __DIR__ . '/include/Events.php';
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<title>Mi calendario</title>
	<link href='js/fullcalendar/core/main.css' rel='stylesheet' />
	<link href='js/fullcalendar/daygrid/main.css' rel='stylesheet' />
	<link href='js/fullcalendar/timegrid/main.css' rel='stylesheet' />
	<link href='js/fullcalendar/list/main.css' rel='stylesheet' />
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src='js/fullcalendar/rrule.js'></script>
	<script src='js/fullcalendar/core/main.js'></script>
	<script src='js/fullcalendar/core/locales/es.js'></script>
	<script src='js/fullcalendar/daygrid/main.js'></script>
	<script src='js/fullcalendar/timegrid/main.js'></script>
	<script src='js/fullcalendar/list/main.js'></script>
	<script src='js/fullcalendar/rrule/main.js'></script>
	<script type="text/javascript" src="js/jsCalendar.js"></script>
</head>
<body>
	
<?php
	require_once __DIR__.'/include/comun/header.php';
?>
<div id="contenedor">

 
	<div id='calendar'></div>
	<?php
		echo "<div id='hidden'>";
		$eventos = Events::getEventos($_SESSION['id']);
		$eventosJson = [];
		foreach ($eventos as &$e) {
			$eventosJson[] = $e->getComoJSON();
		}
		echo "</div>\n";
		echo "<script> const eventos = [\n\t" . implode(",\n\t", $eventosJson) . "];\n </script>";

	?>
	

</div>
	

<?php
	require_once __DIR__.'/include/comun/footer.php';
?>
</body>
</html>