	"use strict";
	$(document).ready(function() {




	    $('#calendar').fullCalendar({
	        header: {
	            left: 'prev,next today',
	            center: 'title',
	            right: 'month,agendaWeek,agendaDay,listMonth'
	        },
	        defaultDate: '2019-08-12',
	        navLinks: true, // can click day/week names to navigate views
	        businessHours: true, // display business hours
	        editable: false,
	        droppable: false, // this allows things to be dropped onto the calendar
	        drop: function() {

	            // is the "remove after drop" checkbox checked?
	            if ($('#checkbox2').is(':checked')) {
	                // if so, remove the element from the "Draggable Events" list
	                $(this).remove();
	            }
	        },
	        events: []
	    });
	});
