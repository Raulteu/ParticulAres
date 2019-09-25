
<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__ . '/include/Message.php';
    if (isset($_SESSION['login']) && $_SESSION['login'] == true && isset($_GET['file']) && is_numeric($_GET['file'])){
        $message = Message::searchById($_GET['file']);
        
        if ($message && (($_SESSION['id'] == $message->getIdEmisor()) || ($_SESSION['id'] == $message->getIdReceptor())))
        {
            if ($message->hasFile())
            {
                $file_url = __DIR__ . '/uploads/chat/'. $_GET['file'];
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary"); 
                header("Content-disposition: attachment; filename=\"" . file_get_contents($file_url . '.data') . "\"");
                ob_get_clean(); //limpia el buffer antes de leer
                readfile($file_url);
            }
        }
    }