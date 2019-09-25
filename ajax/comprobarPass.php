<?php
    require_once __DIR__.'/../include/User.php';
    
    if(password_verify($_GET["pass"], User::getPass())) { //El User::getPass() necesita tener un objeto $user para buscar su contraseña
                                                          // pero no se como conseguir el user
        echo "correcta";
    } else {
        echo "incorrecta";
    }
?>