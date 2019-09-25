<?php
require_once __DIR__.'/config.php';
require_once __DIR__. '/Form.php';
require_once __DIR__.'/User.php';

class FormLogin extends Form{

    public function __construct(){
        parent::__construct('login', array('action' => 'logIn.php'));
    }

    /**
    * Genera el HTML necesario para presentar los campos del formulario.
    *
    * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
    * 
    * @return string HTML asociado a los campos del formulario.
    */
    protected function generaCamposFormulario($datosIniciales){
        $html = '<fieldset class="login">
                    <legend>Login</legend>
                        <div>
                            <label class="centeredLabel">Nombre de usuario:</label> <input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario" value="';
        if (isset($datosIniciales["nombreUsuario"])) {
            $html .= $datosIniciales['nombreUsuario'];
        }
        $html .= '"/>
                            <span id="nombreOK"></span>
                        </div>
                        <div>
                            <label class="centeredLabel">Contraseña:</label> <input type="password" name="password" id="password" placeholder="Contraseña"/>
                            <span id="passwordOK"></span>
                        </div>
                    <div><button class="button" type="submit" id="submit" name="login">Log in</button></div>
                </fieldset>';
        return $html;
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
        //Procesa los datos
        $erroresFormulario = array();

        $nombreUsuario = isset($datos['nombreUsuario']) ? htmlspecialchars($datos['nombreUsuario']) : null;

        if ( empty($nombreUsuario) ){
            $erroresFormulario[] = "El nombre de usuario no puede estar vacío";
        }

        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) ){
            $erroresFormulario[] = "El password no puede estar vacío.";
        }

        if (count($erroresFormulario) === 0){
            if ($usuario = User::login($nombreUsuario, $password)){
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $nombreUsuario;
                    $_SESSION['id'] = $usuario->getId();
                    $_SESSION['es_profesor'] = $usuario->getEsProfesor();
                    $_SESSION['es_admin'] = $usuario->getEsAdmin();
                    return "index.php";
            } else
                $erroresFormulario[] = "El usuario o el password no coinciden";
        }
        return $erroresFormulario;
    }
}   