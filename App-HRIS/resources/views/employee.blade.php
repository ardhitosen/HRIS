@extends('layout.app')

@section('content')


<br>
<div class="card">
    <div class="card-body d-flex justify-content-between">
        Ini Employee List
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#addEmployee">
        Add Employee
        </button>
    </div>
</div>
<div class="d-flex row">
    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>ID</th>
                    <th>Branch</th>
                    <th>Organization</th>
                    <th>Job Position</th>
                    <th>Job Level</th>
                    <th>Join Date</th>
                    <th>End Date</th>
                    <th>Sign Date</th>
                    <th>Resign Date</th>
                    <th>Barcode</th>
                    <th>Email</th>
                    <th>Birth Date</th>
                    <th>Birth Place</th>
                    <th>Address</th>
                    <th>Mobile Phone</th>
                    <th>Religion</th>
                    <th>Gender</th>
                    <th>Martial Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee as $emp)
                <tr>
                    <td>{{ $emp['name'] ?? '-' }}</td>
                    <td>{{ $emp['id'] ?? '-' }}</td>
                    <td>{{ $emp['branch'] ?? '-' }}</td>
                    <td>{{ $emp['organization'] ?? '-' }}</td>
                    <td>{{ $emp['job_position'] ?? '-' }}</td>
                    <td>{{ $emp['job_level'] ?? '-' }}</td>
                    <td>{{ $emp['join_date'] ?? '-' }}</td>
                    <td>{{ $emp['end_date'] ?? '-' }}</td>
                    <td>{{ $emp['sign_date'] ?? '-' }}</td>
                    <td>{{ $emp['resign_date'] ?? '-' }}</td>
                    <td>{{ $emp['barcode'] ?? '-' }}</td>
                    <td>{{ $emp['email'] ?? '-' }}</td>
                    <td>{{ $emp['birth_date'] ?? '-' }}</td>
                    <td>{{ $emp['birth_place'] ?? '-' }}</td>
                    <td>{{ $emp['address'] ?? '-' }}</td>
                    <td>{{ $emp['mobile_phone'] ?? '-' }}</td>
                    <td>{{ $emp['religion'] ?? '-' }}</td>
                    <td>{{ $emp['gender'] ?? '-' }}</td>
                    <td>{{ $emp['marital_status'] ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a type="button" id="actionButton" class="btn" href="#">Detail</a></li>
                                <li><a type="button" id="actionButton" class="btn" href="#">Transfer</a></li>
                                <li><a type="button" id="actionButton" class="btn" href="#">Resign</a></li>
                                <li><a type="button" id="actionButton" class="btn" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>       
</div>

<div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="addEmployee" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Add Employee</h5>
                </div>
                <br>
                @if ($errors->any())
                <div class="mb-4 bg-red-100 p-4 rounded text-red-600">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{url('/admins/addemployee')}}" method="post">
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
                        <label for="branch" class="col-sm-2 col-form-label">Branch</label>
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
                            <div class="input-group">
                                <input type="text" name="jobposition" id="jobposition" class="form-control" value="{{ old('jobposition') }}">
                            </div>
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
                        <label for="barcode" class="col-sm-2 col-form-label">Barcode</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="barcode"id="barcode" class="form-control" value="{{ old('barcode') }}">
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
                            <input type="text" name="joindate" id="joindate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('joindate') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="signdate" class="col-sm-2 col-form-label">Sign Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="signdate" id="signdate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('signdate') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="joindate" class="col-sm-2 col-form-label">Birth Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="birthdate" id="birthdate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('joindate') }}">
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
                            <select name="maritalstatus" class="form-control" id="martialstatus" value="{{ old('martialstatus') }}">
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
                    <div class="d-grid">
                        <button class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop