<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Form.php';

class FormularioMessages extends Form {

	/**
	* Genera el HTML necesario para presentar los campos del formulario.
	*
	* @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
	* 
	* @return string HTML asociado a los campos del formulario.
	*/

	// REDUCIR A UNO SOLO CON EL IFSSET EN EL VALUE

	protected function generaCamposFormulario($datosIniciales){
		$return = '<div class="textoMensajes"><div>
			<textarea class="mensajeSend" name="textoMensaje" id="textoMensaje">';
		if (isset($datosIniciales["texto"])){
			$return .= $datosIniciales['texto'];
		}
		$return .= '</textarea></div>';
		$return .= '<div>
                <!--Limita el tamaño máximo del archivo-->
                <label>Añade un archivo: </label> <input class="upload" type="file" name="uploadFile" id="uploadFile" accept="*"/><span id="uploadOK"></span>
                </div>';
		$return .= '<button class="button" type="submit" id="submit" name="enviarMensaje">Enviar</button></div>';
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
		if (! isset($datos['enviarMensaje'])) {
			return "index.php";
		}

		$erroresFormulario = array();

		$texto = isset($datos['textoMensaje']) ? htmlspecialchars($datos['textoMensaje']) : null;

		if (empty($texto)) {
			$erroresFormulario[] = '<p class="Error">El mensaje no puede estar vacío</p>';
		}

		$file = isset($_FILES['uploadFile']) ? $_FILES['uploadFile'] : null;
        if (!empty($file)){
            if ($file['error'] != 0 && $file['error'] != 4){ //4 significa que no hay archivo
                $erroresFormulario[] = '<p class="Error">El archivo debe ser menor de '.$file['error'].' 10Mb.</p>';
            }
        }

		if (count($erroresFormulario) === 0) {
			if ((isset($_SESSION['login']) && $_SESSION['login'] == true) && (isset($_SESSION['receptor']) && $_SESSION['receptor'] == true)){ 
				$mensaje = Message::crea($_SESSION['id'],$_SESSION['receptor'],$datos['textoMensaje']); //Se cogerian el como 1 al usu actual y el 2 una variable en SESSION que cambie en funcion de la conversacion que se haya selecionado

				if ($mensaje){
					if (!empty($file) && $file['error'] === 0){
						$mensaje->setFile($file);
					}
					unset($datos['textoMensaje']);
					unset($erroresFormulario);
					return "messages.php";
				} else {
					$erroresFormulario[] = "Error enviando el mensaje.";
				}
			} else {
					$erroresFormulario[] = "Ha habido un problema con la sesion";
			}
		}
		return $erroresFormulario;
	}

}
