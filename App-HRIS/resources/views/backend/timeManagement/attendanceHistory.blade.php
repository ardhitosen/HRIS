@extends('backend.layout.app')

@section('content')
<script type='module' src='https://prod-apnortheast-a.online.tableau.com/javascripts/api/tableau.embedding.3.latest.min.js'></script>
<tableau-viz id='tableau-viz' src='https://prod-apnortheast-a.online.tableau.com/t/localhost3000/views/HRISAttendance/Dashboard1' width='1600' height='940' hide-tabs toolbar='bottom' ></tableau-viz>
@stop