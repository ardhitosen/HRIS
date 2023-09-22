@extends('backend.layout.app')

@section('content')
<br>
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Scheduler!</h5>
        <button class="btn" data-bs-toggle="modal" data-bs-target="#createscheduler">
            Assign Scheduler
        </button>
    </div>
</div>
<br>

<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 500px">
        <table id="schedulerTable" class="table table-hover text-nowrap text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
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
                @foreach($scheduler as $sched)
                <tr style="height: 100px">
                    <td>{{ $sched['scheduler_id'] ?? '-' }}</td>
                    <td>{{ $sched['name'] ?? '-' }}</td>
                    <td>{{ $sched['employee_id'] ?? '-' }}</td>
                    <td>{{ $sched['branch'] ?? '-' }}</td>
                    <td>{{ $sched['organization'] ?? '-' }}</td>
                    <td>{{ $sched['job_position'] ?? '-' }}</td>
                    <td>{{ $sched['current_schedule'] ?? '-' }}</td>
                    <td>{{ $sched['schedule_time'] ?? '-' }}</td>
                    <td>{{ $sched['schedule_description'] ?? '-' }}</td>
                    <td>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#scheduler_{{ $sched['employee_id'] }}">
                            Edit
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="scheduler_{{ $sched['employee_id'] }}" tabindex="-1" aria-labelledby="scheduler" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign a Schedule</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/admins/scheduler/assign')}}" method="post">
                                    @csrf
                                    <div class="mb-3 row">
                                        <label for="maritalstatus" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9 my-auto">
                                            <select name="employee_id" class="form-control" id="employee_id" disabled>
                                                <option value="{{ $sched['employee_id'] }}">{{ $sched['name'] }}</option>
                                            </select>
                                            <select name="employee_id" class="form-control" id="employee_id" style="display: none;">
                                                <option value="{{ $sched['employee_id'] }}">{{ $sched['name'] }}</option>
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
</div>

<div class="modal fade" id="createscheduler" tabindex="-1" aria-labelledby="createscheduler" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign a Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/admins/scheduler/assign')}}" method="post">
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
@stop