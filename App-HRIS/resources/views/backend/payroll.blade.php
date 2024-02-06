@extends('backend.layout.app')

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
                @if(!isset($emp['resign_date']))
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
                        <button class="dropdown-item float-end" data-bs-toggle="modal" data-bs-target="#payroll{{ $emp['id'] }}">
                            Edit
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="payroll{{ $emp['id'] }}" tabindex="-1" aria-labelledby="payroll" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Payroll Information</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/admins/payroll/edit/' . $emp['id'])}}" method="post">
                                    @csrf
                                    <div class="mb-3 row">
                                        <label for="reimburse" class="col-sm-3 col-form-label">New Salary</label>
                                        <div class="col-sm-9 my-auto">
                                            <input type="text" name="newSalary" id="newSalary" class="form-control" value="{{ $emp['salary'] }}">
                                        </div>
                                        <label for="reimburse" class="col-sm-3 col-form-label">New Allowance</label>
                                        <div class="col-sm-9 my-auto">
                                            <input type="text" name="newTunjanganJabatan" id="newTunjanganJabatan" class="form-control" value="{{ $emp['tunjangan'] }}">
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
                @endif
                @endforeach
            </tbody>
        </table>

    </div>
</div>


@stop