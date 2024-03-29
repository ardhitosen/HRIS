@extends('frontend.master_layout')

@section('content')
<style>
    .card {
        animation: slideIn 0.5s ease-in-out forwards;
        opacity: 0;
        transform: translateY(-20px);
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
    <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#timeoff">
        Request a Paid Leave
    </button>
    <div class="card-body">
        <div class="card border-0 shadow show_table">
            <div class="table-responsive scrollable-table" style="max-height: 500px">
                <table id="timeoff_frontend" class="table table-hover text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Effective Date</th>
                            <th>Expiration Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeoff as $timeoff)
                        <tr style="height: 100px">
                            <td>{{ $timeoff['timeoff_id'] ?? '-' }}</td>
                            <td>{{ $timeoff['effective_date'] ?? '-' }}</td>
                            <td>{{ $timeoff['expiration_date'] ?? '-' }}</td>
                            <td>
                                <span style="{{ $timeoff['status'] == 'Pending' ? 'color: orange;' : ($timeoff['status'] == 'Accept' ? 'color: green;' : 'color: red;') }}">
                                    {{ $timeoff['status'] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="timeoff" tabindex="-1" aria-labelledby="timeoff" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request for a Paid Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/timeoff/add')}}" method="post">
                    @csrf
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