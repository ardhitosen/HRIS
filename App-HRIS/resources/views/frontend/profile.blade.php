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
            <div class="card-header">
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>
@stop