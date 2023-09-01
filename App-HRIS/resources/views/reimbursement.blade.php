@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Reimbursement!</h5>
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#reimburse">
            Create Reimbursement
        </button>
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
        <tbody style="height: 200px">
            @foreach($employee as $emp)
            <tr>
                <td>{{ $emp['name'] ?? '-' }}</td>
                <td>{{ $emp['id'] ?? '-' }}</td>
                <td>{{ $emp['branch'] ?? '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>
                    <button type="button" class="btn">
                        Add Schedule
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="reimburse" tabindex="-1" aria-labelledby="reimburse" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Create Reimbursement</h5>
                </div>
                <br>
                <form action="{{url('/admins/reimbursement/create')}}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label for="maritalstatus" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <select name="name" class="form-control" id="martialstatus" value="{{ old('name') }}">
                                @foreach($employee as $emp)
                                <option value="{{ $emp['id'] }}">{{ $emp['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="joindate" class="col-sm-2 col-form-label">Join Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="joindate" id="joindate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('joindate') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="maritalstatus" class="col-sm-2 col-form-label">Marital Status</label>
                        <div class="col-sm-10">
                            <select name="maritalstatus" class="form-control" id="martialstatus" value="{{ old('martialstatus') }}">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="reimburse" class="col-sm-2 col-form-label">Reimburse Amount</label>
                        <div class="col-sm-10">
                            <input type="text" name="reimburse" id="reimburse" class="form-control" value="{{ old('reimburse') }}">
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