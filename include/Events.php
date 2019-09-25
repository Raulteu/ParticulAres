<?php
require_once __DIR__ . '/Aplication.php';

class Events implements \JsonSerializable{

    /* Attributes ---------------------------------------------------------------------*/

    private $id;
    private $nombre_clase;
    private $dia;
    private $fecha_ini;
    private $fecha_fin;
    private $hora_ini;
    private $duracion;
    private $intervalo;

    /* Construct  ---------------------------------------------------------------------*/

    private function __construct($array){
        $this->nombre_clase = $array['materia'];
        $this->dia = $array['dia'];
        $this->fecha_ini = $array['fecha_ini'];
        $this->fecha_fin = $array['fecha_fin'];
        $this->hora_ini = $array['hora_ini'];
        $this->duracion = $array['duracion'];
        $this->intervalo = $array['intervalo'];
    }

    /* Functions  ---------------------------------------------------------------------*/

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

    public static function creaEvento($id_clase, $fecha_ini, $hora_ini, $fecha_fin, $dia, $intervalo, $duracion) {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO fecha_clases(id_clase, fecha_ini, hora_ini, fecha_fin, dia, intervalo, duracion) VALUES ('%d', '%s', '%s', '%s', '%s', '%d', '%s')"
            , $conn->real_escape_string($id_clase)
            , $conn->real_escape_string($fecha_ini)
            , $conn->real_escape_string($hora_ini.":00")
            , $conn->real_escape_string($fecha_fin)
            , $conn->real_escape_string($dia)
            , $conn->real_escape_string($intervalo)
            , $conn->real_escape_string($duracion.":00"));
        if ( $conn->query($query) ) {
            $id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return null;
        }
        return $id;
    }

    public static function borraSuscripcion($id_alumno, $id_fecha_clase){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("DELETE FROM suscripciones WHERE id_alumno = '%d' AND id_fecha_clase = '%d'", $conn->real_escape_string($id_alumno), $conn->real_escape_string($id_fecha_clase));
        if ( !$conn->query($query) ) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    //REVISAR
    public static function borraEvento($id_evento) {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("DELETE FROM fecha_clases WHERE id = '%d'", $conn->real_escape_string($id_evento));
        if ( ! $conn->query($query) ) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function getEventos($id_alumno) {
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        /*$this->nombre_clase = $array['materia'];
        $this->dia = $array['dia'];
        $this->fecha_ini = $array['fecha_ini'];
        $this->fecha_fin = $array['fecha_fin'];
        $this->hora_ini = $array['hora_ini'];
        $this->duracion = $array['duracion'];
        $this->intervalo = $array['intervalo'];*/
        $query = sprintf("SELECT * FROM suscripciones S JOIN fecha_clases FC ON S.id_fecha_clase = FC.id JOIN clases C ON FC.id_clase = C.id WHERE id_alumno = '%d'", $conn->real_escape_string($id_alumno));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $evento = new Events($fila);
                $evento->id = $fila['id_fecha_clase'];
                $result[] = $evento;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function getHorarios($id_clase){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM fecha_clases WHERE id_clase = '%d'", $conn->real_escape_string($id_clase));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $result[] = $fila;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function addToCalendar($id_alumno, $id_fecha_clase){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO suscripciones(id_alumno, id_fecha_clase) VALUES ('%d', '%d')"
            , $conn->real_escape_string($id_alumno)
            , $conn->real_escape_string($id_fecha_clase));
        if ( $conn->query($query) ) {
            $id = $id_fecha_clase;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return null;
        }
        return $id;

    }

    public static function getSuscrispciones($id_alumno){
        $app = Aplication::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT id_fecha_clase FROM suscripciones WHERE id_alumno = '%d'"
            , $conn->real_escape_string($id_alumno));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = array();
            while ($fila = $rs->fetch_assoc()) {
                $fecha = $fila['id_fecha_clase'];
                $result[] = $fecha;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    /* GET's --------------------------------------------------------- */

    public function getId() { return $this->id; }

    public function getNombreClase() { return $this->nombre_clase; }

    public function getIdAlumno() { return $this->id_clase; }

    public function getDia() { return $this->dia; }

    public function getFechaHoraIni() { return ($this->fecha_ini == null) ? '' : $this->fecha_ini."T".$this->hora_ini; }

    public function getFechaFin() { return ($this->fecha_fin == null) ? '' : $this->fecha_fin; }

    public function getDuracion() { return $this->duracion; }

    public function getIntervalo() { return $this->intervalo; }

    public function getComoJSON() { return json_encode($this); }

    public function getDiaTraducido($day) {
        $dia = '';
        switch ($day) {
            case 'mo':
                $dia = 'Lunes';
                break;
            case 'tu':
                $dia = 'Martes';
                break;
            case 'we':
                $dia = 'Miércoles';
                break;
            case 'th':
                $dia = 'Jueves';
                break;
            case 'fr':
                $dia = 'Viernes';
                break;
            case 'sa':
                $dia = 'Sábado';
                break;
            case 'su':
                $dia = 'Domingo';
                break;
            default:
                break;
        }
        return $dia;
    }
}