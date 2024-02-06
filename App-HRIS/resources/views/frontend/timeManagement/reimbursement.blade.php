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
    <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#reimburse">
        Request Reimbursement
    </button>

    <div class="card-body">

        <div class="card border-0 shadow show_table">
            <div class="table-responsive scrollable-table" style="max-height: 500px">
                <table id="reimbursementTableFrontend" class="table table-hover text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>Reimburse ID</th>
                            <th>Reimbursement Type</th>
                            <th>Total Reimbursement</th>
                            <th>File</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reimbursement as $reim)
                        <tr style="height: 100px">
                            <td>{{ $reim['reimburse_id'] ?? '-' }}</td>
                            <td>{{ $reim['reimbursement_type'] ?? '-' }}</td>
                            <td>{{ 'IDR ' . number_format($reim['total_reimbursement'], 0, ',', '.') }}</td>
                            <td>
                                <a href="" onclick="openImageWindow('{{ base64_encode($reim['proof']) }}')">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($reim['proof']) }}" width="50px" alt="Click to open in new page">
                                </a>
                            </td>
                            <td>
                                <span style="{{ $reim['status'] == 'Pending' ? 'color: orange;' : ($reim['status'] == 'Accept' ? 'color: green;' : 'color: red;') }}">
                                    {{ $reim['status'] ?? '-' }}
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
<div class="modal fade" id="reimburse" tabindex="-1" aria-labelledby="reimburse" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request for Reimbursement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/reimbursement/create')}}" method="post" enctype="multipart/form-data">
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



<script>
function openImageWindow(base64Image) {
  var imageWindow = window.open();
  imageWindow.document.write('<html><body><img src="data:image/jpeg;base64,' + base64Image + '"></body></html>');
}
</script>
@stop