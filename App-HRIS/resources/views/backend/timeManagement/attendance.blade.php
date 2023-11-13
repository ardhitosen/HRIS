@extends('backend.layout.app')

@section('content')
<br>

<div class="card border-0 title">
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
@if ($errors->any())
<div class="alert alert-danger mt-4 d-flex justify-content-between">
    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<br>
<div id="attendanceDetail" class="card d-flex flex-row justify-content-between border-0 shadow-sm">
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

<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 432px">
        <table id="attendanceTable" class="table table-hover text-nowrap text-center align-middle">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
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
                    <td>{{ $attendance['employee_id'] ?? '-' }}</td>
                    <td>{{ $attendance['employee_name'] ?? '-' }}</td>
                    <td>{{ $attendance['date'] ?? '-' }}</td>
                    <td>{{ $attendance['schedule_in'] ?? '-' }}</td>
                    <td>{{ $attendance['schedule_out'] ?? '-' }}</td>
                    <td style="color: {{ strtotime($attendance['clock_in']) > strtotime($attendance['schedule_in']) ? 'red' : 'green' }}">{{ $attendance['clock_in'] ?? '-' }}</td>
                    <td style="color: {{ strtotime($attendance['clock_out']) < strtotime($attendance['schedule_out']) ? 'red' : 'green' }}">{{ $attendance['clock_out'] ?? '-' }}</td>
                    <td>{{ $attendance['timeoff_id'] ?? '-' }}</td>
                    <td>{{ $attendance['overtime_id'] ?? '-' }}</td>
                    <td>
                        <button class="dropdown-item float-end" data-bs-toggle="modal" data-bs-target="#attendanceEdit{{$attendance['attendance_id']}}">
                            Edit
                        </button>
                    </td>
                    <div class="modal fade" id="attendanceEdit{{$attendance['attendance_id']}}" tabindex="-1" aria-labelledby="revision" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Attendance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{url('/admins/attendance/edit/' . $attendance['attendance_id'])}}" method="post">
                                        @csrf
                                        <div class="mb-3 row">
                                            <label for="schedule_in" class="col-sm-3 col-form-label">Schedule In</label>
                                            <div class="col-sm-9">
                                                <input type="time" name="schedule_in" id="schedule_in" class="form-control datepicker" value="{{$attendance['schedule_in']}}">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="schedule_out" class="col-sm-3 col-form-label">Schedule Out</label>
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
</div>
<a class="btn btn-link nav-link float-end" href="{{url('/admins/attendance/history')}}">
    View History
</a>
@stop