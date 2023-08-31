@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Attendance!</h5>
    </div>
</div>
<br>
<div id="attendanceDetail" class="card d-flex flex-row justify-content-between">
    <div>
        <h5> Present </h5>
    </div>
    <div>
        <h5> Absent </h5>
    </div>
    <div>
        <h5> Time Off </h5>
    </div>
</div>
<div class="table-responsive scrollable-table" style="max-height: 500px">
    <table class="table table-hover text-nowrap text-center align-middle">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Attendance Date</th>
                <th>Schedule In</th>
                <th>Schedule Out</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Time Off</th>
                <th>Overtime</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody style="height: 200px">
            @foreach($employee as $emp)
            <tr>
                <td>{{ $emp['name'] ?? '-' }}</td>
                <td>{{ $emp['id'] ?? '-' }}</td>
                <td>{{ $today }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>
                    <button type="button" class="btn">
                        Edit
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop