@extends('backend.layout.app')

@section('content')
<br>
<div>
    <div class="card border-0 title">
        <!-- <div class="card-body">
            <h5 class="card-title">Welcome, Admin!</h5>
        </div> -->
    </div>
    <script type='module' src='https://prod-apnortheast-a.online.tableau.com/javascripts/api/tableau.embedding.3.latest.min.js'></script>
    <tableau-viz id='tableau-viz' src='https://prod-apnortheast-a.online.tableau.com/t/localhost3000/views/HRISDashboardfinal/Dashboard' width='1600' height='620' hide-tabs toolbar='hidden' ></tableau-viz>
</div>


@stop