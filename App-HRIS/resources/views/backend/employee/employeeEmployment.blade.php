@extends('backend.layout.app')

@section('content')
<br>
<div class="d-flex row">
    <div class="col-2">
        <div class="text-center d-flex row justify-content-center">
            <div class="shadow " style="border-radius: 100px; width: 100px !important; height: 100px !important; overflow: hidden;">
                @if($employee->photo == NULL)
                <img src="{{ asset('images/profile_icon.jpg') }}" alt="Image" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                <img src="data:image/jpeg;base64,{{ base64_encode($employee->photo) }}" alt="Image" class="rounded-circle" style="width: 100%; height: 100%; object-fit: contain;">
                @endif
            </div>
            <button class="btn">Change Image</button>
        </div>
        <hr>
        <div class="d-flex row">
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/personal/' . $employee['id']) }}">Personal</a></span>
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/employment/' . $employee['id']) }}">Employment</a></span>
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/transferlog/' . $employee['id']) }}">Transfer Log</a></span>
        </div>
    </div>
    <div class="col-10">
        <div class="d-flex ">
            <h3>Employment</h3>
        </div>
        <hr>
        <div class="d-flex">
            <div class="detail">
                <p>ID</p>
                <p>Branch</p>
                <p>Organization</p>
                <p>Job Position</p>
                <p>Job Level</p>
                <p>Join Date</p>
                <p>Resign Date</p>
            </div>
            <div class="detail">
                <p>{{ $employee['id'] ?? '-' }}</p>
                <p>{{ $employee['branch'] ?? '-' }}</p>
                <p>{{ $employee['organization'] ?? '-' }}</p>
                <p>{{ $employee['job_position'] ?? '-' }}</p>
                <p>{{ $employee['job_level'] ?? '-' }}</p>
                <p>{{ $employee['join_date'] ?? '-' }}</p>
                <p>{{ $employee['resign_date'] ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>


@stop