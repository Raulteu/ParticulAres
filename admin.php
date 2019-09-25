<?php
require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/User.php';
require_once __DIR__.'/include/Advertisement.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <title>Mis chats</title>
</head>
<body>

<?php
    require_once __DIR__.'/include/comun/header.php';
?>
    <div class="container">
        <h1 class= "title">Panel de administrador</h1>
<?php 
        if (isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['es_admin']) {

            //Borra un usuario
            if (isset($_POST['users'])){
                $user = User::buscaUsuarioPorId($_POST['users']);
                if ($user){
                    if ($user->delete())
                        echo "<h1>User deleted</h1>";
                    else
                        echo "<h1>Error borrando usuario</h1>";
                }
            }

            //Borra un anuncio
            if (isset($_POST['anuncio'])){
                $result = Advertisement::getAnuncio($_POST['anuncio']);
                if ($result)
                    $borrado = $result->delete();
                if ($result && $borrado)
                    echo "<h1>Anuncio borrado</h1>";
                else
                    echo "<h1>Error borrando anuncio</h1>";
            }
            
            echo "<div class='login'>";

            echo "<form method='POST' action='admin.php'>";
            $users = User::getDemasUsuarios($_SESSION["id"]);
            echo "<select name='users' class='users'>";
            foreach ($users as $user){
                echo "<option value='". $user->getId() . "'>" . $user->getId() . " - ". $user->getNombre() ." " . $user->getApellidos() ." (". $user->getUsername() .")</option>";
            }
                echo "</select><button class='button' type='submit'>🗑️</button></form>";
            

            $ads = Advertisement::getAnuncios();
            echo "<form method='POST' action='admin.php'>";
            echo "<select name='anuncio' class='users'>";
            foreach ($ads as $ad)
                echo "<option value='". $ad->getId(). "'>". $ad->getId(). " - ". $ad->getMateria(). " [". $ad->getNivel() ."] (profesor: ". $ad->getIdProfesor() . ")</option>";
            echo "</select><button class='button' type='submit'>🗑️</button></form>";
            echo "</div>";

        }
        else {
            echo "<img class='centrar' src='img/cat.jpg'>";
        }

?>

    </div>

<?php
    require_once __DIR__.'/include/comun/footer.php';
?>

</body>
</html>

