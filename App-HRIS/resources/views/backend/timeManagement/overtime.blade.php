@extends('backend.layout.app')

@section('content')
<br>
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Overtime!</h5>
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#overtime">
            Assign Overtime
        </button>
    </div>
</div>
<br>
<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 500px">
        <table id="overtimeTable" class="table table-hover text-nowrap text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Overtime Date</th>
                    <th>End Time</th>
                    <th>Overtime Description</th>
                    <th>Overtime Status</th>
                    <th>Overtime File</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overtime as $ovt)
                <tr style="height: 100px">
                    <td>{{ $ovt['overtime_id'] ?? '-' }}</td>
                    <td>{{ $ovt['employee_name'] ?? '-' }}</td>
                    <td>{{ $ovt['employee_id'] ?? '-' }}</td>
                    <td>{{ $ovt['date'] ?? '-' }}</td>
                    <td>{{ $ovt['duration'] ?? '-' }}</td>
                    <td>{{ $ovt['description'] ?? '-' }}</td>
                    <td>
                        <a href="{{ asset('storage/'.$ovt['file'])}}">Download</a>
                    </td>
                    <td>
                        <span style="{{ $ovt['status'] == 'Pending' ? 'color: orange;' : ($ovt['status'] == 'Accept' ? 'color: green;' : 'color: red;') }}">
                            {{ $ovt['status'] ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($ovt['status'] == 'Pending')
                        <div class="btn-group dropstart">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu" id="actionButton">                   
                                <li><a class="dropdown-item" href="{{ url('/admins/overtime/Accept/' . $ovt['overtime_id'])}}">Accept</a></li>
                                <li><a class="dropdown-item" href="{{ url('/admins/overtime/Decline/' . $ovt['overtime_id'])}}">Decline</a></li>
                            </ul>
                        </div>
                        @else
                        <div class="btn-group dropstart ">
                            <button type="button" class="btn dropdown-toggle disabled border-0">
                                Action
                            </button>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="overtime" tabindex="-1" aria-labelledby="overtime" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Overtime</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/admins/overtime/assign')}}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label for="maritalstatus" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9 my-auto">
                            <select name="employee_id" class="form-control" id="employee_id">
                                @foreach($employee as $emp)
                                <option value="{{ $emp['id'] }}">{{ $emp['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="scheduleDate" class="col-sm-3 col-form-label">Overtime Date</label>
                        <div class="col-sm-9 my-auto">
                            <input type="date" name="scheduleDate" id="scheduleDate" class="form-control datepicker" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="scheduleTime" class="col-sm-3 col-form-label">Overtime Duration</label>
                        <div class="col-sm-9 my-auto">
                            <input type="number" name="scheduleTime" id="scheduleTime" class="form-control datepicker" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-sm-3 col-form-label">Overtime Description</label>
                        <div class="col-sm-9 my-auto">
                            <input type="text" name="description" id="description" class="form-control" value="">
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
@stop