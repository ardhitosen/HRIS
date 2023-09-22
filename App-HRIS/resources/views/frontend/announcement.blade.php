@extends('frontend.master_layout')

@section('content')
<style>
    .card {
        animation: slideIn 0.5s ease-in-out forwards;
        opacity: 0;
        transform: translateY(-20px);
        text-align: center;
        padding: 20px;
    }
    
    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
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