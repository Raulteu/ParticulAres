$(document).ready(function() {

    $("#correoOK").hide();
    $("#userOK").hide();

    $("#email").change(function(){
        const campo = $("#email"); // referencia jquery al campo
        campo[0].setCustomValidity(""); // limpia validaciones previas

        // validación html5, porque el campo es <input type="email" ...>
        const esCorreoValido = campo[0].checkValidity();
        if (esCorreoValido) {
            $("#correoOK").html("&#x2714");
            $("#correoOK").show();

            campo[0].setCustomValidity("");
        } else {            
            $("#correoOK").html("&#x26a0");
            $("#correoOK").show();

            campo[0].setCustomValidity(
                "Escriba un correo válido");
        }
    });

    
    $("#username").change(function(){
        const campo = $("#username");
        campo[0].setCustomValidity("");

        if ($("#username").html().length < 5){
            campo[0].setCustomValidity("El nombre de usuario debe tener al menos 5 caracteres");
        }

        var url = "ajax/comprobarUsuario.php?user=" + $("#username").val();
        $.get(url,usuarioExiste);
    });

    function usuarioExiste(data,status) {
        // tu codigo aqui
        const campo = $("#username"); // referencia jquery al campo
        campo[0].setCustomValidity("");

        if (status == "success" && data == "disponible"){
            $("#userOK").html("&#x2714");
            $("#userOK").show();
        } else {
            $("#userOK").html("&#x26a0");
            $("#userOK").show();
            campo[0].setCustomValidity(
                "El usuario no está disponible");
        }
    }

    $("#nombre").change(function(){
        const campo = $("#nombre");
        campo[0].setCustomValidity("");

        if ($("#nombre").html().length < 1){
            campo[0].setCustomValidity("El nombre debe tener al menos 1 caracter");
        }
    });

    $("#apellidos").change(function(){
        const campo = $("#apellidos");
        campo[0].setCustomValidity("");

        if ($("#apellidos").html().length < 1){
            campo[0].setCustomValidity("El apellido debe tener al menos 1 caracter");
        }
    });
    
    $("#pass").change(function(){
        const campo = $("#pass");
        campo[0].setCustomValidity("");

        if ($("#pass").html().length < 5){
            campo[0].setCustomValidity("La contraseña tiene que tener al menos 5 caracteres");
        }
    });

    $("#pass2").change(function(){
        const campo = $("#pass2");
        campo[0].setCustomValidity("Haz algo");

        if ($("#pass").html() != $("#pass2").html()){
            campo[0].setCustomValidity("Las contraseñas deben coincidir");
        } else {
            campo[0].setCustomValidity("Chachi");
        }
    });

    $("#movil").change(function(){
        const campo = $("#movil");
        campo[0].setCustomValidity("");

        if ($("#movil").html().length < 8){
            campo[0].setCustomValidity("El movil debe tener un formato válido");
        }
    });

    $("#edad").change(function(){
        const campo = $("#edad");
        campo[0].setCustomValidity("");

        if ( !isnumeric($("#edad").html())){
            campo[0].setCustomValidity("La edad debe ser un número");
        }
    });
})