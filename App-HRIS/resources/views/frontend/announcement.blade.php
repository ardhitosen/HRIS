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
<div class="card card_container">
    <h2 class="mb-3">Annoucement Board</h2>
    <div id="announcement_card">
        @if($announcements)
        @foreach ($announcements as $announcement)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Announcement: {{ $announcement->announcement }}</h5>
                <p>Created at: {{ $announcement->created_at->format('d M Y, H:i:s') }}</p>
                <p>{{ $announcement->description }}</p>
            </div>
        </div>
        @endforeach
        @else
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">No Announcement Available!</h5>
            </div>
        </div>
        @endif
    </div>
</div>
@stop