@extends('frontend.master_layout')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul class="pl-4">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
                    <p>Today's Date: {{ now()->format('Y-m-d') }}</p>
                    <p>Current Time: {{ now()->format('H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
