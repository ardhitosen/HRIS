@extends('layout.app')

@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth'
    });
    calendar.render();
  });

</script>
<br>
<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
@endsection
