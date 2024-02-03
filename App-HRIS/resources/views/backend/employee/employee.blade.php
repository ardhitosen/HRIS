@extends('backend.layout.app')

@section('content')


<br>
@if ($errors->any())
<div class="alert alert-danger mt-4">
    <ul class="pl-4">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Employee!</h5>
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#addEmployee">
            Add Employee
        </button>
    </div>
</div>
<br>
<div class="card border-0 shadow show_table">
    <div class="table-responsive scrollable-table" style="max-height: 500px">
        <table id="employeeTable" class="table table-hover text-nowrap text-center align-middle">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Division</th>
                    <th>Organization</th>
                    <th>Job Position</th>
                    <th>Job Level</th>
                    <th>Join Date</th>
                    <th>Resign Date</th>
                    <th>Email</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee as $emp)
                <tr style="height: 100px">
                    <td>{{ $emp['name'] ?? '-' }}</td>
                    <td>{{ $emp['id'] ?? '-' }}</td>
                    <td>{{ $emp['branch'] ?? '-' }}</td>
                    <td>{{ $emp['organization'] ?? '-' }}</td>
                    <td>{{ $emp['job_position'] ?? '-' }}</td>
                    <td>{{ $emp['job_level'] ?? '-' }}</td>
                    <td>{{ $emp['join_date'] ?? '-' }}</td>
                    <td>{{ $emp['resign_date'] ?? '-' }}</td>
                    <td>{{ $emp['email'] ?? '-' }}</td>
                    <td>
                        <div class="btn-group dropstart">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            @if(!isset( $emp['resign_date'] ))
                            <ul class="dropdown-menu" id="actionButton">
                                <li><a class="dropdown-item" href="{{ url('/admins/employee/detail/personal/' . $emp['id']) }}">Detail</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#transferEmployee{{$emp['id']}}">Transfer</a></li>
                                <li><a class="dropdown-item" href="{{ url('/admins/employee/resign/' . $emp['id'])}}">Resign</a></li>
                            </ul>
                            @else
                            <ul class="dropdown-menu" id="actionButton">
                                <li><a class="dropdown-item" href="{{ url('/admins/employee/detail/personal/' . $emp['id']) }}">Detail</a></li>
                            </ul>
                            @endif
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="transferEmployee{{$emp['id']}}" tabindex="-1" aria-labelledby="transferEmployee{{$emp['id']}}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Transfer Employee</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/admins/employee/transfer/' . $emp['id']) }}" method="post">
                                    @csrf
                                    <div class="mb-3 row">
                                        <label for="oldBranch" class="col-sm-3 col-form-label">Old Branch</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="oldBranch" id="oldBranch" class="form-control" value="{{ $emp['branch'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="oldPosition" class="col-sm-3 col-form-label">Old Position</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="oldPosition" id="oldPosition" class="form-control" value="{{ $emp['job_position'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="oldLevel" class="col-sm-3 col-form-label">Old Level</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="oldLevel" id="oldLevel" class="form-control" value="{{ $emp['job_level'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="newBranch" class="col-sm-3 col-form-label">New Branch</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="newBranch" id="newBranch" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="newPosition" class="col-sm-3 col-form-label">New Position</label>
                                        <div class="col-sm-9">
                                            <select name="newPosition" class="form-control" id="newPosition">
                                                <option value="Staff">Staff</option>
                                                <option value="Officer">Officer</option>
                                                <option value="Managar">Manager</option>
                                                <option value="Supervisor">Supervisor</option>
                                            </select>
                                            <!-- <input type="text" name="newPosition" id="newPosition" class="form-control"> -->
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="newLevel" class="col-sm-3 col-form-label">New Level</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="newLevel" id="newLevel" class="form-control">
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary">Transfer</button>
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

<div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="addEmployee" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/admins/employee/addemployee')}}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" id="username" class="form-control focus-ring" value="{{ old('username') }}" autofocus>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="passwordInput">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="branch" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="branch" id="branch" class="form-control" value="{{ old('branch') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="organization" class="col-sm-2 col-form-label">Organization</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jobposition" class="col-sm-2 col-form-label">Job Position</label>
                        <div class="col-sm-10">
                            <select name="jobposition" class="form-control" id="jobposition" value="{{ old('jobposition') }}">
                                <option value="Staff">Staff</option>
                                <option value="Officer">Officer</option>
                                <option value="Managar">Manager</option>
                                <option value="Supervisor">Supervisor</option>
                            </select>
                            <!-- <div class="input-group">
                                <input type="text" name="jobposition" id="jobposition" class="form-control" value="{{ old('jobposition') }}">
                            </div> -->
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="joblevel" class="col-sm-2 col-form-label">Job Level</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="joblevel" id="joblevel" class="form-control" value="{{ old('joblevel') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="joindate" class="col-sm-2 col-form-label">Join Date</label>
                        <div class="col-sm-10">
                            <input type="date" name="joindate" id="joindate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('joindate') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birthdate" class="col-sm-2 col-form-label">Birth Date</label>
                        <div class="col-sm-10">
                            <input type="date" name="birthdate" id="birthdate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('birthdate') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birthplace" class="col-sm-2 col-form-label">Birth Place</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="birthplace" id="birthplace" class="form-control" value="{{ old('birthplace') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control" value="{{ old('address') }}"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mobilephone" class="col-sm-2 col-form-label">Mobile Phone</label>
                        <div class="col-sm-10">
                            <input type="text" name="mobilephone" id="mobilephone" class="form-control" value="{{ old('mobilephone') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="religion" class="col-sm-2 col-form-label">Religion</label>
                        <div class="col-sm-10">
                            <input type="text" name="religion" id="religion" class="form-control" value="{{ old('religion') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                            <select name="gender" class="form-control" id="gender" value="{{ old('gender') }}">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="maritalstatus" class="col-sm-2 col-form-label">Marital Status</label>
                        <div class="col-sm-10">
                            <select name="maritalstatus" class="form-control" id="maritalstatus" value="{{ old('maritalstatus') }}">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="salary" class="col-sm-2 col-form-label">Salary (IDR)</label>
                        <div class="col-sm-10">
                            <input type="text" name="salary" id="salary" class="form-control" value="{{ old('salary') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tunjangan" class="col-sm-2 col-form-label">Tunjangan (IDR)</label>
                        <div class="col-sm-10">
                            <input type="text" name="tunjangan" id="tunjangan" class="form-control" value="{{ old('tunjangan') }}">
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