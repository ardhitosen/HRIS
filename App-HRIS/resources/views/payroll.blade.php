@extends('layout.app')

@section('content')
<br>
<div class="card border-0 title">
    <div class="card-body">
        <h5 class="card-title">Payroll!</h5>
    </div>
</div>
<br>
<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 500px">
        <table id="payrollTable" class="table table-hover text-nowrap text-center align-middle">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>ID</th>
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
                    <td>{{ 'IDR ' . number_format($emp['tunjangan'], 0, ',', '.') }}</td>
                    <td>
                        @if(isset($emp['overtime_duration']))
                            {{ 'IDR ' . number_format($emp['overtime_duration'] * 100000, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        {{ 'IDR ' . number_format(($emp['salary'] + $emp['tunjangan'] + (isset($emp['overtime_duration']) ? $emp['overtime_duration'] * 100000 : 0)), 0, ',', '.') }}
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
</div>


@stop