@extends('layout')

@section('content')

<h1>List of appointment</h1>

<a href="javascript:void(0);" class="btn btn-success" onclick="showNewAppointments('active');">Show new appointments</a>
<a href="javascript:void(0);" class="btn btn-success" onclick="showNewAppointments('confirm');">Show confirm appointments</a>
<a href="javascript:void(0);" class="btn btn-success" onclick="showNewAppointments('cancel');">Show cancel appointments</a>
<hr>
<div class="appointments">
</div>
<a href="javascript:void(0);" class="more btn btn-success" onclick="showAppointments();">More</a>

@stop