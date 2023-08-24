@extends('layout.app')

@section('content')
<br>
<div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome, Admin!</h5>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Announcement</h5>
            @if($announcements->isEmpty())
                <p class="card-text">No announcements available.</p>
            @else
                <div id="announcement">
                    <h6>{{ $announcements[0]->announcement }}</h6>
                    <p>{{ $announcements[0]->description }}</p>
                </div>
                @if($announcements->count() > 1)
                    <button id="nextAnnouncement" class="btn btn-primary mt-3">Next Announcement</button>
                @endif
            @endif
        </div>
    </div>
</div>

<script>
    var currentAnnouncement = 0;
    var announcements = @json($announcements);

    @if($announcements->count() > 1)
        document.getElementById('nextAnnouncement').addEventListener('click', function () {
            currentAnnouncement = (currentAnnouncement + 1) % announcements.length;
            updateAnnouncement();
        });
    @endif

    function updateAnnouncement() {
        var announcement = announcements[currentAnnouncement];
        document.getElementById('announcement').innerHTML = `
            <h6>${announcement.announcement}</h6>
            <p>${announcement.description}</p>
        `;
    }
</script>

@stop
