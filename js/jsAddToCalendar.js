$(document).ready(function() {

    $(".botonHorario").each(function(){
        $(this).click(function(){
            var id = this.id;
            var url = "ajax/addToCalendar.php?id=" + id;
            $.get(url,addCalendar);
        });
    });

    function addCalendar(data,status){
        //if todo ok .display none
        if( status === "success"){
            if(data !== "error"){
                $('#claseId'+data).replaceWith( "<p><strong>Clase añadida</strong></p>" );   
            }
            else{
                console.log(data);
            }
    
        }
    }


})

