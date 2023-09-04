@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Timeoff!</h5>
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#timeoff">
            Assign
        </button>
    </div>
</div>
<br>
<div class="table-responsive scrollable-table" style="max-height: 500px">
    <table class="table table-hover text-nowrap text-center align-middle">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Time Off Code</th>
                <th>Effective Date</th>
                <th>Expiration Date</th>
                <th>Status</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody style="height: 100px">
            @foreach($timeoff as $timeoff)
            <tr>
                <td>{{ $timeoff['employee_name'] ?? '-' }}</td>
                <td>{{ $timeoff['id'] ?? '-' }}</td>
                <td>{{ $timeoff['time_off_code'] ?? '-' }}</td>
                <td>{{ $timeoff['effective_date'] ?? '-' }}</td>
                <td>{{ $timeoff['expiration_date'] ?? '-' }}</td>
                <td>{{ $timeoff['status'] ?? '-' }}</td>
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

<div class="modal fade" id="timeoff" tabindex="-1" aria-labelledby="timeoff" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Assign Timeoff</h5>
                </div>
                <br>
                <form action="{{url('/admins/timeoff/assign')}}" method="post">
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