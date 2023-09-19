@extends('layout.app')

@section('content')
<br>
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Timeoff!</h5>
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#timeoff">
            Assign
        </button>
    </div>
</div>
<br>
<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 500px">
        <table id="timoffTable" class="table table-hover text-nowrap text-center align-middle">
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
            <tbody>
                @foreach($timeoff as $timeoff)
                <tr style="height: 100px">
                    <td>{{ $timeoff['employee_name'] ?? '-' }}</td>
                    <td>{{ $timeoff['id'] ?? '-' }}</td>
                    <td>{{ $timeoff['time_off_code'] ?? '-' }}</td>
                    <td>{{ $timeoff['effective_date'] ?? '-' }}</td>
                    <td>{{ $timeoff['expiration_date'] ?? '-' }}</td>
                    <td>
                        <span style="{{ $timeoff['status'] == 'Pending' ? 'color: orange;' : ($timeoff['status'] == 'Accept' ? 'color: green;' : 'color: red;') }}">
                            {{ $timeoff['status'] ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($timeoff['status'] == 'Pending')
                        <div class="btn-group dropstart">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu" id="actionButton">
                                <li><a class="dropdown-item" href="{{ url('/admins/timeoff/status/Accept/' . $timeoff['timeoff_id'])}}">Accept</a></li>
                                <li><a class="dropdown-item" href="{{ url('/admins/timeoff/status/Decline/' . $timeoff['timeoff_id'])}}">Decline</a></li>
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

<div class="modal fade" id="timeoff" tabindex="-1" aria-labelledby="timeoff" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Timeoff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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