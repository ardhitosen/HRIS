@extends('layout.app')

@section('content')
<br>
@if ($errors->any())
<div class="alert alert-danger mt-4">
    <ul class="pl-4">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card border-0">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Attendance!</h5>
        <form method="post" action="{{route('generateAttendance')}}">
        @csrf
            <button class="btn btn-link nav-link float-end">
                Generate Attendance
            </button>
        </form>
    </div>
</div>
<br>
<div id="attendanceDetail" class="card d-flex flex-row justify-content-between">
    <div>
        <h5> {{$present}} Present </h5>
    </div>
    <div>
        <h5> {{$absent}} Absent </h5>
    </div>
    <div>
        <h5> {{$timeoff}} Time Off </h5>
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
        <tbody>
            @foreach($attendance as $attendance)
            <tr style="height: 100px">
                <td>{{ $attendance['employee_name'] ?? '-' }}</td>
                <td>{{ $attendance['employee_id'] ?? '-' }}</td>
                <td>{{ $attendance['date'] ?? '-' }}</td>
                <td>{{ $attendance['schedule_in'] ?? '-' }}</td>
                <td>{{ $attendance['schedule_out'] ?? '-' }}</td>
                <td style="color: {{ strtotime($attendance['clock_in']) > strtotime($attendance['schedule_in']) ? 'red' : 'green' }}">{{ $attendance['clock_in'] ?? '-' }}</td>
                <td style="color: {{ strtotime($attendance['clock_out']) < strtotime($attendance['schedule_out']) ? 'red' : 'green' }}">{{ $attendance['clock_out'] ?? '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ $attendance['timeoff_code'] ?? '-' }}</td>
                <td>
                    <button class="dropdown-item float-end" data-bs-toggle="modal" data-bs-target="#attendanceEdit{{$attendance['attendance_id']}}">
                        Edit
                    </button>
                </td>
                <div class="modal fade" id="attendanceEdit{{$attendance['attendance_id']}}" tabindex="-1" aria-labelledby="revision" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <h5>Edit</h5>
                                </div>
                                <br>
                                <form action="{{url('/admins/attendance/edit/' . $attendance['attendance_id'])}}" method="post">
                                    @csrf
                                    <div class="mb-3 row">
                                        <label for="schedule_in" class="col-sm-3 col-form-label">Schedule In</label>
                                        <div class="col-sm-9">
                                            <input type="time" name="schedule_in" id="schedule_out" class="form-control datepicker" value="{{$attendance['schedule_in']}}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="schedule_out" class="col-sm-3 col-form-label">Schedule In</label>
                                        <div class="col-sm-9 my-auto">
                                            <input type="time" name="schedule_out" id="schedule_out" class="form-control datepicker" value="{{$attendance['schedule_out']}}">
                                        </div>  
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </tr>
            
            @endforeach
        </tbody>
    </table>
</div>

@stop