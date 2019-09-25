$(document).ready(function() {



    $(".mensaje").each(function(){
        $(this).click(function(){
            var id = this.id;
            var url = "ajax/borrarMensaje.php?id=" + id;
            $.get(url,borrarComment);
        });
    });

    function borrarComment(data,status){
        //if todo ok .display none
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

