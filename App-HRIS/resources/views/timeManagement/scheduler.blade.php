@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Scheduler!</h5>
    </div>
</div>
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
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee as $emp)
            <tr style="height: 100px">
                <td>{{ $emp['name'] ?? '-' }}</td>
                <td>{{ $emp['id'] ?? '-' }}</td>
                <td>{{ $emp['branch'] ?? '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#scheduler">
                        Assign
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="scheduler" tabindex="-1" aria-labelledby="scheduler" aria-hidden="true">
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
                            <select name="employee_id" class="form-control" id="employee_id" value="{{ old('name') }}">
                                @foreach($employee as $emp)
                                <option value="{{ $emp['id'] }}">{{ $emp['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="timeoffcode" class="col-sm-3 col-form-label">Time Off Code</label>
                        <div class="col-sm-9 my-auto">
                            <input type="text" name="timeoffcode" id="timeoffcode" class="form-control datepicker" placeholder="TO-xxxx" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="effectiveDate" class="col-sm-3 col-form-label">Effective Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="effectiveDate" id="effectiveDate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="expDate" class="col-sm-3 col-form-label">Expiration Date</label>
                        <div class="col-sm-9 my-auto">
                            <input type="date" name="expDate" id="expDate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="">
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