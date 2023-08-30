@extends('layout.app')

@section('content')
<br>
<div class="d-flex row">
    <div class="col-2">
        <div class="text-center">
            <img src="{{ asset('images/profile_icon.jpg') }}" alt="Image" style="border-radius: 100px; width: 100px;">
            <button class="btn">Change Image</button>
        </div>
        <hr>
        <div class="d-flex row">
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/personal/' . $employee['id']) }}">Personal</a></span>
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/employment/' . $employee['id']) }}">Employment</a></span>
        </div>
    </div>
    <div class="col-10">
        <h3>Personal</h3>
        <hr>
        <div class="d-flex">
            <div class="detail">
                <p>Name</p>
                <p>Email</p>
                <p>Gender</p>
                <p>Mobile Phone</p>
                <p>Address</p>
                <p>Religion</p>
                <p>Birth Date</p>
                <p>Birth Place</p>
                <p>Marital Status</p>
            </div>
            <div class="detail">
                <p>{{ $employee['name'] ?? '-' }}</p>
                <p>{{ $employee['email'] ?? '-' }}</p>
                <p>{{ $employee['gender'] ?? '-' }}</p>
                <p>{{ $employee['mobile_phone'] ?? '-' }}</p>
                <p>{{ $employee['address'] ?? '-' }}</p>
                <p>{{ $employee['religion'] ?? '-' }}</p>
                <p>{{ $employee['birth_date'] ?? '-' }}</p>
                <p>{{ $employee['birth_place'] ?? '-' }}</p>
                <p>{{ $employee['marital_status'] ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

@stop