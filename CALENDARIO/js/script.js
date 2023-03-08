var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {
    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k]
            events.push({ id: row.id, title: row.titulo, start: row.hora_inicio, end: row.hora_final, nombre_recurso: row.nombre_recurso});
        })
    }

    calendar = new Calendar(document.getElementById('calendar'), {
        locale:'es',
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
       // selectable: true,
        dayMaxEvents: true,
        themeSystem: 'bootstrap',
        //Random default events
        events: events,
        eventClick: function(info) {
            var _details = $('#event-details-modal')
            var id = info.event.id
            if (!!scheds[id]) {
                _details.find('#nombre_recurso').text(scheds[id].nombre_recurso)
                _details.find('#titulo').text(scheds[id].titulo)
                _details.find('#descripcion').text(scheds[id].descripcion)
                _details.find('#nombre_completo').text(scheds[id].nombre_completo)
                _details.find('#start').text(scheds[id].hora_inicio)
                _details.find('#end').text(scheds[id].hora_final)
                _details.modal('show')
            } else {
                alert("Reserva sin definir");
            }
        },
    });

    calendar.render();
})
