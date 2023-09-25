@extends('frontend.master_layout')

@section('content')
<style>
    .card {
        animation: slideIn 0.5s ease-in-out forwards;
        opacity: 0;
        transform: translateY(-20px);
        text-align: center;
        padding: 20px;
    }

    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@if ($errors->any())
<div class="alert alert-danger mt-4">
    <ul class="pl-4">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card card_container">
    <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#reimburse">
        Create Reimbursement
    </button>

    <div class="card-body">

        <div class="card border-0 shadow show_table">
            <div class="table-responsive scrollable-table" style="max-height: 500px">
                <table id="reimbursementTable" class="table table-hover text-nowrap text-center align-middle">
                    <thead>
                        <tr>
                            <th>Reimburse ID</th>
                            <th>Employee Name</th>
                            <th>Employee ID</th>
                            <th>Reimbursement Type</th>
                            <th>Total Reimbursement</th>
                            <th>Status</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reimbursement as $reim)
                        <tr style="height: 100px">
                            <td>{{ $reim['id'] ?? '-' }}</td>
                            <td>{{ $reim['name'] ?? '-' }}</td>
                            <td>{{ $reim['employee_id'] ?? '-' }}</td>
                            <td>{{ $reim['reimbursement_type'] ?? '-' }}</td>
                            <td>{{ 'IDR ' . number_format($reim['total_reimbursement'], 0, ',', '.') }}</td>
                            <td>
                                <span style="{{ $reim['status'] == 'Pending' ? 'color: orange;' : ($reim['status'] == 'Accept' ? 'color: green;' : 'color: red;') }}">
                                    {{ $reim['status'] ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($reim['status'] == 'Pending')
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu" id="actionButton">
                                        <li><a class="dropdown-item" href="{{ url('/admins/reimbursement/status/Accept/' . $reim['id'])}}">Accept</a></li>
                                        <li>
                                            <button class="dropdown-item float-end" data-bs-toggle="modal" data-bs-target="#revision{{ $reim['id'] }}">
                                                Revision
                                            </button>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('/admins/reimbursement/status/Decline/' . $reim['id'])}}">Decline</a></li>
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
    </div>
</div>
<div class="modal fade" id="reimburse" tabindex="-1" aria-labelledby="reimburse" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Reimbursement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/employee/reimbursement/create')}}" method="post" enctype="multipart/form-data">
                    @csrf
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
                    <div class="mb-3 row">
                        <label for="proof" class="col-sm-3 col-form-label">Proof of Payment</label>
                        <div class="col-sm-9 my-auto">
                            <input type="file" name="proof" id="proof" class="form-control" value="{{ old('proof') }}">
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