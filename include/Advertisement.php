<?php
require_once __DIR__ . '/Aplication.php';

class Advertisement{

    /* Attributes ---------------------------------------------------------------------*/

    private $id;
    private $id_profesor;
    private $materia;
    private $nivel;
    private $idioma;
    private $descripcion;
    private $zona;
    private $coords;
    private $precio;
    private $fecha;

    /* Construct  ---------------------------------------------------------------------*/

    private function __construct($array){

        $this->id_profesor = $array['id_profesor'];
        $this->materia = $array['materia'];
        $this->nivel = $array['nivel'];;
        $this->idioma = $array['idioma'];
        $this->descripcion = $array['descripcion'];
        $this->zona = $array['zona'];
        $this->coords = $array['coords'];
        $this->precio = $array['precio'];
        $this->fecha = $array['fecha'];
    }

    /* Functions  ---------------------------------------------------------------------*/

    public static function creaAnuncio($id_profesor, $materia, $nivel, $idioma, $descripcion, $zona,$coords, $precio) {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO clases(id_profesor, materia, nivel, idioma, descripcion, zona, coords, precio) VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', %d)"
            , $conn->real_escape_string($id_profesor)
            , $conn->real_escape_string($materia)
            , $conn->real_escape_string($nivel)
            , $conn->real_escape_string($idioma)
            , $conn->real_escape_string($descripcion)
            , $conn->real_escape_string($zona)
            , $conn->real_escape_string($coords)
            , $conn->real_escape_string($precio));
        if ( $conn->query($query) ) {
            $id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return null;
        }
        return $id;
    }

    //Sin probar
    public function delete() {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        
        $query=sprintf("SELECT * FROM fecha_clases WHERE id_clase = '%d'", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $query = sprintf("DELETE FROM suscripciones WHERE id_fecha_clase = '%d'", $conn->real_escape_string($fila['id']));
                if ( !$conn->query($query) )
                    return false;
            }
            $rs->free();
        }
        $query=sprintf("DELETE FROM fecha_clases WHERE id_clase = '%d'", $conn->real_escape_string($this->id));
        if ( !$conn->query($query))
            return false;
        $query=sprintf("DELETE FROM clases WHERE id = '%d'", $conn->real_escape_string($this->id));
        if ( !$conn->query($query) )
            return false;
        return true;
    }

    public static function getAnuncios() {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM clases");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $clase = new Advertisement($fila);
                $clase->id = $fila['id'];
                $result[] = $clase;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function getAnunciosByAuthor($id_profesor) {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM clases WHERE id_profesor = '%d'", $conn->real_escape_string($id_profesor));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $clase = new Advertisement($fila);
                $clase->id = $fila['id'];
                $result[] = $clase;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function getBestAnuncios() { //Devuelve los tres anuncios mas recientes
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM clases ORDER BY fecha DESC Limit 3");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $clase = new Advertisement($fila);
                $clase->id = $fila['id'];
                $result[] = $clase;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function getAnuncio($id_anuncio) {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM clases where id = '%d'", $conn->real_escape_string($id_anuncio));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $clase = new Advertisement($fila);
                $clase->id = $fila['id'];
                $result = $clase;
                
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    /**
     * Busca y devuelve los anuncios que coincidan con los parámetros dados.
     * Si no hay ninguno, un array vacío.
     *
     * @param String $materia Título de la clase a buscar, ignora mayúsculas y minúsculas
     * @param String $nivel Nivel de la clase
     * @param String $dia El día a buscar
     * @return Array|Bool array de Advertisement con los anuncios encontrados, false si falla
     */
    public static function buscaAnuncio($materia, $nivel){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        //Para poner un '%' en sprintf hay que poner '%%'
        $query = sprintf("SELECT * FROM clases WHERE UPPER(materia) LIKE UPPER('%%%s%%') 
                                               AND nivel LIKE '%%%s%%' 
                                               ORDER BY fecha DESC"
                        , $conn->real_escape_string($materia)
                        , $conn->real_escape_string($nivel));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $clase = new Advertisement($fila);
                $clase->id = $fila['id'];
                $result[] = $clase;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }
        return $result;
    }

    /**
     * Devuelve un array de posibles niveles que puede seleccionar el usuario
     */
    public static function getNiveles()
    {
        return array("Primaria", "Secundaria", "Bachillerato", "FP", "Universidad", "Otro");
    }


    /* GET's --------------------------------------------------------- */

    public function getId()
    {
        return $this->id;
    }

    public function getIdProfesor()
    {
        return $this->id_profesor;
    }

    public function getMateria()
    {
        return $this->materia;
    }

    public function getNivel()
    {
        return $this->nivel;
    }

    public function getIdioma(){
        return $this->idioma;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getZona(){
        return $this->zona;
    }

    public function getCoords(){
        return $this->coords;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function getFecha(){
        return $this->fecha;
    }
}