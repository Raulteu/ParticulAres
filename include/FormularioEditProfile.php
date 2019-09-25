<?php
require_once __DIR__.'/User.php';
require_once __DIR__.'/Form.php';

class FormEditProfile extends Form{

    public function __construct(){
        parent::__construct('editar', array('action' => 'editMyProfile.php'));
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
                <legend>Editar Perfil</legend>
                <h3>Deja los campos en blanco si no quieres modificarlos</h3>
                <div>
                <label class="centeredLabel">Nombre:</label> <input type="text" id="nombre" name="nombre" placeholder="No modificar" value="';
        if (isset($datosIniciales["nombre"])){
            $html .= $datosIniciales['nombre'];
        }
        $html .= '"/>
                <span id="nombreOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Apellidos:</label> <input type="text" id="apellidos" name="apellidos" placeholder="No modificar" value="';

        if (isset($datosIniciales["apellidos"])){
            $html .= $datosIniciales['apellidos'];
        }
        $html .= '"/>
                <span id="apellidosOK"></span>
                </div>
                <div>
                <label class="centeredLabel">¿Cambiar contraseña?</label> <input type="checkbox" id="change_contrasena" name="change_contrasena" value="yes">
                <div id="camposContrasena">
                    <div>
                        <label class="centeredLabel">Contraseña actual:</label> <input type="password" id="oldpass" name="oldpass" placeholder="No modificar"/>
                        <span id="oldpassOK"></span>
                    </div>
                    <div>
                        <label class="centeredLabel">Nueva contraseña:</label> <input type="password" id="pass" name="pass" placeholder="No modificar"/>
                        <span id="passOK"></span>
                    </div>
                    <div>
                        <label class="centeredLabel">Vuelve a introducir tu contraseña:</label> <input type="password" id="pass2" name="pass2" placeholder="Repite contraseña" />
                        <span id="pass2OK"></span>
                    </div>
                </div>
                <div>
                <label class="centeredLabel">E-mail:</label> <input type="email" id="email" name="email" placeholder="No modificar" value="';

        if (isset($datosIniciales["email"])){
            $html .= $datosIniciales['email'];
        }
        $html .= '"/>
                <span id="correoOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Móvil:</label> <input type="text" id="movil" name="movil" placeholder="No modificar" value="';

        if (isset($datosIniciales["movil"])){
            $html .= $datosIniciales['movil'];
        }
        $html .= '"/>
                <span id="movilOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Edad:</label> <input type="number" id="edad" name="edad" placeholder="No modificar" value="';

        if (isset($datosIniciales["edad"])){
            $html .= $datosIniciales['edad'];
        }
        $html .= '"/>
                <span id="edadOK"></span>
                </div>
                <div>
                <label class="centeredLabel">Descripcion:</label><textarea id="descripcion" name="descripcion" placeholder="No modificar">';

        if (isset($datosIniciales["descripcion"])){
            $html .= $datosIniciales['descripcion'];
        }
        $html .= '</textarea>
                </div>
                <div>
                <!--Limita el tamaño máximo del archivo-->
                <input type="hidden" name="MAX_FILE_SIZE" value="8388608" />
                <label class="centeredLabel">Actualiza tu foto: </label> <input class="upload" type="file" name="uploadFile" id="uploadFile" accept="image/*"/>
                </div> 
                <button class="button" id="submit" type="submit" name="registro">Actualizar</button>
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

        $username = $_SESSION['nombre'];
        $user = User::buscaUsuario($username);

        $ret = array("username" => $user->getUsername(),
                    "es_profesor" =>$user->getEsProfesor(),
                    "id" => $user->getId());
                
        $nombre = isset($datos['nombre']) ? htmlspecialchars($datos['nombre']) : null;
        if ( empty($nombre) || strlen($nombre) < 1 ) {
            $ret['nombre'] = $user->getNombre();
        } else {
            $ret['nombre'] = $nombre;
        }

        $apellidos = isset($datos['apellidos']) ? htmlspecialchars($datos['apellidos']) : null;
        if ( empty($apellidos) || strlen($apellidos) < 1 ) {
            $ret['apellidos'] = $user->getApellidos();
        } else {
            $ret['apellidos'] = $apellidos;
        }
        
        //COMPROBAR QUE LA CONTRASEÑA ACTUAL ES CORRECTA
        $oldpass = isset($datos['oldpass']) ? $datos['oldpass'] : null;
        $pass = isset($datos['pass']) ? $datos['pass'] : null;
        $pass2 = isset($datos['pass2']) ? $datos['pass2'] : null;

        $changePass = isset($datos['change_contrasena']) ? htmlspecialchars($datos['change_contrasena']) : null;

        if (empty($changePass) || (!empty($changePass) && ($changePass != "yes"))) {
            $ret['pass'] = null;
        } else {
            if (empty($oldpass) || !password_verify($oldpass, $user->getPass())){
                $erroresFormulario[] = '<p class="Error">Contraseña anterior incorrecta</p>';
            }
            if (empty($pass) || strlen($pass) < 5 ) {
                $erroresFormulario[] = '<p class="Error">La contraseña tiene que tener una longitud de al menos 5 carácteres.</p>';
            } 
            if ( empty($pass2) || empty($pass) || strcmp($pass, $pass2) !== 0 ) {
                $erroresFormulario[] = '<p class="Error">Las contraseñas deben coincidir</p>';
            }
            $ret['pass'] = $pass;
        }

        $email = isset($datos['email']) ? htmlspecialchars($datos['email']) : null;
        if ( empty($email) || strlen($email) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $ret['email'] = $user->getEmail();
        } else {
            $ret['email'] = $email;
        }

        $movil = isset($datos['movil']) ? htmlspecialchars($datos['movil']) : null;
        if ( empty($movil) || strlen($movil) < 8 ) {
            $ret['movil'] = $user->getMovil();
        } else {
            $ret['movil'] = $movil;
        }
        
        $edad = isset($datos['edad']) ? htmlspecialchars($datos['edad']) : null;
        if ( empty($edad) || !is_numeric($edad) || (int) $edad < 1 || (int) $edad > 150) {
            $ret['edad'] = $user->getEdad();
        } else {
            $ret['edad'] = $edad;
        }

        $descripcion = isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : null;
        if ( empty($apellidos) || strlen($descripcion) < 1 ) {
            $ret['descripcion'] = $user->getDescripcion();
        } else {
            $ret['descripcion'] = $descripcion;
        }

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

        if (count($erroresFormulario) === 0) {
            $user->actualiza($ret);
            if (!empty($file) && $file['error'] === 0){ //existe sin errores
                $user->setPhoto($file);
            }
            return 'showMyProfile.php';
        }

       // unset($datos);
        return $erroresFormulario;
    }
}