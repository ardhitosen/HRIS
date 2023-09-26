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
    <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#overtime">
        Request Overtime
    </button>
    <div class="card-body">
        <div class="card border-0 shadow show_table">
            <div class="table-responsive scrollable-table" style="max-height: 500px">
                <table id="overtimeTable_frontend" class="table table-hover text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Overtime Date</th>
                            <th>Overtime Duration</th>
                            <th>Overtime Description</th>
                            <th>Overtime Status</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overtime as $ovt)
                        <tr style="height: 100px">
                            <td>{{ $ovt['overtime_id'] ?? '-' }}</td>
                            <td>{{ $ovt['overtime_date'] ?? '-' }}</td>
                            <td>{{ $ovt['duration'] ?? '-' }}</td>
                            <td>{{ $ovt['description'] ?? '-' }}</td>
                            <td>
                                <span style="{{ $ovt['status'] == 'Pending' ? 'color: orange;' : ($ovt['status'] == 'Accept' ? 'color: green;' : 'color: red;') }}">
                                    {{ $ovt['status'] ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ asset('storage/'.$ovt['file'])}}">Download</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="overtime" tabindex="-1" aria-labelledby="overtime" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Overtime</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/employee/overtime/add')}}" method="post" enctype="multipart/form-data">
                    @csrf
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
                    <div class="mb-3 row">
                        <label for="overtimeWork" class="col-sm-3 col-form-label">Overtime Work</label>
                        <div class="col-sm-9 my-auto">
                            <input type="file" name="overtimeWork" id="overtimeWork" class="form-control">
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