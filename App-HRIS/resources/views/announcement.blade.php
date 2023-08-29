@extends('layout.app')

@section('content')

<br>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Create Announcement</h5>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                <ul class="pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{url('/admins/addannouncement')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="announcement" class="form-label">Announcement Title</label>
                <input type="text" class="form-control" id="title" name="title" value={{old('title')}} required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"value={{old('description')}} required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Announcement</button>
        </form>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Announcements</h5>
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