@extends('backend.layout.app')

@section('content')
<br>
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Timeoff!</h5>
    </div>
</div>
<br>
<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 500px">
        <table id="timoffTable" class="table table-hover text-nowrap text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Effective Date</th>
                    <th>Expiration Date</th>
                    <th>Status</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timeoff as $timeoff)
                <tr style="height: 100px">
                    <td>{{ $timeoff['timeoff_id'] ?? '-' }}</td>
                    <td>{{ $timeoff['employee_name'] ?? '-' }}</td>
                    <td>{{ $timeoff['id'] ?? '-' }}</td>
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

@stop