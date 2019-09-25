<?php

require_once __DIR__.'/../include/Advertisement.php';
require_once __DIR__.'/../include/config.php';

if (isset($_GET['id']))
{
    $anuncios = Advertisement::getAnunciosByAuthor($_SESSION['id']);
    foreach ($anuncios as $anuncio){
        if($anuncio->getId() === $_GET['id']){
           if($anuncio->delete())
                echo $anuncio->getId();
        }
    }
}
else
    echo "error";



?>