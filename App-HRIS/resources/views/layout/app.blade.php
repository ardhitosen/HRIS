<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>HRIS UMN</title>
    <style>
        #actionButton:hover {
            background-color: #eaeaea;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admins/dashboard')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admins/employee')}}">Employees</a>
                    </li>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Time Management
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{url('/admins/timeoff')}}">Time Off</a></li>
                            <li><a class="dropdown-item" href="{{url('/admins/overtime')}}">Overtime</a></li>
                            <li><a class="dropdown-item" href="{{url('/admins/attendance')}}">Attendance</a></li>
                            <li><a class="dropdown-item" href="{{url('/admins/scheduler')}}">Scheduler</a></li>
                            <li><a class="dropdown-item" href="{{url('/admins/calendar')}}">Calendar</a></li>
                        </ul>
                    </div>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admins/reimbursement')}}">Reimbursement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admins/payroll')}}">Payroll</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/admins/announcement')}}">Announcement</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="dropdown">
            <!-- bisa diganti namanya sesuai sama session aja ntar -->
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                admin
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{url('/admins/logoutProcess')}}">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>