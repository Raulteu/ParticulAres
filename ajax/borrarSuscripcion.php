<?php

require_once __DIR__.'/../include/Comments.php';
require_once __DIR__.'/../include/config.php';
require_once __DIR__.'/../include/Events.php';


if (isset($_SESSION['login']) && $_SESSION['login'] === true && isset($_GET['id']))
{
    Events::borraSuscripcion($_SESSION['id'], $_GET['id']);
}



?>