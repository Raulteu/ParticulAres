$(document).ready(function() {
    $("#uploadFile").change(function(){
        const campo = $("#uploadFile");
        campo[0].setCustomValidity("");

        if (campo[0].files[0].size > 5242880){  //5MB
            $("#uplaodOK").html("⚠️");
            $("#uploadOK").show();
            campo[0].setCustomValidity("El archivo debe ser menor a 5MB");
        } else {
            $("#uplaodOK").hide();
        }
    });
});