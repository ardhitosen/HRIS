@extends('layout.app')

@section('content')
<br>
<div>
    <div class="card border-0 title">
        <div class="card-body">
            <h5 class="card-title">Welcome, Admin!</h5>
        </div>
    </div>
    <br>
    <div class="d-flex justify-content-between" id="dashboardInfo">
        <div class="card">
            <h6>Employment</h6>
            {{ $empCount }}
        </div>
        <div class="card">
            <h6>Length of Service</h6>
            @for($i = 0; $i < sizeof($year); $i++)
            {{ $year[$i] }}
            @endfor
        </div>
        <div class="card">
            <h6>Active Staff</h6>
            {{ $activeStaff}}
        </div>
        <div class="card">
            <h6>Gender Diversity</h6>
            {{ $male }}
            {{ $female }}
        </div>
    </div>
</div>


@stop