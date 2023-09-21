@extends('frontend.master_layout')

@section('content')
<br>
@if($announcements)
    @foreach ($announcements as $announcement)
    <br>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Announcement: {{ $announcement->announcement }}</h5>
            <p>{{ $announcement->description }}</p>
        </div>
    </div>
    @endforeach
@else
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">No Announcement Available!</h5>
        </div>
    </div>
@endif
@stop