document.addEventListener('DOMContentLoaded', function(txt) {

var calendarEl = document.getElementById('calendar');

var eventosCalendar = [];

eventos.forEach(function(element){
	eventosCalendar.push({title: element['nombre_clase'] , 
		id: element['id'],
		rrule: { 
			dtstart: element['fecha_ini'].concat('T', element['hora_ini']) ,
			until: element['fecha_fin'] ,
			freq: 'weekly',
			byweekday: [element['dia']] ,
			interval: element['intervalo']
		},
		duration: element['duracion']
	},);
});


let calendar = new FullCalendar.Calendar(calendarEl, {
plugins: [ 'dayGrid', 'timeGrid', 'list', 'rrule' ],
header: {
	left: 'prev,next today',
	center: 'day, title',
	right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
},
defaultDate: new Date(),
locale: 'es',
timeZone: 'local',
buttonIcons: false, 
editable: false,
// Se deberia de obtener de la db los eventos que haya añadido el user (id de la sesion)  DONE

// Añadir botón de agregar a calendario en una clase que guarde el nombre, fecha y horario de inicio (ocpional), 
// fin (opcional), dias de la semana, intervalo (opcional) y duracion

events: eventosCalendar,
eventColor: 'rgb(243, 179, 61)',
eventClick: function(arg) {
	if (confirm('¿Eliminar del calendario?')) {
		arg.event.remove()
		console.log(arg)
		var url = "ajax/borrarSuscripcion.php?id=" + arg.event._def.publicId;
        $.get(url,null);
	}
},
});
calendar.render();

});