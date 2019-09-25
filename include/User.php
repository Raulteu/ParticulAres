<?php
require_once __DIR__ . '/Aplication.php';
require_once __DIR__ . '/FormularioComentarios.php';
require_once __DIR__ . '/Advertisement.php'; //Para el delete

class User
{

    public static function login($nombreUsuario, $password)
    {
        $user = self::buscaUsuario($nombreUsuario);

        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.username = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new User($fila);
                $user->id = $fila['id'];
                $result = $user;
                
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function buscaUsuarioPorId($id)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.id = '%d'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new User($fila);
                $user->id = $fila['id'];
                $result = $user;  
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($array)
    {
        $user = self::buscaUsuario($array['username']);
        if ($user) {
            return false;
        }
        $user = new User($array);
        return self::guarda($user);
    }
    
    private static function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function guarda($usuario)
    {
        if ($usuario->id !== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }

    private static function inserta($user)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO usuario(username, pass, email, movil, nombre, apellidos, edad, es_profesor,
                        descripcion, puntuacion_media, num_puntuaciones) VALUES('%s', '%s', '%s', '%s', '%s', '%s', %d, '%d', '%s', '%d', '%d')"
            , $conn->real_escape_string($user->username)
            , self::hashPassword($user->pass)
            , $conn->real_escape_string($user->email)
            , $conn->real_escape_string($user->movil)
            , $conn->real_escape_string($user->nombre)
            , $conn->real_escape_string($user->apellidos)
            , $conn->real_escape_string($user->edad)
            , $conn->real_escape_string($user->es_profesor)
            , $conn->real_escape_string($user->descripcion)
            , $conn->real_escape_string($user->puntuacion_media)
            , $conn->real_escape_string($user->num_puntuaciones));
        if ( $conn->query($query) ) {
            $user->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        if($user->iban != null){
            $query=sprintf("INSERT INTO profesor_datos(id, IBAN) VALUES('%s', '%s')"
                , $conn->real_escape_string($user->id)
                , $conn->real_escape_string($user->iban)
            );
            echo "He entrado";
            if ( !$conn->query($query) ) {
                echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }

        
        return $user;
    }
    
    public static function actualiza($user)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE usuario U SET username = '%s', email='%s', movil='%s', nombre='%s', apellidos='%s',
                        edad=%d, es_profesor='%d', descripcion='%s' WHERE U.id=%d"
        , $conn->real_escape_string($user['username'])
        , $conn->real_escape_string($user['email'])
        , $conn->real_escape_string($user['movil'])
        , $conn->real_escape_string($user['nombre'])
        , $conn->real_escape_string($user['apellidos'])
        , $conn->real_escape_string($user['edad'])
        , $conn->real_escape_string($user['es_profesor'])
        , $conn->real_escape_string($user['descripcion'])
        , $user['id']);

            
        if ( !$conn->query($query) ) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        if (isset($user['pass'])){
            $query2= sprintf("UPDATE usuario U SET pass='%s' WHERE U.id=%d", self::hashPassword($user['pass']),  $user['id']);
            if ( !$conn->query($query2) ) {
                echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }
        return $user;
    }

    public static function getDemasUsuarios($idUsuario)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.id != '%s'", $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $user = new User($fila);
                $user->id = $fila['id'];
                $result[] = $user;
            }
            $rs->free();
        }
        return $result;
    }

    public static function puntuarUsuario($idUsuario, $puntuacion, $idPuntuado)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT num_puntuaciones FROM usuario WHERE (id = '%d')", $conn->real_escape_string($idPuntuado));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        if ( ! $rs ) {
            return 0;
        }

        $num_puntuaciones = $fila['num_puntuaciones'];

        $query = sprintf("SELECT puntuacion_media FROM usuario WHERE (id = '%d')", $conn->real_escape_string($idPuntuado));
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        if ( ! $rs ) {
            return 0;
        }

        $puntuacion_media_old = $fila['puntuacion_media'];

        //Calculo de la nueva media
        $puntuacion_media = (($puntuacion_media_old * $num_puntuaciones) + $puntuacion)/($num_puntuaciones + 1);

        $num_puntuaciones += 1;

        $query=sprintf("UPDATE usuario SET puntuacion_media = '%f' WHERE (id = '%d')", $conn->real_escape_string($puntuacion_media), $conn->real_escape_string($idPuntuado));
        if ( ! $conn->query($query) ) {
            return 0;
        }

        $query=sprintf("UPDATE usuario SET num_puntuaciones = '%d' WHERE (id = '%d')", $conn->real_escape_string($num_puntuaciones), $conn->real_escape_string($idPuntuado));
        if ( ! $conn->query($query) ) {
            return 0;
        }

        $query=sprintf("INSERT INTO puntuaciones (id_puntua, id_puntuado) VALUES ('%d', '%d')", $conn->real_escape_string($idUsuario), $conn->real_escape_string($idPuntuado));
        if ( ! $conn->query($query) ) {
            return 0;
        }

        return 1;
    }


    public static function yaHaPuntuado($idPuntua, $idPuntuado)
    {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT * FROM puntuaciones WHERE (id_puntua = '%d' and id_puntuado = '%d')", $conn->real_escape_string($idPuntua), $conn->real_escape_string($idPuntuado));
        $rs = $conn->query($query);
        if ($rs) {
            if ( $rs->num_rows == 0) {
                return 0;
            }
        }
        return 1;
    }

    //El archivo suele venir ya validado, pero se valida aquí de nuevo de otra manera.
    //Si ya existe se sobreescribe
    public function setPhoto($file){
        if (exif_imagetype($file['tmp_name']))
            move_uploaded_file($file["tmp_name"], __DIR__ . "/../uploads/user/" . $this->id);
    }

    //Borra el usuario y todo lo correspondiente
    public function delete(){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        //FALTA POR BORRAR ALGUNAS COSAS DE CLASE. 
        $query = sprintf("DELETE FROM comentarios_usuarios WHERE id_emisor = %d OR id_receptor = %d", $conn->real_escape_string($this->id), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if (!$rs) 
             return false;
        $query = sprintf("DELETE FROM mensajes WHERE id_emisor = %d OR id_receptor = %d", $conn->real_escape_string($this->id), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if (!$rs)
             return false;
        $query = sprintf("DELETE FROM profesor_datos WHERE id = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if (!$rs) 
             return false;
        $query = sprintf("DELETE FROM puntuaciones WHERE id_puntua = %d OR id_puntuado = %d", $conn->real_escape_string($this->id), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if (!$rs) 
            return false;
        $query = sprintf("DELETE FROM suscripciones WHERE id_alumno = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if (!$rs) 
             return false;
        $myAds = Advertisement::getAnunciosByAuthor($this->id);
        foreach ($myAds as $ad)
            $ad->delete();

        $query = sprintf("DELETE FROM usuario WHERE id = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if (!$rs) 
             return false;

        return true;
    }

    private $id; // AUTO_INCREMENTED

    private $username;

    private $pass;

    private $email;

    private $movil;

    private $nombre;

    private $apellidos;

    private $edad;

    private $es_profesor;

    private $descripcion;

    private $puntuacion_media;

    private $num_puntuaciones;

    private $es_admin;

    private $iban;

    private function __construct($array)
    {
        $this->username= $array['username'];
        $this->pass = $array['pass'];
        $this->email = $array['email'];
        $this->movil = $array['movil'];
        $this->nombre = $array['nombre'];
        $this->apellidos = $array['apellidos'];
        $this->es_profesor = $array['es_profesor'];
        $this->descripcion = NULL;
        $this->edad = $array['edad'];
        $this->puntuacion_media = isset($array['puntuacion_media']) ? $array['puntuacion_media'] : 0;
        $this->num_puntuaciones = 0;
        $this->descripcion = isset($array['descripcion']) ? $array['descripcion'] : '';
        $this->iban = isset($array['iban']) ? $array['iban'] : null;
        $this->es_admin = isset($array['es_admin']) ? $array['es_admin'] : false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMovil(){
        return $this->movil;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellidos(){
        return $this->apellidos;
    }

    public function getNombreCompleto(){
        return $this->nombre.' '.$this->apellidos;
    }

    public function getEdad(){
        return $this->edad;
    }

    public function getEsProfesor(){
        return $this->es_profesor;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getPuntuacionMedia(){
        return $this->puntuacion_media;
    }
    public function getNumPuntuaciones(){
        return $this->num_puntuaciones;
    }

    public function getEsAdmin(){
        return $this->es_admin;
    }
    public function compruebaPassword($password)
    {
        return password_verify($password, $this->pass);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->pass = self::hashPassword($nuevoPassword);
    }
}
