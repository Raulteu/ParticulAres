<?php   
    class Chat{
        private $chats; //es un array de la forma "id" => [array con campos];

        public static function getChats($user_id)
        { 
            $app = Aplication::getSingleton();
            $conn = $app->conexionBd();
            $query = sprintf("SELECT DISTINCT U.id, U.username, U.nombre, U.apellidos, M.fecha FROM mensajes M JOIN usuario U 
            ON (M.id_emisor = U.id OR M.id_receptor = U.id) WHERE (M.id_emisor = %d OR M.id_receptor = %d) ORDER BY fecha DESC", 
             $conn->real_escape_string($user_id),
             $conn->real_escape_string($user_id)); //Se pueden seleccionar más cosas si es necesario
            $result = $conn->query($query);
            if (!$result) {
                echo $conn->error;
                        return FALSE; //Hay un error en consulta
            }
                
            $chatsArray = array();
            while ($row = $result->fetch_assoc()) {

                if ($row['id'] != $user_id)
                {
                    $chat = array();
                    $chat['username'] = $row['username'];
                    $chat['nombre'] = $row['nombre'];
                    $chat['apellidos'] = $row['apellidos'];
                    $chatsArray[$row['id']] = $chat;
                }
            }
            return new Chat($chatsArray);
        }

        public function __construct($chats)
        {
            $this->chats = $chats;
        }

        //devuelve el array completo
        public function getAllChats()
        {
            return $this->chats;
        }

        //USO DE ESTA CLASE
        //$chat = Chat::getChats;
        //$chat->getAllChats();
        //foreach ($chat as $key => $value)
        //key es el id, value contiene apellido, nombre, username

    }