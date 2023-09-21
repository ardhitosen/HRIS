@extends('frontend.master_layout')

@section('content')
<br>
<div class="card">
    <div class="card-header">
        Welcome, {{ session()->get('employee') ->name}}!
    </div>
    <div class="card-body">
        <h5 class="card-title">Thank you for being part of {{ session()->get('employee') ->organization}}!</h5>
        <p class="card-text">We are excited to have you here!</p>
    </div>
</div>
@stop