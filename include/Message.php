<?php
require_once __DIR__ . '/Aplication.php';
require_once __DIR__ . '/User.php';

class Message {

	private $id;
	private $idEmisor;
	private $idReceptor;
	private $texto;
	private $fecha;

	private function __construct($idEmisor, $idReceptor, $texto) {
		$this->idEmisor= $idEmisor;
		$this->idReceptor= $idReceptor;
		$this->texto = $texto;
	}

	public static function historialMensajes($idEmisor, $idReceptor) {	  
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM mensajes M WHERE (M.id_emisor = '%s' AND M.id_receptor = '%s') OR (M.id_emisor = '%s' AND M.id_receptor = '%s') ORDER BY fecha DESC", $conn->real_escape_string($idEmisor), $conn->real_escape_string($idReceptor),  $conn->real_escape_string($idReceptor), $conn->real_escape_string($idEmisor));
		$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			$result = array();
			while ($fila = $rs->fetch_assoc()) {
			$historial = new Message($fila['id_emisor'], $fila['id_receptor'], $fila['texto']);
			$historial->setFecha($fila['fecha']);
			$historial->id = $fila['id'];
			$result[] = $historial;
			}
			$rs->free();
		} else {
			echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
		return $result;
	}

	public static function searchById($id){
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM mensajes M WHERE id = %d", $conn->real_escape_string($id));
		$rs = $conn->query($query);
		if ($rs) {
			if ( $rs->num_rows == 1) {
				$fila = $rs->fetch_assoc();
				$message = new Message($fila['id_emisor'], $fila['id_receptor'], $fila['texto']);
				$message->id = $fila['id'];
				return $message;
			}
		}
		return null;
	}

	public static function ultimosMensajes($idEmisor) {
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM mensajes M WHERE M.id_emisor = '%s'OR M.id_receptor = '%s' ORDER BY fecha DESC", $conn->real_escape_string($idEmisor), $conn->real_escape_string($idEmisor));
		$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			$result = array();
			$ids = array();
			while ($fila = $rs->fetch_assoc()) {
				$idReceptor = ($idEmisor == $fila['id_emisor']) ? $fila['id_receptor'] : $idEmisor;
				if(! in_array($idReceptor, $ids)){
					$ids[] = $idReceptor;
					$ultimos = new Message($fila['id_emisor'], $fila['id_receptor'], $fila['texto']);
					$ultimos->setFecha($fila['fecha']);
					$ultimos->id = $fila['id'];
					$result[] = $ultimos;
				}
			}
			$rs->free();
		} else {
			echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
		return $result;
	}
	
	public static function crea($idEmisor, $idReceptor, $texto) {
		$mensaje = new Message($idEmisor, $idReceptor, htmlspecialchars($texto));
		return self::inserta($mensaje);
	}

	public static function borra($idmensaje) {
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();

		$query=sprintf("DELETE FROM mensajes WHERE id = '%s'"
			,$idmensaje);

		$result = false;	
		if ( $conn->query($query) ) {
			$result=true;
		} else {
			echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
		return $result;
	}


	
	private static function inserta($mensaje) {
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();

		$query=sprintf("INSERT INTO mensajes (id_emisor, id_receptor, texto) VALUES ('%s', '%s', '%s')"
			, $conn->real_escape_string($mensaje->idEmisor)
			, $conn->real_escape_string($mensaje->idReceptor)
			, $conn->real_escape_string($mensaje->texto));

		if ( $conn->query($query) ) {
			$mensaje->id = $conn->insert_id;
		} else {
			echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
		return $mensaje;
	}

	public function setFile($file){
		move_uploaded_file($file["tmp_name"], __DIR__ . "/../uploads/chat/" . $this->id);
		//$file = fopen($this->id . ".data", 'w');
		file_put_contents( __DIR__ . "/../uploads/chat/" . $this->id . ".data",
						  htmlspecialchars($file['name']));
    }

	public function getId() {
		return $this->id;
	}

	public function getIdEmisor() {
		return $this->idEmisor;
	}

	public function getIdReceptor() {
		return $this->idReceptor;
	}

	public function getTexto(){
		return $this->texto;
	}

	public function hasFile(){
		return file_exists(__DIR__ . '/../uploads/chat/' . $this->id);
	}

	//En php solo hay un constructor, por ello la fecha si se quiere poner tiene que ser a parte
	public function setFecha($fecha)
	{
		$this->fecha = $fecha;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function getTiempo(){
		return $this->tiempo;
	}

}