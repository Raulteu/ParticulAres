<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Form.php';
require_once __DIR__.'/User.php';

class EnviarPuntuacion extends Form {

	public function __construct(){
		//No hace falta comprobar el get porque se hace antes de llamar a este form
        parent::__construct('enviarPuntuacion', array('action' => 'showProfile.php?id=' . $_GET['id']));
    }

	protected function generaCamposFormulario($datosIniciales){

		$return = '<p><strong>Puntuar profesor:</strong></p>';

				if (isset($_SESSION["login"]) && $_SESSION["login"] === true){ 

					$return .= 
					'<div class="estrellitas">
						  	<p class="clasificacion">
							    <input id="radio1" type="radio" name="estrellas" value="5"><!--
							    --><label class="star" for="radio1">★</label><!--
							    --><input id="radio2" type="radio" name="estrellas" value="4"><!--
							    --><label class="star" for="radio2">★</label><!--
							    --><input id="radio3" type="radio" name="estrellas" value="3"><!--
							    --><label class="star" for="radio3">★</label><!--
							    --><input id="radio4" type="radio" name="estrellas" value="2"><!--
							    --><label class="star" for="radio4">★</label><!--
							    --><input id="radio5" type="radio" name="estrellas" value="1"><!--
							    --><label class="star" for="radio5">★</label>
					  		</p>
					</div>
					<button class="button" type="submit" name="puntuar" value="">Enviar puntuación</button>';
				}
				else {
					$return .= '<h3>Debes estar logueado para puntuar a un profesor</h3>';
				}
		return $return;
	}

	protected function procesaFormulario($datos){
		$erroresFormulario = array();
		if (isset($_SESSION['login']) && $_SESSION['login'] == true && isset($_GET['id']) && isset($datos['estrellas']))
		{
			$resultado = User::puntuarUsuario($_SESSION['id'], $datos['estrellas'], $_GET['id']);
			return 'showProfile.php?id=' . $_GET['id'];
		}
		return $erroresFormulario;
	}
}