@extends('backend.layout.app')


@section('content')
<br>
<div class="d-flex row">
    <div class="col-2">
        <div class="text-center">
            <!-- <img src="{{ asset('images/profile_icon.jpg') }}" alt="Image" style="border-radius: 100px; width: 100px;"> -->
            <img src="{{ ($url) }}" alt="Image" style="border-radius: 100px; width: 100px;">
            <button class="btn" data-bs-toggle="modal" data-bs-target="#changeImage">Change Image</button>
        </div>
        <hr>
        <div class="d-flex row">
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/personal/' . $emp['id']) }}">Personal</a></span>
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/employment/' . $emp['id']) }}">Employment</a></span>
            <span class="w-100"><a class="btn" href="{{ url('/admins/employee/detail/transferlog/' . $emp['id']) }}">Transfer Log</a></span>
        </div>
    </div>
    <div class="col-10">
        <div class="d-flex ">
            <h3>Personal</h3>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#editEmployee">Edit</button>
        </div>
        <hr>
        <div class="d-flex">
            <div class="detail">
                <p>Name</p>
                <p>Email</p>
                <p>Gender</p>
                <p>Mobile Phone</p>
                <p>Address</p>
                <p>Religion</p>
                <p>Birth Date</p>
                <p>Birth Place</p>
                <p>Marital Status</p>
            </div>
            <div class="detail">
                <p>{{ $emp['name'] ?? '-' }}</p>
                <p>{{ $emp['email'] ?? '-' }}</p>
                <p>{{ $emp['gender'] ?? '-' }}</p>
                <p>{{ $emp['mobile_phone'] ?? '-' }}</p>
                <p>{{ $emp['address'] ?? '-' }}</p>
                <p>{{ $emp['religion'] ?? '-' }}</p>
                <p>{{ $emp['birth_date'] ?? '-' }}</p>
                <p>{{ $emp['birth_place'] ?? '-' }}</p>
                <p>{{ $emp['marital_status'] ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeImage" tabindex="-1" aria-labelledby="changeImage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admins/employee/edit/changepp/' . $emp['id']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="image" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9 my-auto">
                            <input type="file" name="image" id="image" class="form-control-file">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editEmployee" tabindex="-1" aria-labelledby="editEmployee" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admins/employee/edit/' . $emp['id']) }}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $emp['name']) }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $emp['email']) }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="organization" class="col-sm-2 col-form-label">Organization</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization', $emp['organization']) }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="joindate" class="col-sm-2 col-form-label">Join Date</label>
                        <div class="col-sm-10">
                            <input type="date" name="joindate" id="joindate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('joindate', $emp['join_date']) }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birthdate" class="col-sm-2 col-form-label">Birth Date</label>
                        <div class="col-sm-10">
                            <input type="date" name="birthdate" id="birthdate" class="form-control datepicker" placeholder="YYYY-MM-DD" value="{{ old('birthdate',$emp['birth_date']) }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birthplace" class="col-sm-2 col-form-label">Birth Place</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="birthplace" id="birthplace" class="form-control" value="{{ old('birthplace',$emp['birth_place']) }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control">{{ old('address', $emp['address']) }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mobilephone" class="col-sm-2 col-form-label">Mobile Phone</label>
                        <div class="col-sm-10">
                            <input type="text" name="mobilephone" id="mobilephone" class="form-control" value="{{ old('mobilephone',$emp['mobile_phone']) }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="religion" class="col-sm-2 col-form-label">Religion</label>
                        <div class="col-sm-10">
                            <input type="text" name="religion" id="religion" class="form-control" value="{{ old('religion',$emp['religion']) }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                            <select name="gender" class="form-control" id="gender" value="{{ old('gender',$emp['gender']) }}">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="maritalstatus" class="col-sm-2 col-form-label">Marital Status</label>
                        <div class="col-sm-10">
                            <select name="maritalstatus" class="form-control" id="maritalstatus" value="{{ old('maritalstatus',$emp['marital_status']) }}">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop