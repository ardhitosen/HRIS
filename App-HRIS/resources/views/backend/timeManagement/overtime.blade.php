@extends('backend.layout.app')

@section('content')
<br>
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Overtime!</h5>
    </div>
</div>
<br>
<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 500px">
        <table id="overtimeTable" class="table table-hover text-nowrap text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Overtime Date</th>
                    <th>End Time</th>
                    <th>Overtime Description</th>
                    <th>Overtime Status</th>
                    <th>Overtime File</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overtime as $ovt)
                <tr style="height: 100px">
                    <td>{{ $ovt['overtime_id'] ?? '-' }}</td>
                    <td>{{ $ovt['employee_name'] ?? '-' }}</td>
                    <td>{{ $ovt['employee_id'] ?? '-' }}</td>
                    <td>{{ $ovt['date'] ?? '-' }}</td>
                    <td>{{ $ovt['duration'] ?? '-' }}</td>
                    <td>{{ $ovt['description'] ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin_overtime_download', ['filename' => $ovt['file']]) }}">Download</a>
                    </td>
                    <td>
                        <span style="{{ $ovt['status'] == 'Pending' ? 'color: orange;' : ($ovt['status'] == 'Accept' ? 'color: green;' : 'color: red;') }}">
                            {{ $ovt['status'] ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($ovt['status'] == 'Pending')
                        <div class="btn-group dropstart">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu" id="actionButton">
                                <li><a class="dropdown-item" href="{{ url('/admins/overtime/Accept/' . $ovt['overtime_id'])}}">Accept</a></li>
                                <li><a class="dropdown-item" href="{{ url('/admins/overtime/Decline/' . $ovt['overtime_id'])}}">Decline</a></li>
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