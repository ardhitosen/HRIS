@extends('backend.layout.app')

@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src="
https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js
"></script>
<script src='fullcalendar/google-calendar/main.js'></script>
<script>
    // import {
    //     Calendar
    // } from '@fullcalendar/core'; // Import the core Calendar class
    // import interactionPlugin from '@fullcalendar/interaction'; // Import the interaction plugin
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: 600,
            initialView: 'dayGridMonth',
            // plugins: [FullCalendarInteraction],
            editable: true,
            droppable: true, 
            customButtons: {
                addEvent: {
                    text: 'Add Event',
                    click: function() {
                        $('#myModal').modal('show');
                    }
                }
            },
            headerToolbar: {
                left: 'prev,next today,addEvent',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day',
                list: 'List'
            },
            events: [
                @foreach($events as $event)
                    {
                        title: '{{ $event['title'] }}',
                        start: '{{ $event['start_date'] }}',
                        end: '{{$event['end_date'] ?? null}}'
                    },
                @endforeach
            ],
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
@if ($errors->any())
<div class="alert alert-danger mt-4">
    <ul class="pl-4">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card" id="calendar-card">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center">
                <div id='calendar'>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="revision" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/admins/calendar/addevent')}}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <label for="title" class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9 my-auto">
                                <textarea name="title" id="title" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="start_date" class="col-sm-3 col-form-label">Start Date</label>
                            <div class="col-sm-9">
                                <input type="date" name="start_date" id="start_date" class="form-control datepicker" placeholder="YYYY-MM-DD" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="end_date" class="col-sm-3 col-form-label">End Date (optional)</label>
                            <div class="col-sm-9">
                                <input type="date" name="end_date" id="end_date" class="form-control datepicker" placeholder="YYYY-MM-DD" value="">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection