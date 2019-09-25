<?php
require_once __DIR__ . '/Aplication.php';

class Comment {

	private $id;
	private $idEmisor;
	private $nombreEmisor;
	private $apellidosReceptor;
	private $idReceptor;
	private $texto;

	private function __construct($idEmisor, $idReceptor, $texto) {
		$this->idEmisor= $idEmisor;
		$this->idReceptor= $idReceptor;
		$this->texto = $texto;
	}

	public static function historialComentarios($idReceptor) {	  
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT C.id, C.id_emisor, C.id_receptor, C.texto, U.nombre, U.apellidos FROM comentarios_usuarios C JOIN
						  usuario U ON U.id = C.id_emisor 
						  WHERE (C.id_receptor = '%s') ORDER BY C.id DESC", $conn->real_escape_string($idReceptor));
				$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			$result = array();
			while ($fila = $rs->fetch_assoc()) {
				$historial = new Comment($fila['id_emisor'], $fila['id_receptor'], $fila['texto']);
				$historial->id = $fila['id'];
				$historial->setNombreEmisor($fila['nombre']);
				$historial->setApellidosEmisor($fila['apellidos']);
				$result[] = $historial;
			}
			$rs->free();
		} else {
			echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
		return $result;
	}


	public static function historialComentariosPorEmisor($idEmisor) {	  
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT C.id, C.id_emisor, C.id_receptor, C.texto, U.nombre, U.apellidos FROM comentarios_usuarios C JOIN
						  usuario U ON U.id = C.id_emisor 
						  WHERE (C.id_emisor = '%s') ORDER BY C.id DESC", $conn->real_escape_string($idEmisor));
				$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			$result = array();
			while ($fila = $rs->fetch_assoc()) {
				$historial = new Comment($fila['id_emisor'], $fila['id_receptor'], $fila['texto']);
				$historial->id = $fila['id'];
				$historial->setNombreEmisor($fila['nombre']);
				$historial->setApellidosEmisor($fila['apellidos']);
				$result[] = $historial;
			}
			$rs->free();
		} else {
			echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
		return $result;
	}


	public static function borrarComentario($idcomentario){
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();

		$query=sprintf("DELETE FROM comentarios_usuarios WHERE id = '%s'"
			,$idcomentario);

		$result = false;
		if ( $conn->query($query) ) {
			$result = true;
		} else {
			echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			$result = false;
			exit();
		}
		return $result;
	}

	/**
	 * Crea un nuevo mensaje y lo inserta en la bbdd
	 *
	 * @param string $idEmisor
	 * @param string $idReceptor
	 * @param string $texto
	 * @return void
	 */
	public static function crea($idEmisor, $idReceptor, $texto) {
		$mensaje = new Comment($idEmisor, $idReceptor, htmlspecialchars($texto));
		return self::inserta($mensaje);
	}
	
	private static function inserta($comentario) {
		$app = Aplication::getSingleton();
		$conn = $app->conexionBd();

		$query=sprintf("INSERT INTO comentarios_usuarios (id_emisor, id_receptor, texto) VALUES ('%s', '%s', '%s')"
			, $conn->real_escape_string($comentario->idEmisor)
			, $conn->real_escape_string($comentario->idReceptor)
			, $conn->real_escape_string($comentario->texto));

		if ( $conn->query($query) ) {
			$comentario->id = $conn->insert_id;
		} else {
			echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
		return $comentario;
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
	
	public function getApellidosEmisor(){
		return $this->apellidosEmisor;
	}

	public function getNombreEmisor(){
		return $this->nombreEmisor;
	}

	public function setNombreEmisor($nombreEmisor){
		$this->nombreEmisor = $nombreEmisor;
	}

	public function setApellidosEmisor($apellidosEmisor){
		$this->apellidosEmisor = $apellidosEmisor;
	}

}

?>