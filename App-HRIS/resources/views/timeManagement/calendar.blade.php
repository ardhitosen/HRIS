@extends('layout.app')

@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src='fullcalendar/google-calendar/main.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day',
                list: 'List'
            },
            // plugins: [ 'googleCalendar' ],
            // googleCalendarApiKey: 'AIzaSyD31VE3KMcRKOjddUdwhywNBLbJMOHB_88',
            // events: {
            //   googleCalendarId: 'cddf74f07479800feaaa393add109f00e896c722f5bcf9b0c2c5653d1cf02c96@group.calendar.google.com'
            // }, ga paham
            eventClick: {

            },
            headerToolbar: {
                start: 'title', // will normally be on the left. if RTL, will be on the right
                center: '',
                end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
            }
        });
        calendar.render();
    });
</script>
<br>
<div class="card" id="calendar-card">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

@endsection