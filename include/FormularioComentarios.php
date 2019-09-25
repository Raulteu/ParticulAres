<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Form.php';
require_once __DIR__.'/Comments.php';

class FormularioComentarios extends Form {

	/**
	* Genera el HTML necesario para presentar los campos del formulario.
	*
	* @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
	* 
	* @return string HTML asociado a los campos del formulario.
	*/

	// REDUCIR A UNO SOLO CON EL IFSSET EN EL VALUE

	protected function generaCamposFormulario($datosIniciales){
		$return = '<div class="textoMensajes">
			<textarea class="mensajeSend" name="textoMensaje">';
		if (isset($datosIniciales["texto"])){
			$return .= $datosIniciales['texto'];
		}
		$return .= '</textarea>';
		$return .= '<button class="button" type="submit" name="enviarMensaje">Enviar</button></div>';
		return $return;
	}

	/**
	* Procesa los datos del formulario.
	*
	* @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
	*
	* @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
	* se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
	*/
	protected function procesaFormulario($datos){
		if (! isset($datos['enviarMensaje']) ) {
			return "index.php";
		}

		$erroresFormulario = array();

		$texto = isset($datos['textoMensaje']) ? htmlspecialchars($datos['textoMensaje']) : null;

		if ( empty($texto) ) {
			$erroresFormulario[] = "El mensaje no puede estar vacío";
		}

		if (count($erroresFormulario) === 0) {
			if ((isset($_SESSION['login']) && $_SESSION['login'] == true) && (isset($_GET['id']) && $_GET['id'] == true)){ 
				$comentario = Comment::crea($_SESSION['id'],$_GET['id'],$datos['textoMensaje']); 

				if ($comentario){
					unset($datos['textoMensaje']);
					unset($erroresFormulario);
					return "showProfile.php?id=".$_GET['id'];
				} else {
					$erroresFormulario[] = "Error enviando el comentario";
				}
			} else {
					$erroresFormulario[] = "Ha habido un problema con la sesion";
			}
		}
		return $erroresFormulario;
	}

}
