$(document).ready(function() {

    $("#correoOK").hide();
    $("#userOK").hide();
    $("#usernameOK").hide();
    $("#nombreOK").hide();
    $("#apellidosOK").hide();
    $("#passOK").hide();
    $("#pass2OK").hide();
    $("#movilOK").hide();
    $("#edadOK").hide();
    $("#camposProfesor").hide();
    

    $("#email").change(function(){
        const campo = $("#email"); // referencia jquery al campo
        campo[0].setCustomValidity(""); // limpia validaciones previas
        const regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        // validación html5, porque el campo es <input type="email" ...>
        esCorreoValido = campo[0].checkValidity(); //No está funcionando
        if (esCorreoValido && regex.test(campo.val())) {
            $("#correoOK").hide();
            campo[0].setCustomValidity("");
        } else {
            $("#correoOK").html("⚠️");
            $("#correoOK").show();
            campo[0].setCustomValidity("Escriba un correo válido");
        }
    });

    
    $("#username").change(function(){
        const campo = $("#username");
        campo[0].setCustomValidity("");

        if (campo.val().length < 5){
            $("#usernameOK").html("⚠️");
            $("#usernameOK").show();
            campo[0].setCustomValidity("El nombre de usuario debe tener al menos 5 caracteres");
        } else {
            var url = "ajax/comprobarUsuario.php?user=" + $("#username").val();
            $.get(url,usuarioExiste);
        }

        
    });

    function usuarioExiste(data,status) {
        const campo = $("#username"); // referencia jquery al campo
        campo[0].setCustomValidity("");

        if (status == "success" && data == "disponible"){
            $("#usernameOK").hide();
            campo[0].setCustomValidity("");
        } else {
            $("#usernameOK").html("⚠️");
            $("#usernameOK").show();
            campo[0].setCustomValidity("El usuario no está disponible");
        }
    }

    $("#nombre").change(function(){
        const campo = $("#nombre");
        campo[0].setCustomValidity("");
        if (campo.val().length < 1){
            $("#nombreOK").html("⚠️");
            $("#nombreOK").show();
            campo[0].setCustomValidity("El nombre debe tener al menos 1 caracter");
        } else {
            $("#nombreOK").hide();
            campo[0].setCustomValidity("");
        }
    });

    $("#apellidos").change(function(){
        const campo = $("#apellidos");
        campo[0].setCustomValidity("");

        if (campo.val().length < 1){
            $("#apellidosOK").html("⚠️");
            $("#apellidosOK").show();
            campo[0].setCustomValidity("El apellido debe tener al menos 1 caracter");
        } else {
            $("#apellidosOK").hide();
            campo[0].setCustomValidity("");
        }
    });
    
    $("#pass").change(function(){
        const campo = $("#pass");
        campo[0].setCustomValidity("");

        if (campo.val().length < 5){
            $("#passOK").html("⚠️");
            $("#passOK").show();
            campo[0].setCustomValidity("La contraseña tiene que tener al menos 5 caracteres");
        } else {
            campo[0].setCustomValidity("");
            $("#passOK").hide();
        }
    });

    $("#pass2").change(function(){
        const campo = $("#pass2");
        campo[0].setCustomValidity("");

        if ($("#pass").val() != $("#pass2").val()){
            $("#pass2OK").html("⚠️");
            $("#pass2OK").show();
            campo[0].setCustomValidity("Las contraseñas deben coincidir");
        } else {
            $("#pass2OK").hide();
            campo[0].setCustomValidity("");
        }
    });

    $("#movil").change(function(){
        const campo = $("#movil");
        campo[0].setCustomValidity("");
        
        if (campo.val().length < 9 || isNaN(campo.val())){
            $("#movilOK").html("⚠️");
            $("#movilOK").show();
            campo[0].setCustomValidity("El movil debe tener un formato válido");
        } else{
            $("#movilOK").hide();
            campo[0].setCustomValidity("");
        }
    });

    $("#edad").change(function(){
        const campo = $("#edad");
        campo[0].setCustomValidity("");

        if ( Number.isInteger(parseInt(campo.val())) && campo.val() > 0 && campo.val() < 120){
            $("#edadOK").hide();
            campo[0].setCustomValidity("");
        } else {
            $("#edadOK").html("⚠️");
            $("#edadOK").show();
            campo[0].setCustomValidity("La edad debe ser un número");
        }
    });

    $("#iban").change(function(){
        const campo = $("#iban");
        campo[0].setCustomValidity("");

        console.log($("#es_profesor").is(":checked"));
        if ( $("#es_profesor").is(":checked") && !fn_ValidateIBAN(campo.val())){
            $("#ibanOK").html("⚠️");
            $("#ibanOK").show();
            campo[0].setCustomValidity("IBAN incorrecto");
        } else {
            $("#ibanOK").hide();
            campo[0].setCustomValidity("");
        }
    });


    function fn_ValidateIBAN(IBAN) {

        //Se pasa a Mayusculas
        IBAN = IBAN.toUpperCase();
        //Se quita los blancos de principio y final.
        IBAN = IBAN.trim();
        IBAN = IBAN.replace(/\s/g, ""); //Y se quita los espacios en blanco dentro de la cadena
    
        var letra1,letra2,num1,num2;
        var isbanaux;
        var numeroSustitucion;
        //La longitud debe ser siempre de 24 caracteres
        if (IBAN.length != 24) {
            return false;
        }
    
        // Se coge las primeras dos letras y se pasan a números
        letra1 = IBAN.substring(0, 1);
        letra2 = IBAN.substring(1, 2);
        num1 = getnumIBAN(letra1);
        num2 = getnumIBAN(letra2);
        //Se sustituye las letras por números.
        isbanaux = String(num1) + String(num2) + IBAN.substring(2);
        // Se mueve los 6 primeros caracteres al final de la cadena.
        isbanaux = isbanaux.substring(6) + isbanaux.substring(0,6);
    
        //Se calcula el resto, llamando a la función modulo97, definida más abajo
        resto = modulo97(isbanaux);
        if (resto == 1){
            return true;
        }else{
            return false;
        }
    }
    
    function modulo97(iban) {
        var parts = Math.ceil(iban.length/7);
        var remainer = "";
    
        for (var i = 1; i <= parts; i++) {
            remainer = String(parseFloat(remainer+iban.substr((i-1)*7, 7))%97);
        }
    
        return remainer;
    }
    
    function getnumIBAN(letra) {
        ls_letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return ls_letras.search(letra) + 10;
    }


    $("#es_profesor").change(function(){
        const campo = $("#es_profesor");
        
        if (campo[0].checked){
            $("#camposProfesor").show();
        } else {
            $("#camposProfesor").hide();
        }
    });

    $("#submit").click(function(e){
        $("#username").change();
        $("#nombre").change();
        $("#apellidos").change();
        $("#pass").change();
        $("#pass2").change();
        $("#email").change();
        $("#movil").change();
        $("#edad").change();
        $("#iban").change();
        $("#registro").submit();
    });
})