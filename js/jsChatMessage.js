$(document).ready(function() {
    $("#textoMensaje").change(function(){
        const campo = $("#textoMensaje");
        campo[0].setCustomValidity("");
        if (campo.val().length < 1){  //Vacío
            campo[0].setCustomValidity("El mensaje no puede estar vacío.");
        } else {
            campo[0].setCustomValidity("");
        }
    });

    $("#submit").click(function(){
        $("#textoMensaje").change();
    });
});