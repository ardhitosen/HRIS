@extends('frontend.master_layout')

@section('content')
<div class="card card_container">
    <div id="header">
        <div class="card-body">
            <h3>Welcome, {{ session()->get('employee') ->name}}!</h3>
            <p class="card-text">Thank you for being part of {{ session()->get('employee')->organization}}!, and your presence fills us with excitement and gratitude. Thank you for joining our community, where your contributions and presence are greatly valued and cherished!</p>
        </div>
    </div>
    <div class="card-body">
        <div id="shortcut">
            <span>
                <a href="{{url('/attendance')}}" class="btn">
                    <img src="{{ asset('images/attendance.png') }}" alt="">
                    <p>Take Attendance</p>
                </a>
            </span>
            <span>
                <a href="{{url('/timeoff')}}" class="btn">
                    <img src="{{ asset('images/day-off.png') }}" alt="">
                    <p>Take a Paid Leave</p>
                </a>
            </span>
            <span>
                <a href="{{url('/overtime')}}" class="btn">
                    <img src="{{ asset('images/overtime.png') }}" alt="">
                    <p>Request Overtime</p>
                </a>
            </span>
            <span>
                <a href="{{url('/reimbursement')}}" class="btn">
                    <img src="{{ asset('images/reimbursement.png') }}" alt="">
                    <p>Request Reimbursement</p>
                </a>
            </span>
            <span>
                <a href="{{url('/announcement')}}" class="btn">
                    <img src="{{ asset('images/annoucement.png') }}" alt="">
                    <p>View Announcement</p>
                </a>
            </span>
        </div>
    </div>
</div>
@stop