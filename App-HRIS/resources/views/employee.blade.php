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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($employee as $emp)
                    <td>{{$emp['username']}}</td>
                    <td>{{$emp['id']}}</td>
                    <td>-</td>
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
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="addEmployee" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5>Add Employee</h5>
                </div>
                <br>
                <form action="{{url('/admins/addemployee')}}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control focus-ring" autofocus>
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
                    <div class="d-grid">
                        <button class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop