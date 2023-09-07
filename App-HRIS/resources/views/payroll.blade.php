@extends('layout.app')

@section('content')
<br>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Payroll!</h5>
    </div>
</div>
<div class="table-responsive scrollable-table" style="max-height: 500px">
    <table class="table table-hover text-nowrap text-center align-middle">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Salary</th>
                <th>Tunjangan BPJS</th>
                <th>Tunjangan JJK</th>
                <th>Tunjangan PPH 21</th>
                <th>Tunjangan Jabatan</th>
                <th>Overtime</th>
                <th>Total Salary</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee as $emp)
            <tr style="height: 100px">
                <td>{{ $emp['name'] ?? '-' }}</td>
                <td>{{ $emp['id'] ?? '-' }}</td>
                <td>{{ 'IDR ' . number_format($emp['salary'], 0, ',', '.') }}</td>
                <td>{{ 'IDR ' . number_format($emp['salary']*0.05, 0, ',', '.') }}</td>
                <td>{{ 'IDR ' . number_format($emp['salary']*0.05, 0, ',', '.') }}</td>
                <td>{{ 'IDR ' . number_format($emp['salary']*0.025, 0, ',', '.') }}</td>
                <td>{{ 'IDR ' . number_format(300000, 0, ',', '.') }}</td>
                <td>{{ 'IDR ' . number_format(300000, 0, ',', '.') }}</td>
                <td>
                    {{ 'IDR ' . number_format($emp['salary'] + 300000 + 300000 + 300000 + 300000, 0, ',', '.') }}
                </td>
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