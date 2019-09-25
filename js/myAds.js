$(document).ready(function() {



    $(".anuncio").each(function(){
        $(this).click(function(){
            var id = this.id;
            var url = "ajax/borrarAnuncio.php?id=" + id;
            $.get(url,borrarAnun);
        });
    });

    function borrarAnun(data,status){
        if( status === "success"){
            if(data !== "error"){
                $('#'+data).remove();
            }
            else{
                console.log(data);
            }
        }
    }
})

