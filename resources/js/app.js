import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        events: '/api/events', // Ruta para obtener eventos
        dateClick: function(info) {
            // Lógica para el click en la fecha
        },
        eventClick: function(info) {
            // Lógica para el click en el evento
        }
    });
    calendar.render();
});
