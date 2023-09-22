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
    <div class="card-body">
        <!-- <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6"> -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Attendance</h3>
                        </div>
                        <div class="card-body">
                            @if($attendance)
                            @if($attendance->clock_in && $attendance->clock_out)
                            <div class="alert alert-warning text-center">
                                You are clocked out already! Wait for new attendance.
                            </div>
                            @elseif($attendance->clock_in)
                            <h1 class="text-success text-center">You Are Present!</h1>
                            <form class="text-center mt-3" method="post" action="{{ route('frontend_clockout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block">Clock Out</button>
                            </form>
                            @else
                            <h1 class="text-danger text-center">Absent</h1>
                            <form class="text-center mt-3" method="post" action="{{ route('frontend_clockin') }}">
                                @csrf
                                <button type="submit" class="btn-center btn btn-success btn-block">Clock In</button>
                            </form>
                            @endif
                            @else
                            <div class="alert alert-danger text-center">
                                Attendance data not found.
                            </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <p>Today's Date: {{ now()->format('d M Y') }}</p>
                            <!-- <p>Current Time: {{ now()->format('H:i:s') }}</p> -->
                            <p>Current Time: <span id="time"></span></p>
                        </div>
                    <!-- </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
@stop