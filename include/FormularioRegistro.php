<?php
require_once __DIR__.'/User.php';
require_once __DIR__.'/Form.php';

class FormRegistro extends Form{

    public function __construct(){
        parent::__construct('registro', array('action' => 'signIn.php'));
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
                <legend>Sign In</legend>
                <div>
                <label class="centeredLabel">Nombre de usuario:</label> <input type="text" id="username" name="username" placeholder="Nombre de usuario" value="';
        if (isset($datosIniciales["username"])){
            $html .= $datosIniciales['username'];
        }
        $html .= '"/>
                <span id="usernameOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Nombre:</label> <input type="text"  id="nombre" name="nombre" placeholder="Nombre" value="';
        if (isset($datosIniciales["nombre"])){
            $html .= $datosIniciales['nombre'];
        }
        $html .= '"/>
                <span id="nombreOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Apellidos:</label> <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" value="';

        if (isset($datosIniciales["apellidos"])){
            $html .= $datosIniciales['apellidos'];
        }
        $html .= '"/>
                <span id="apellidosOK"></span>
                </div>
                <div>
                    <label class="centeredLabel">Contraseña:</label> <input type="password" id="pass" name="pass" placeholder="Contraseña"/>
                    <span id="passOK"></span>
                </div>
                <div>
                    <label class="centeredLabel">Vuelve a introducir tu contraseña:</label> <input type="password" id="pass2" name="pass2" placeholder="Contraseña" />
                    <span id="pass2OK"></span>
                </div>
                <div>
                <label class="centeredLabel">E-mail:</label> <input type="email" id="email" name="email" placeholder="E-mail" value="';

        if (isset($datosIniciales["email"])){
            $html .= $datosIniciales['email'];
        }
        $html .= '"/>
                <span id="correoOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Móvil:</label> <input type="text" id="movil" name="movil" placeholder="Móvil" value="';

        if (isset($datosIniciales["movil"])){
            $html .= $datosIniciales['movil'];
        }
        $html .= '"/>
                <span id="movilOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Edad:</label> <input type="number" id="edad" name="edad" placeholder="Edad" value="';

        if (isset($datosIniciales["edad"])){
            $html .= $datosIniciales['edad'];
        }
        $html .= '"/>
                <span id="edadOK"></span>
                </div>
                <div>
                <label class="centeredLabel">¿Eres profesor?</label> <input type="checkbox" id="es_profesor" name="es_profesor" value="yes"/>
                </div>
                <div id="camposProfesor">
                    <label class="centeredLabel">IBAN:</label>
                    <input type="text" id="iban" name="iban" placeholder="IBAN" value"';
        if (isset($datosIniciales["iban"])){
            $html .= $datosIniciales['iban'];
        }
        $html .= '"/>
                <span id="ibanOK"></span>
                </div>
                <div>
                <!--Limita el tamaño máximo del archivo-->
                <input type="hidden" name="MAX_FILE_SIZE" value="8388608" />
                <label class="centeredLabel">Sube una foto (opcional): </label> <input class="upload" type="file" name="uploadFile" id="uploadFile" accept="image/*"/>
                </div> 
                <button class="button" type="submit" id="submit" name="registro">Sign In</button>
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
        $erroresFormulario = array();
        
        $username = isset($datos['username']) ? htmlspecialchars($datos['username']) : null;
        
        if ( empty($username) || strlen($username) < 5 ) {
            $erroresFormulario[] = '<p class="Error">El nombre de usuario tiene que tener una longitud de al menos 5 carácteres.</p>';
        }
        
        $nombre = isset($datos['nombre']) ? htmlspecialchars($datos['nombre']) : null;
        if ( empty($nombre) || strlen($nombre) < 1 ) {
            $erroresFormulario[] = '<p class="Error">El nombre tiene que tener al menos un carácter.</p>';
        }

        $apellidos = isset($datos['apellidos']) ? htmlspecialchars($datos['apellidos']) : null;
        if ( empty($apellidos) || strlen($apellidos) < 1 ) {
            $erroresFormulario[] = '<p class="Error">El apellido tiene que tener al menos un carácter.</p>';
        }
        
        $pass = isset($datos['pass']) ? $datos['pass'] : null;
        if ( empty($pass) || strlen($pass) < 5 ) {
            $erroresFormulario[] = '<p class="Error">La contraseña tiene que tener una longitud de al menos 5 carácteres.</p>';
        }

        $email = isset($datos['email']) ? htmlspecialchars($datos['email']) : null;
        if ( empty($email) || strlen($email) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erroresFormulario[] = '<p class="Error">El email debe tener un formato válido.</p>';
        }

        $movil = isset($datos['movil']) ? htmlspecialchars($datos['movil']) : null;
        if ( empty($movil) || strlen($movil) < 8 ) {
            $erroresFormulario[] = '<p class="Error">El móvil debe tener un formato válido</p>';
        }

        $pass2 = isset($datos['pass2']) ? $datos['pass2'] : null;
        if ( empty($pass2) || strcmp($pass, $pass2) !== 0 ) {
            $erroresFormulario[] = '<p class="Error">Las contraseñas deben coincidir</p>';
        }
        
        $edad = isset($datos['edad']) ? htmlspecialchars($datos['edad']) : null;
        if ( empty($edad) || !is_numeric($edad) || (int) $edad < 1 || (int) $edad > 150) {
            $erroresFormulario[] = '<p class="Error">La edad debe ser numérica</p>';
        }

        $es_profesor = isset($datos['es_profesor']) ? htmlspecialchars($datos['es_profesor']) : null;

        $file = isset($_FILES['uploadFile']) ? $_FILES['uploadFile'] : null;
        if (!empty($file)){
            if ($file['error'] != 4) //4 significa que no hay archivo
                {
                if ($file['error'] != 0 ){ //Comprueba que no haya error
                    $erroresFormulario[] = '<p class="Error">El archivo debe ser menor de 5Mb.</p>';
                }
                elseif (!getimagesize($file['tmp_name'])){
                    $erroresFormulario[] = '<p class="Error">El archivo debe ser una imagen.</p>';
                }
            }
        }

        $iban = isset($datos['iban']) ? htmlspecialchars($datos['iban']) : null;
        if ($es_profesor == "yes" && empty($iban)){ 
            $erroresFormulario[] = '<p class="Error">El campo IBAN no puede estar vacío</p>';
        }

        if (count($erroresFormulario) === 0) {
           
            if (User::buscaUsuario($username))
                $erroresFormulario[] = "El usuario ya existe";
            else {
                $user = array("username" => $username,
                            "nombre" => $nombre,
                            "apellidos" => $apellidos,
                            "pass" => $pass,
                            "email" => $email,
                            "movil" => $movil,
                            "edad" => $edad,
                            "es_profesor" => ($es_profesor == 'yes' ? 1 : 0),
                            "iban" => $iban
                        );
                if ($user = User::crea($user)) {
                
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $username;
                $_SESSION['id'] = $user->getId();
                $_SESSION['es_profesor'] = ($es_profesor == 'yes' ? 1 : 0);
                $_SESSION['es_admin'] = false;
                if (!empty($file) && $file['error'] === 0){ //existe sin errores
                    $user->setPhoto($file);
                }
                return 'index.php';
                }
            }
        }
        return $erroresFormulario;
    }
}