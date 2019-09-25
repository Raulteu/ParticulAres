$(document).ready(function() {
    
    $(".hiddenComun").hide();
    $(".hidden").hide();
    $(".suplemento").hide();

    $(".checkL").change(function(){
        const campo = $(".checkL"); // referencia jquery al campo

        if(validarCheckboxs()){
            $(".hiddenComun").show();
            $(".checkL")[0].setCustomValidity("");
        } else {
            $(".checkL")[0].setCustomValidity("Debe darse clase al menos un día");
            $(".hiddenComun").hide();
        }
        
        if(campo[0].checked){
            $(".hiddenL").show();
        } else {
            $(".hiddenL").hide();
        }
    });

    $(".checkM").change(function(){
        const campo = $(".checkM"); // referencia jquery al campo

        if(validarCheckboxs()){
            $(".hiddenComun").show();
        } else {
            $(".hiddenComun").hide();
        }
        
        if(campo[0].checked){
            $(".hiddenM").show();
        } else {
            $(".hiddenM").hide();
        }
    });

    $(".checkX").change(function(){
        const campo = $(".checkX"); // referencia jquery al campo
        
        if(validarCheckboxs()){
            $(".hiddenComun").show();
        } else {
            $(".hiddenComun").hide();
        }

        if(campo[0].checked){
            $(".hiddenX").show();
        } else {
            $(".hiddenX").hide();
        }
    });

    $(".checkJ").change(function(){
        const campo = $(".checkJ"); // referencia jquery al campo
        
        if(validarCheckboxs()){
            $(".hiddenComun").show();
        } else {
            $(".hiddenComun").hide();
        }

        if(campo[0].checked){
            $(".hiddenJ").show();
        } else {
            $(".hiddenJ").hide();
        }
    });

    $(".checkV").change(function(){
        const campo = $(".checkV"); // referencia jquery al campo
        
        if(validarCheckboxs()){
            $(".hiddenComun").show();
        } else {
            $(".hiddenComun").hide();
        }

        if(campo[0].checked){
            $(".hiddenV").show();
        } else {
            $(".hiddenV").hide();
        }
    });
    $(".checkS").change(function(){
        const campo = $(".checkS"); // referencia jquery al campo
        
        if(validarCheckboxs()){
            $(".hiddenComun").show();
        } else {
            $(".hiddenComun").hide();
        }

        if(campo[0].checked){
            $(".hiddenS").show();
        } else {
            $(".hiddenS").hide();
        }
    });

    $(".checkD").change(function(){
        const campo = $(".checkD"); // referencia jquery al campo
        
        if(validarCheckboxs()){
            $(".hiddenComun").show();
        } else {
            $(".hiddenComun").hide();
        }

        if(campo[0].checked){
            $(".hiddenD").show();
        } else {
            $(".hiddenD").hide();
        }
    });
    
    $(".desplazamiento").change(function(){
        const campo = $(".desplazamiento"); // referencia jquery al campo
        
        if(campo[0].checked){
            $(".suplemento").show();
        } else {
            $(".suplemento").hide();
        }
    });

    $("#suplemento").change(function(){
        if($(".desplazamiento")[0].checked){
            campo = $("#suplemento");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    function validarCheckboxs(){
        if($(".checkL")[0].checked || $(".checkM")[0].checked || $(".checkX")[0].checked || $(".checkJ")[0].checked 
            || $(".checkV")[0].checked || $(".checkS")[0].checked || $(".checkD")[0].checked) {
                ret = true;
        } else {
            ret = false;
        } 
        return ret;
    }

    $("#nombre").change(function(){
        const campo = $("#nombre"); // referencia jquery al campo
        campo[0].setCustomValidity(""); // limpia validaciones previas
        
        if (campo.val().length < 1) {
            campo[0].setCustomValidity("El campo es obligatorio");
        } else {
            campo[0].setCustomValidity("");
        }
    });

    $("#descripcion").change(function(){
        const campo = $("#descripcion"); // referencia jquery al campo
        campo[0].setCustomValidity(""); // limpia validaciones previas
        
        if (campo.val().length < 1) {
            campo[0].setCustomValidity("El campo es obligatorio");
        } else {
            campo[0].setCustomValidity("");
        }
    }); 
    

    $("#precio").change(function(){
        const campo = $("#precio");
        campo[0].setCustomValidity("");
        console.log(campo.val() == '' ? "true" : "false");
        if ( Number.isInteger(parseInt(campo.val())) && campo.val() >= 0 && campo.val() < 99999999 && campo.val() != null){
            campo[0].setCustomValidity("");
        } else {
            campo[0].setCustomValidity("Introduzca un número válido");
        }
    });

    $("#fechaIni").change(function(){
        const campo = $("#fechaIni");
        campo[0].setCustomValidity("");
        if (validarCheckboxs()){
            if (campo.val() != ""){
                campo[0].setCustomValidity("");
            } else {
                campo[0].setCustomValidity("Campo obligatorio");
            }
        }
    });

    $("#fechaFin").change(function(){
        const campo = $("#fechaFin");
        campo[0].setCustomValidity("");
        if (validarCheckboxs()){
            if (campo.val() != ""){
                campo[0].setCustomValidity("");
            } else {
                campo[0].setCustomValidity("Campo obligatorio");
            }
        }
    });

//Lunes
    $("#horaIniL").change(function(){
        if($(".checkL")[0].checked){
            campo = $("#horaIniL");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#intervaloL").change(function(){
        if($(".checkL")[0].checked){
            campo = $("#intervaloL");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#duracionL").change(function(){
        if($(".checkL")[0].checked){
            campo = $("#duracionL");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    //Martes
    $("#horaIniM").change(function(){
        if($(".checkM")[0].checked){
            campo = $("#horaIniM");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#intervaloM").change(function(){
        if($(".checkM")[0].checked){
            campo = $("#intervaloM");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#duracionM").change(function(){
        if($(".checkM")[0].checked){
            campo = $("#duracionM");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });


    //Miércoles
    $("#horaIniX").change(function(){
        if($(".checkX")[0].checked){
            campo = $("#horaIniX");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#intervaloX").change(function(){
        if($(".checkX")[0].checked){
            campo = $("#intervaloX");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#duracionX").change(function(){
        if($(".checkX")[0].checked){
            campo = $("#duracionX");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    //Jueves
    $("#horaIniJ").change(function(){
        if($(".checkJ")[0].checked){
            campo = $("#horaIniJ");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#intervaloJ").change(function(){
        if($(".checkJ")[0].checked){
            campo = $("#intervaloJ");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#duracionJ").change(function(){
        if($(".checkJ")[0].checked){
            campo = $("#duracionJ");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });


    //Viernes
    $("#horaIniV").change(function(){
        if($(".checkV")[0].checked){
            campo = $("#horaIniV");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#intervaloV").change(function(){
        if($(".checkV")[0].checked){
            campo = $("#intervaloV");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#duracionV").change(function(){
        if($(".checkV")[0].checked){
            campo = $("#duracionV");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    //Sábado
    $("#horaIniS").change(function(){
        if($(".checkS")[0].checked){
            campo = $("#horaIniS");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#intervaloS").change(function(){
        if($(".checkS")[0].checked){
            campo = $("#intervaloS");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#duracionS").change(function(){
        if($(".checkS")[0].checked){
            campo = $("#duracionS");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });
    

    //Domingo
    $("#horaIniD").change(function(){
        if($(".checkD")[0].checked){
            campo = $("#horaIniD");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#intervaloD").change(function(){
        if($(".checkD")[0].checked){
            campo = $("#intervaloD");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#duracionD").change(function(){
        if($(".checkD")[0].checked){
            campo = $("#duracionD");
            campo[0].setCustomValidity("");
            if(campo.val() == ""){
                campo[0].setCustomValidity("Campo obligatorio");
            } else {
                campo[0].setCustomValidity("");
            }
        }
    });

    $("#submit").click(function(){
        $("#nombre").change();
        $("#descripcion").change();

        $("#suplemento").change();
        $("#precio").change();
        $("#checkMap").change();
        
        const zona = $("#zonaLbl");
        if (zona.text() == "") {
            $("#mapid").css("border", "0.2em solid red");
            zona.text("Selecciona una zona en el mapa");
        }

        $("#fechaIni").change();
        $("#fechaFin").change();

        $(".checkL").change();  

        $("#horaIniL").change();
        $("#intervaloL").change();
        $("#duracionL").change();
        
        $("#horaIniM").change();
        $("#intervaloM").change();
        $("#duracionM").change();

        $("#horaIniX").change();
        $("#intervaloX").change();
        $("#duracionX").change(); 

        $("#horaIniJ").change();
        $("#intervaloJ").change();
        $("#duracionJ").change(); 

        $("#horaIniV").change();
        $("#intervaloV").change();
        $("#duracionV").change();

        $("#horaIniS").change();
        $("#intervaloS").change();
        $("#duracionS").change();

        $("#horaIniD").change();
        $("#intervaloD").change();
        $("#duracionD").change();
    });

    $("#mapid").click(function(){
        $(this).css("border", "none");
        const zona = $("#zonaLbl");

        if (zona.text() == "") {
            zona.text("");
        }
    });
})