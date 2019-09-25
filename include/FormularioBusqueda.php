<?php
require_once __DIR__.'/config.php';
require_once __DIR__. '/Form.php';
require_once __DIR__.'/User.php';
require_once __DIR__.'/Advertisement.php';

class FormBusqueda extends Form{

    public function __construct(){
        parent::__construct('busqueda', array('action' => 'search.php'));
    }

    /**
    * Genera el HTML necesario para presentar los campos del formulario.
    *
    * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
    * 
    * @return string HTML asociado a los campos del formulario.
    */
    protected function generaCamposFormulario($datosIniciales){
        $html = "  
                    <div class='flex'>
                        <input type='text' name='materia' placeholder='Materia'/>
                    </div>
                    <div>
                    <select name='nivel'>
                    <option value=''>- Nivel -</option>";
        foreach (Advertisement::getNiveles() as $nivel)
        {
            $html .= "<option value='$nivel'>$nivel</option>";
        }
        $html .=       "</select>
                    </div>
                    <div class='flex'><button class='button button-header' type='submit' name='login'>&#x1F50E;</button></div>";
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

        $materia = isset($datos['materia']) ? htmlspecialchars($datos['materia']) : '';

        $nivel = isset($datos['nivel']) ? htmlspecialchars($datos['nivel']) : '';

        return ("search.php?materia=$materia&nivel=$nivel");
  
        return $erroresFormulario;
    }
}   