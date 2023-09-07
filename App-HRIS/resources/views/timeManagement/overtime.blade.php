@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Overtime!</h5>
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#overtime">
            Assign Overtime
        </button>
    </div>
</div>
<div class="table-responsive scrollable-table" style="max-height: 500px">
    <table class="table table-hover text-nowrap text-center align-middle">
        <thead>
            <tr>
                <th>Overtime ID</th>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Overtime Date</th>
                <th>Overtime Duration</th>
                <th>Overtime Description</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="modal fade" id="overtime" tabindex="-1" aria-labelledby="overtime" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Assign Schedule</h5>
                </div>
                <br>
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