@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Timeoff!</h5>
    </div>
</div>
<div class="table-responsive scrollable-table" style="max-height: 500px">
    <table class="table table-hover text-nowrap text-center align-middle">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Time Off Code</th>
                <th>Effective Date</th>
                <th>Expiration Date</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody style="height: 200px">
            @foreach($employee as $emp)
            <tr>
                <td>{{ $emp['name'] ?? '-' }}</td>
                <td>{{ $emp['id'] ?? '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>{{ '-' }}</td>
                <td>
                    <button type="button" class="btn">
                        Edit
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop