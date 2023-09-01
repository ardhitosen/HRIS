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
<br>
<div class="table-responsive scrollable-table" style="max-height: 500px">
    <table class="table table-hover text-nowrap text-center align-middle">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Reimbursement Type</th>
                <th>Total Reimbursement</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reimbursement as $reim)
            <tr style="height: 100px">
                <td>{{ $reim['name'] ?? '-' }}</td>
                <td>{{ $reim['id'] ?? '-' }}</td>
                <td>{{ $reim['reimbursement_type'] ?? '-' }}</td>
                <td>{{ $reim['total_reimbursement'] ?? '-' }}</td>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Create Reimbursement</h5>
                </div>
                <br>
                <form action="{{url('/admins/reimbursement/create')}}" method="post">
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
                        <label for="reimbursement_type" class="col-sm-3 col-form-label">Reimbursement Type</label>
                        <div class="col-sm-9 my-auto">
                            <select name="reimbursement_type" class="form-control" id="reimbursement_type" value="{{ old('reimbursement_type') }}">
                                <option value="Travel">Travel Expenses</option>
                                <option value="Insurance">Insurance</option>
                                <option value="Business">Business Expenses</option>
                                <option value="Tax">Tax Refund</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="reimburse" class="col-sm-3 col-form-label">Reimburse Amount</label>
                        <div class="col-sm-9 my-auto">
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