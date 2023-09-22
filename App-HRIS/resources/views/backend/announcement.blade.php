@extends('backend.layout.app')

@section('content')

<br>
<div class="card border-0 title">
    <div class="card-body d-flex justify-content-between">
        <h5 class="card-title">Announcement!</h5>
        <button class="btn btn-link nav-link float-end" data-bs-toggle="modal" data-bs-target="#addannouncement">
            Create New
        </a>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger mt-4">
    <ul class="pl-4">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="modal fade" id="addannouncement" tabindex="-1" aria-labelledby="addannouncement" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admins/addannouncement') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="announcement" class="form-label">Announcement Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" value="{{old('description')}}"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Announcement</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($announcements as $announcement)
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Announcement: {{ $announcement->announcement }}</h5>
        <p>{{ $announcement->description }}</p>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAnnouncement{{$announcement->id}}">
            Edit
        </button>
        <form action="{{ url('/admins/deleteannouncement/' . $announcement->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <div class="modal fade" id="editAnnouncement{{$announcement->id}}" tabindex="-1" aria-labelledby="editAnnouncement{{$announcement->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/admins/editannouncement/' . $announcement->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Announcement Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $announcement->announcement }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $announcement->description }}</textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@stop