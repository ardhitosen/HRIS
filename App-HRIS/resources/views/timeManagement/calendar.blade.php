@extends('layout.app')

@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src='fullcalendar/google-calendar/main.js'></script>
<script>
    import {
        Calendar
    } from '@fullcalendar/core'; // Import the core Calendar class
    import interactionPlugin from '@fullcalendar/interaction'; // Import the interaction plugin

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: 600,
            initialView: 'dayGridMonth',
            plugins: [interactionPlugin],
            editable: true,
            droppable: true, 
            customButtons: {
                addEvent: {
                    text: 'Add Event',
                    click: function() {
                        alert('clicked the custom button!');
                    }
                }
            },
            headerToolbar: {
                start: 'title',
                center: 'addEvent',
                end: 'today prev,next'
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day',
                list: 'List'
            },
            events: [{
                title: 'Test Events',
                start: '2023-09-01',
                end: '2023-09-02'
            }],
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
            },
            droppable: true,
            selectable: true
        });
        calendar.render();
    });
</script>
<br>
<div class="card" id="calendar-card">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center">
                <div id='calendar'>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection