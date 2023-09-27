@extends('frontend.master_layout')

@section('content')
<style>
    .card {
        animation: slideIn 0.5s ease-in-out forwards;
        opacity: 0;
        transform: translateY(-20px);
        text-align: center;
        padding: 20px;
    }

    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<div class="card card_container">
    <h3 class=>Profile</h3>
    <div class="card-body">
        <div class="card">
            <div class="card-body" id="profile_template">
                <div id="left_profile" class="d-flex flex-column align-items-center">
                    <img src="data:image/jpeg;base64,{{ base64_encode(session('employee')->photo) }}" alt="">
                    <h4>{{ session('employee')->name}}</h4>
                </div>
                <div>
                    <h2>Employee Information</h2>
                    <hr>
                    <p>Address: {{ session('employee')->address}}</p>
                    <p>Phone Number: {{ session('employee')->mobile_phone}}</p>
                    <h2>Employment Status</h2>
                    <hr>
                    <p>Employement: {{ session('employee')->employment_status }}</p>
                    <p>Join Date: {{ date("d M Y", strtotime(session('employee')->join_date)) }}</p>
                    <p>Organization: {{ session('employee')->organization }}</p>
                    <p>Job Position: {{ session('employee')->job_level }} {{ session('employee')->job_position }}</p>
                    <p>Monthly Salary: Rp. {{ number_format(session('employee')->salary, 2, ",", ".") }}</p>
                    <p>Subsidy: Rp. {{ number_format(session('employee')->tunjangan, 2, ",", ".")  }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop