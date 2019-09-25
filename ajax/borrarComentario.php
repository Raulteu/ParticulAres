<?php

require_once __DIR__.'/../include/Comments.php';
require_once __DIR__.'/../include/config.php';

if (isset($_GET['id']))
{
    $comentarios = Comment::historialComentariosPorEmisor($_SESSION['id']);
    foreach ($comentarios as $comentario){
        if($comentario->getId() === $_GET['id']){
           if(Comment::borrarComentario($comentario->getId()))
                echo $comentario->getId();
        }
    }
}
else
    echo "error";



?>