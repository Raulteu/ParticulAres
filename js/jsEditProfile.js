$(document).ready(function() {

    $("#correoOK").hide();
    $("#passOK").hide();
    $("#pass2OK").hide();
    $("#movilOK").hide();
    $("#edadOK").hide();
    $("#camposContrasena").hide();
    
    $("#email").change(function(){
        const campo = $("#email"); // referencia jquery al campo
        campo[0].setCustomValidity(""); // limpia validaciones previas
        const regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        // validación html5, porque el campo es <input type="email" ...>
        esCorreoValido = campo[0].checkValidity(); //No está funcionando
        if ((regex.test(campo.val()) || campo.val().length < 1)) {
            $("#correoOK").hide();
            campo[0].setCustomValidity("");
        } else {
            $("#correoOK").html("⚠️");
            $("#correoOK").show();
            campo[0].setCustomValidity("Escriba un correo válido");
        }
    });
    
    $("#movil").change(function(){
        const campo = $("#movil");
        campo[0].setCustomValidity("");
        
        if (campo.val().length > 0 && (campo.val().length < 9 || isNaN(campo.val()))){
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

        if (campo.val().length < 1 || (Number.isInteger(parseInt(campo.val())) && campo.val() > 0 && campo.val() < 120)){
            $("#edadOK").hide();
            campo[0].setCustomValidity("");
        } else {
            $("#edadOK").html("⚠️");
            $("#edadOK").show();
            campo[0].setCustomValidity("La edad debe ser un número");
        }
    });

    $("#oldpass").change(function(){
        const campo = $("#oldpass");
        campo[0].setCustomValidity("");
        const campoCheck = $("#change_contrasena");

        if (campoCheck[0].checked && campo.val().length < 1){
            $("#oldpassOK").html("⚠️");
            $("#oldpassOK").show();
            campo[0].setCustomValidity("La contraseña anterior no puede estar vacía.");
        } else {
            campo[0].setCustomValidity("");
            $("#oldpassOK").hide();
        }
    });

    $("#pass").change(function(){
        const campo = $("#pass");
        campo[0].setCustomValidity("");
        const campoCheck = $("#change_contrasena");

        if (campoCheck[0].checked && campo.val().length < 5){
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
        const campoCheck = $("#change_contrasena");

        if (campoCheck[0].checked && $("#pass").val() != $("#pass2").val()){
            $("#pass2OK").html("⚠️");
            $("#pass2OK").show();
            campo[0].setCustomValidity("Las contraseñas deben coincidir");
        } else {
            $("#pass2OK").hide();
            campo[0].setCustomValidity("");
        }
    });

    $("#change_contrasena").change(function(){
        const campo = $("#change_contrasena");
        
        if (campo[0].checked){
            $("#camposContrasena").show();
        } else {
            $("#camposContrasena").hide();
        }
    });

    //Mirar comprobarPass.php porque no se como hacerlo
    /*$("#oldpass").change(function(){
        const campo = $("#oldpass");
        campo[0].setCustomValidity("");

        var url = "comprobarPass.php?pass=" + $("#oldpass").val();
        $.get(url, comprobarPass);
    });

    function comprobarPass(data,status) {
        const campo = $("#oldpass"); // referencia jquery al campo
        campo[0].setCustomValidity("");

        if (status == "success" && data == "correcta"){
            $("#userOK").html("&#x2714");
            $("#userOK").show();
        } else {
            $("#userOK").html("&#x26a0");
            $("#userOK").show();
            campo[0].setCustomValidity("Contraseña incorrecta");
        }
    }*/

    $("#submit").click(function(e){
        $("#oldpass").change();
        $("#pass").change();
        $("#pass2").change();
        $("#email").change();
        $("#movil").change();
        $("#edad").change();
        $("#registro").submit();
    });
    
   
})