@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Scheduler!</h5>
    </div>
</div>
<br>
<div class="table-responsive scrollable-table" style="max-height: 500px">
    <table class="table table-hover text-nowrap text-center align-middle">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Branch</th>
                <th>Organization</th>
                <th>Job Position</th>
                <th>Current Schedule</th>
                <th>Schedule Time</th>
                <th>Schedule Description</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee as $emp)
            <tr style="height: 100px">
                <td>{{ $emp['name'] ?? '-' }}</td>
                <td>{{ $emp['id'] ?? '-' }}</td>
                <td>{{ $emp['branch'] ?? '-' }}</td>
                <td>{{ $emp['organization'] ?? '-' }}</td>
                <td>{{ $emp['job_position'] ?? '-' }}</td>
                <td>{{ $emp['current_schedule'] ?? '-' }}</td>
                <td>{{ $emp['schedule_time'] ?? '-' }}</td>
                <td>{{ $emp['schedule_description'] ?? '-' }}</td>
                <td>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#scheduler_{{ $emp['id'] }}">
                        Assign
                    </button>
                </td>
            </tr>
            <div class="modal fade" id="scheduler_{{ $emp['id'] }}"  tabindex="-1" aria-labelledby="scheduler" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <h5>Assign Schedule</h5>
                            </div>
                            <br>
                            <form action="{{url('/admins/scheduler/assign')}}" method="post">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="maritalstatus" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9 my-auto">
                                        <select name="employee_id" class="form-control" id="employee_id" disabled>
                                            <option value="{{ $emp['id'] }}">{{ $emp['name'] }}</option>
                                        </select>
                                        <select name="employee_id" class="form-control" id="employee_id" style="display: none;">
                                            <option value="{{ $emp['id'] }}">{{ $emp['name'] }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="scheduleDate" class="col-sm-3 col-form-label">Schedule Date</label>
                                    <div class="col-sm-9 my-auto">
                                        <input type="date" name="scheduleDate" id="scheduleDate" class="form-control datepicker" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="scheduleTime" class="col-sm-3 col-form-label">Schedule Time</label>
                                    <div class="col-sm-9 my-auto">
                                        <input type="time" name="scheduleTime" id="scheduleTime" class="form-control datepicker" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="description" class="col-sm-3 col-form-label">Description</label>
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
            @endforeach
        </tbody>
    </table>
</div>


@stop