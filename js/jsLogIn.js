$(document).ready(function() {

    $("#nombreOK").hide();
    $("#passwordOK").hide();
   
    
    $("#nombreUsuario").change(function(){
        const campo = $("#nombreUsuario");
        campo[0].setCustomValidity("");

        if (campo.val().length < 1){
            $("#nombreOK").html("⚠️");
            $("#nombreOK").show();
            campo[0].setCustomValidity("El nombre de usuario no puede estar vacio.");
        } else {
            campo[0].setCustomValidity("");
            $("#nombreOK").hide();
        }
    });

    $("#password").change(function(){
        const campo = $("#password");
        campo[0].setCustomValidity("");

        if (campo.val().length < 1){
            $("#passwordOK").html("⚠️");
            $("#passwordOK").show();
            campo[0].setCustomValidity("La contraseña no puede estar vacia.");
        } else {
            campo[0].setCustomValidity("");
            $("#passwordOK").hide();
        }
    });


    $("#submit").click(function(e){
        $("#nombreUsuario").change();
        $("#password").change();
    });
})