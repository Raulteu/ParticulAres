<?php
require_once __DIR__.'/include/config.php';
require_once __DIR__.'/include/Chat.php';

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
    <div class="chat">
        <h1 class= "title">Mis chats</h1>
<?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            $chat = Chat::getChats($_SESSION['id']);
            if (!$chat)
                echo "Error en chats";
            $chats = $chat->getAllChats();
            foreach ($chats as $id => $chatData) {
                $nombre = $chatData['nombre'];
                $apellidos = $chatData['apellidos'];
                echo '<div class="chats">';
                echo "<h2>$nombre $apellidos</h2>";
                echo '<form method="POST" action="messages.php" id="chat' . $id. '">';
                echo '<div class="right">';
                echo '<button class="button" type="submit" name="receptor" value="'. $id .'">Ver conversación</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
            }
            echo '<form method="POST" action="messages.php" id="new_chat">';
            echo '<button class="button center" type="submit" name="new_chat" value="new_chat">Nueva conversación</button>';
            echo '</form>';

        } else {
            echo "<h2>Debes iniciar sesión para ver esta página.</h2>";
        }

?>

    </div>

<?php
    require_once __DIR__.'/include/comun/footer.php';
?>

</body>
</html>
