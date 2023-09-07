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
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/transferlog/' . $employee['id']) }}">Transfer Log</a></span>
        </div>
    </div>
    <div class="col-10">
        <div class="d-flex">
            <h3>Transfer Log</h3>
        </div>
        <hr>
        <div>
            @foreach($transferData as $log)
            <div>
                <p>{{ $log['date'] }}</p>
            </div>
            <div>
                <table class="table w-50">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Old</th>
                            <th scope="col">New</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Branch</th>
                            <td>{{ $log['old_branch'] }}</td>
                            <td>{{ $log['new_branch'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Position</th>
                            <td>{{ $log['old_position'] }}</td>
                            <td>{{ $log['new_position'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Level</th>
                            <td>{{ $log['old_level'] }}</td>
                            <td>{{ $log['new_level'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br><hr>
            @endforeach
        </div>
    </div>
</div>

@stop