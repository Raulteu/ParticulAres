<?php
require_once __DIR__.'/User.php';
require_once __DIR__.'/Form.php';
require_once __DIR__.'/Events.php';
require_once __DIR__.'/Advertisement.php';

class FormAd extends Form{

    public function __construct(){
        parent::__construct('registro', array('action' => 'createAd.php'));
    }

    //Genera un cuadro de texto con un dia y su seleccion
    private function genDay($day) {
        $html = '<label class="centeredLabel">'.$day.'</label>';
        $html .= '<input type="checkbox" class="check' .$day.'" name="day'.$day.'" value="'.$day.'"/>';
        $html .= '<div class="hidden'.$day.' hidden">
                  <label>Horario de inicio: </label><input id="horaIni'.$day.'" name="horaIni'.$day.'" type="time" value="';
        if (isset($datosIniciales["horaIni".$day])){
            $html .= $datosIniciales["horaIni".$day];
        }
        $html .= '"/>
                  <label>Intervalo (Semanas): </label><input id="intervalo'.$day.'" name="intervalo'.$day.'" type="number" min="1" value="';
        if (isset($datosIniciales["intervalo".$day])){
            $html .= $datosIniciales["intervalo".$day];
        }
        $html .= '"/>
                  <label>Duracion: </label><input id="duracion'.$day.'" name="duracion'.$day.'" type="time" value="';
        if (isset($datosIniciales["duracion".$day])){
            $html .= $datosIniciales["duracion".$day];
        }
        $html .= '"/>
                  </div>';
        return $html;
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
                <legend>Nuevo Anuncio</legend>
                <div>
                <label class="centeredLabel">¿Qué clase deseas impartir?</label><input type="text" id="nombre" name="clase" placeholder="Nombre de la clase" value="';
        if (isset($datosIniciales["clase"])){
            $html .= $datosIniciales['clase'];
        }
        $html .= '"/>
                </div>
                <div>
                <label class="centeredLabel">Nivel</label><select name="nivel">'; 
            foreach (Advertisement::getNiveles() as $nivel)
            {
                $html .= "<option value='$nivel'>$nivel</option>";
            }
            $html .= '</select>
                </div>
                <div>
                <label class="centeredLabel">Precio:</label> <input type="number" id="precio" name="precio" placeholder="0" value="';
        if (isset($datosIniciales["precio"])){
            $html .= $datosIniciales['precio'];
        }
        $html .= '"/>
                </div>
                <div>
                <label class="centeredLabel">Descripcion</label><textarea id="descripcion" name="descripcion" rows="5" cols="40">';
        if (isset($datosIniciales["descripcion"])){
            $html .= $datosIniciales['descripcion'];
        }
        $html .= '</textarea>
                </div>
                <div>
                <div><label class="centeredLabel">Días:</label></div>
                <div class="hiddenComun" > 
                    <label class="centeredLabel">Fecha de inicio: </label><input id="fechaIni" name="fechaIni" type="date"value="';
        if (isset($datosIniciales["fechaIni"])){
            $html .= $datosIniciales["fechaIni"];
        }
        $html .= '"/>
                    <label class="centeredLabel">Fecha de fin: </label><input id="fechaFin" name="fechaFin" type="date"value="';
        if (isset($datosIniciales["fechaFin"])){
            $html .= $datosIniciales["fechaFin"];
        }
        $html .= '"/>
                </div>' . $this->genDay('L') . $this->genDay('M')
                . $this->genDay('X') . $this->genDay('J') . $this->genDay('V').
                $this->genDay('S') . $this->genDay('D');
                
        $html .= '</div>
                <div>
                <label class="centeredLabel">Selecciona una zona del mapa:</label>
        <input type="hidden" id="zona" name="zona" value="';
        if (isset($datosIniciales["zona"])){
            $html .= $datosIniciales['zona'];
        }
        $html .= '"/>
        <input type="hidden" id="coords" name="coords" value="';
        if (isset($datosIniciales["coords"])){
            $html .= $datosIniciales['coords'];
        }
        $html .= '"/>
                <div id="mapid"></div>
                <div><label id="zonaLbl"></label></div>
                </div>
                <div>
                <label class="centeredLabel">Posibilidad de desplazamiento:</label> <input type="checkbox" class="desplazamiento" name="desplazamiento" value="yes"/>
                </div>
                <div class="suplemento">
                <label class="centeredLabel">Suplemento por desplazamiento</label> <input type="number" id="suplemento" name="suplemento" value="';
        if (isset($datosIniciales["suplemento"])){
            $html .= $datosIniciales['suplemento'];
        }
        $html .= '"/>
                </div>
                <button class="button" id="submit" type="submit" name="addAd">Añadir anuncio</button>
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
        
        $clase = isset($datos['clase']) ? htmlspecialchars($datos['clase']) : null;
        
        if ( empty($clase) || strlen($clase) < 1 ) {
            $erroresFormulario[] = '<p class="Error">La clase no puede estar vacía</p>';
        }

        //Comprueba que no se intente meter algo invalido
        $nivel = isset($datos['nivel']) && in_array($datos['nivel'], ['Primaria', 'Secundaria', 'FP', 'Bachillerato', 'Universidad', 'Otro']) ? $datos['nivel'] : null;
        
        if (empty($nivel)) {
            $erroresFormulario[] = '<p class="Error">El nivel no puede estar vacío</p>';
        }
        
        $precio = isset($datos['precio']) ? htmlspecialchars($datos['precio']) : null;
        if ( empty($precio) || !is_numeric($precio)) {
            $erroresFormulario[] = '<p class="Error">El precio debe ser un número y no estar vacío.</p>';
        }

        $descripcion = isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : null;
        
        if ( empty($descripcion) || strlen($descripcion) < 1 ) {
            $erroresFormulario[] = '<p class="Error">La descripción no puede estar vacía</p>';
        }

        $coords = isset($datos['coords']) ? htmlspecialchars($datos['coords']) : null;
        $zona = isset($datos['zona']) ? htmlspecialchars($datos['zona']) : null;
        if ( empty($coords) || empty($zona) ) {
            $erroresFormulario[] = '<p class="Error">Selecciona una zona en el mapa.</p>';
        }

        $desplazamiento = isset($datos['desplazamiento']) ? htmlspecialchars($datos['desplazamiento']) : null;

        $suplemento = isset($datos['suplemento']) ? htmlspecialchars($datos['suplemento']) : null;
        if ( (isset($desplazamiento) && $desplazamiento === "yes") && (empty($suplemento) || !is_numeric($suplemento))) {
            $erroresFormulario[] = '<p class="Error">El precio del suplemento debe ser un número y no estar vacío.</p>';
        }

        
        $fIni = isset($datos['fechaIni']) ? htmlspecialchars($datos['fechaIni']) : null;
        $fFin = isset($datos['fechaFin']) ? htmlspecialchars($datos['fechaFin']) : null;
        if($fIni != null && $fFin != null && $fIni > $fFin){
             $erroresFormulario[] = '<p class="Error">La fecha de fin no puede ser antes que la de inicio.</p>';
        }

        $hIniL = isset($datos['horaIniL']) ? htmlspecialchars($datos['horaIniL']) : null;
        if(isset($datos['dayL']) == 'yes' && $hIniL == null){
             $erroresFormulario[] = '<p class="Error">El horario del lunes no puede ser vacio.</p>';
        }
        $intervaloL = isset($datos['intervaloL']) ? htmlspecialchars($datos['intervaloL']) : 1;
        $duracionL = isset($datos['duracionL']) ? htmlspecialchars($datos['duracionL']) : null;
        if(isset($datos['dayL']) == 'yes' && $duracionL == null){
             $erroresFormulario[] = '<p class="Error">La duración del lunes no puede estar vacia.</p>';
        }

        $hIniM = isset($datos['horaIniM']) ? htmlspecialchars($datos['horaIniM']) : null;
        if(isset($datos['dayM']) == 'yes' && $hIniM == null){
             $erroresFormulario[] = '<p class="Error">El horario del martes no puede ser vacio.</p>';
        }
        $intervaloM = isset($datos['intervaloM']) ? htmlspecialchars($datos['intervaloM']) : 1;
        $duracionM = isset($datos['duracionM']) ? htmlspecialchars($datos['duracionM']) : null;
        if(isset($datos['dayM']) == 'yes' && $duracionM == null){
             $erroresFormulario[] = '<p class="Error">La duración del martes no puede estar vacia.</p>';
        }

        $hIniX = isset($datos['horaIniX']) ? htmlspecialchars($datos['horaIniX']) : null;
        if(isset($datos['dayX']) == 'yes' && $hIniX == null){
             $erroresFormulario[] = '<p class="Error">El horario del miércoles no puede ser vacio.</p>';
        }
        $intervaloX = isset($datos['intervaloX']) ? htmlspecialchars($datos['intervaloX']) : 1;
        $duracionX = isset($datos['duracionX']) ? htmlspecialchars($datos['duracionX']) : null;
        if(isset($datos['dayX']) == 'yes' && $duracionX == null){
             $erroresFormulario[] = '<p class="Error">La duración del miércoles no puede estar vacia.</p>';
        }

        $hIniJ = isset($datos['horaIniJ']) ? htmlspecialchars($datos['horaIniJ']) : null;
        if(isset($datos['dayJ']) == 'yes' && $hIniJ == null){
             $erroresFormulario[] = '<p class="Error">El horario del jueves no puede ser vacio.</p>';
        }
        $intervaloJ = isset($datos['intervaloJ']) ? htmlspecialchars($datos['intervaloJ']) : 1;
        $duracionJ = isset($datos['duracionJ']) ? htmlspecialchars($datos['duracionJ']) : null;
        if(isset($datos['dayJ']) == 'yes' && $duracionJ == null){
             $erroresFormulario[] = '<p class="Error">La duración del jueves no puede estar vacia.</p>';
        }

        $hIniV = isset($datos['horaIniV']) ? htmlspecialchars($datos['horaIniV']) : null;
        if(isset($datos['dayV']) == 'yes' && $hIniV == null){
             $erroresFormulario[] = '<p class="Error">El horario no puede ser vacio.</p>';
        }
        $intervaloV = isset($datos['intervaloV']) ? htmlspecialchars($datos['intervaloV']) : 1;
        $duracionV = isset($datos['duracionV']) ? htmlspecialchars($datos['duracionV']) : null;
        if(isset($datos['dayV']) == 'yes' && $duracionV == null){
             $erroresFormulario[] = '<p class="Error">La duración del viernes no puede estar vacia.</p>';
        }

        $hIniS = isset($datos['horaIniS']) ? htmlspecialchars($datos['horaIniS']) : null;
        if(isset($datos['dayS']) == 'yes' && $hIniS == null){
             $erroresFormulario[] = '<p class="Error">El horario del sábado no puede ser vacio.</p>';
        }
        $intervaloS = isset($datos['intervaloS']) ? htmlspecialchars($datos['intervaloS']) : 1;
        $duracionS = isset($datos['duracionS']) ? htmlspecialchars($datos['duracionS']) : null;
        if(isset($datos['dayS']) == 'yes' && $duracionS == null){
             $erroresFormulario[] = '<p class="Error">La duración del sábado no puede estar vacia.</p>';
        }

        $hIniD = isset($datos['horaIniD']) ? htmlspecialchars($datos['horaIniD']) : null;
        if(isset($datos['dayD']) == 'yes' && $hIniD == null){
             $erroresFormulario[] = '<p class="Error">El horario del domingo no puede ser vacio.</p>';
        }
        $intervaloD = isset($datos['intervaloD']) ? htmlspecialchars($datos['intervaloD']) : 1;
        $duracionD = isset($datos['duracionD']) ? htmlspecialchars($datos['duracionD']) : null;
        if(isset($datos['dayD']) == 'yes' && $duracionD == null){
             $erroresFormulario[] = '<p class="Error">La duración del domingo no puede estar vacia.</p>';
        }
        
        if (count($erroresFormulario) === 0) {
        //Hacer cosas con esta wea;
            if (isset($_SESSION['login']) && $_SESSION['login'] == true && isset($_SESSION['es_profesor']) && $_SESSION['es_profesor'] == 1) {
                //Advertisement tiene descripción pero no se como meterla
                if ($adId = Advertisement::creaAnuncio($_SESSION['id'], $clase, 
                    $nivel,"Español", $descripcion, $zona, $coords, $precio)){ 

                    if (isset($datos['dayL']) == 'yes'){
                        //Introduccir lunes en bd
                        if(Events::creaEvento($adId, $fIni, $hIniL, $fFin, 'mo', $intervaloL, $duracionL) == null){
                            $erroresFormulario[] = "Error al añadir la información del lunes";
                        }
                    }
                    if (isset($datos['dayM']) == 'yes'){
                        //Introduccir lunes en bd
                        if(Events::creaEvento($adId, $fIni, $hIniM, $fFin, 'tu', $intervaloM, $duracionM) == null){
                            $erroresFormulario[] = "Error al añadir la información del martes";
                        }
                    }
                    if (isset($datos['dayX']) == 'yes'){
                        //Introduccir lunes en bd
                        if(Events::creaEvento($adId, $fIni, $hIniX, $fFin, 'we', $intervaloX, $duracionX) == null){
                            $erroresFormulario[] = "Error al añadir la información del miercoles";
                        }
                    }
                    if (isset($datos['dayJ']) == 'yes'){
                        //Introduccir lunes en bd
                        if(Events::creaEvento($adId, $fIni, $hIniJ, $fFin, 'th', $intervaloJ, $duracionJ) == null){
                            $erroresFormulario[] = "Error al añadir la información del jueves";
                        }
                    }
                    if (isset($datos['dayV']) == 'yes'){
                        //Introduccir lunes en bd
                        if(Events::creaEvento($adId, $fIni, $hIniV, $fFin, 'fr', $intervaloV, $duracionV) == null){
                            $erroresFormulario[] = "Error al añadir la información del viernes";
                        }
                    }
                    if (isset($datos['dayS']) == 'yes'){
                        //Introduccir lunes en bd
                        if(Events::creaEvento($adId, $fIni, $hIniS, $fFin, 'sa', $intervaloS, $duracionS) == null){
                            $erroresFormulario[] = "Error al añadir la información del sabado";
                        }
                    }
                    if (isset($datos['dayD']) == 'yes'){
                        //Introduccir lunes en bd
                        if(Events::creaEvento($adId, $fIni, $hIniD, $fFin, 'su', $intervaloD, $duracionD) == null){
                            $erroresFormulario[] = "Error al añadir la información del domingo";
                        }
                    }

                    if (count($erroresFormulario) === 0) {
                        return "ad.php?id=$adId";
                    }
                $erroresFormulario[] = "Error al crear anuncio";
                }
            }
           
            
        }
        return $erroresFormulario;
    }
}