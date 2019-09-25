<?php

require_once __DIR__ . '/../include/Message.php';
require_once __DIR__.'/../include/config.php';

if (isset($_GET['id']))
{
    $mensajes = Message::historialMensajes($_SESSION['id'], $_SESSION['receptor']);
    foreach ($mensajes as $mensaje){
        if($mensaje->getId() === $_GET['id']){
           if(Message::borra($mensaje->getId()))
                echo $mensaje->getId();
        }
    }
}
else
    echo "error";



?>