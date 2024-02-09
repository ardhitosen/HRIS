@extends('backend.layout.app')

@section('content')
<br>
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Reimbursement!</h5>
    </div>
</div>
<br>

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
                    <th>File</th>
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
                        <a href="" onclick="openImageWindow('{{ base64_encode($reim['proof']) }}')">
                            <img src="data:image/jpeg;base64,{{ base64_encode($reim['proof']) }}" width="50px" alt="Click to open in new page">
                        </a>
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
                <div class="modal fade" id="revision{{ $reim['id'] }}" tabindex="-1" aria-labelledby="revision" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Revision</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/admins/reimbursement/status/revision/' . $reim['id'])}}" method="post">
                                    @csrf
                                    <div class="mb-3 row">
                                        <label for="reimburse" class="col-sm-3 col-form-label">Reason for revision</label>
                                        <div class="col-sm-9 my-auto">
                                            <textarea name="reason" id="reason" class="form-control"></textarea>
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

<script>
function openImageWindow(base64Image) {
  var imageWindow = window.open();
  imageWindow.document.write('<html><body><img src="data:image/jpeg;base64,' + base64Image + '"></body></html>');
}
</script>

@stop