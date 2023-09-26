<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>HRIS UMN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" id="navbar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="{{url('/employee/dashboard')}}" class="pb-3 mb-md-0 me-md-auto my-4">
                        <span class="fs-5 d-none d-sm-inline"><img src="{{ asset('images/BUMN-Untuk-Indonesia.png') }}" alt="Image" style="width: 100%;"></span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start">
                        <li class="nav-item px-0">
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0">Management</a>
                            <ul class="collapse nav ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="{{url('/employee/attendance')}}" class="nav-link">Attendance</a>
                                </li>
                                <li class="w-100">
                                    <a href="{{url('/employee/timeoff')}}" class="nav-link">Take a Paid Leave</a>
                                </li>
                                <li class="w-100">
                                    <a href="{{url('/employee/overtime')}}" class="nav-link">Request Overtime</a>
                                </li>
                                <li class="w-100">
                                    <a href="{{url('/employee/reimbursement')}}" class="nav-link">Request Reimbursement</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/employee/announcement')}}" class="nav-link px-0">Annoucement</a>
                        </li>
                    </ul>
                    <div class="pb-4" style="width: 100%;">
                        <hr class="border-2">
                        <a href="#" class="d-flex justify-content-between align-items-center text-white text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <div style="border-radius: 100px; overflow: hidden;">
                                    @if(session()->get('employee')->username == NULL)
                                    <img src="{{ session()->get('employee')->photo}}" width="30" height="30" class="rounded-circle" style="object-fit: cover;">
                                    @else
                                    <img src="data:image/jpeg;base64,{{ base64_encode(session()->get('employee')->photo) }}" width="30" height="30" class="rounded-circle" style="object-fit: cover;">
                                    @endif
                                </div>
                                <span class="d-none d-sm-inline mx-1">{{ session()->get('employee') ->username}} </span>
                            </span>
                            <img src="{{ asset('images/menu-burger.png') }}" alt="" height="20px">
                        </a>
                        <ul id="profile_dropdown" class="dropdown-menu text-small shadow-sm slides">
                            <li><a class="dropdown-item" href="{{url('/employee/profile')}}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{url('/employee/logout')}}">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col px-4" id="main_page" style="background-image:url({{ asset('images/background.jpg') }}); background-size: cover;">
                @yield('content')
            </div>

        </div>
    </div>
    <!-- <nav class="shadow-sm navbar navbar-expand-lg" id="navbar">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/employee/dashboard')}}"><img src="{{ asset('images/BUMN-Untuk-Indonesia.png') }}" alt="Image" style="height: 25px;"></a>
                    </li>
                    <div class="dropdown">
                        <button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Time Management
                        </button>
                        <ul class="dropdown-menu" id="navbar_dropdown">
                            <li><a class="dropdown-item" href="{{url('/employee/attendance')}}">Attendance</a></li>
                            <li><a class="dropdown-item" href="{{url('/employee/overtime')}}">Overtime</a></li>
                            <li><a class="dropdown-item" href="{{url('/employee/timeoff')}}">Timeoff</a></li>
                        </ul>
                    </div>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/employee/announcement')}}">Announcement</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ session()->get('employee') ->username}} 
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" style="color:black" href="{{url('/employee/logout')}}">Log Out</a></li>
            </ul>
        </div>
    </nav> -->
</body>
<script src="{{ asset('js/app.js') }}"></script>

</html>