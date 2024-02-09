@extends('backend.layout.app')

@section('content')
<br>
<div class="d-flex row">
    <div class="col-2">
        <div class="text-center d-flex row justify-content-center">
            <div class="shadow " style="border-radius: 100px; width: 100px !important; height: 100px !important; overflow: hidden;">
                @if($emp->photo == NULL)
                <img src="{{ asset('images/profile_icon.jpg') }}" alt="Image" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                <img src="data:image/jpeg;base64,{{ base64_encode($emp->photo) }}" alt="Image" class="rounded-circle" style="width: 100%; height: 100%; object-fit: contain;">
                @endif
            </div>
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
            <h3>Employment</h3>
        </div>
        <hr>
        <div class="d-flex">
            <div class="detail">
                <p>ID</p>
                <p>Branch</p>
                <p>Organization</p>
                <p>Job Position</p>
                <p>Job Level</p>
                <p>Join Date</p>
                <p>Resign Date</p>
            </div>
            <div class="detail">
                <p>{{ $emp['id'] ?? '-' }}</p>
                <p>{{ $emp['branch'] ?? '-' }}</p>
                <p>{{ $emp['organization'] ?? '-' }}</p>
                <p>{{ $emp['job_position'] ?? '-' }}</p>
                <p>{{ $emp['job_level'] ?? '-' }}</p>
                <p>{{ $emp['join_date'] ?? '-' }}</p>
                <p>{{ $emp['resign_date'] ?? '-' }}</p>
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

@stop