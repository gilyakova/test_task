@extends('layout')

@section('content')

<h1>{{ isset($item) ? 'Update appointment' : 'New appointment' }}</h1>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{ Form::open(array('url' => 'store'.(isset($item) ? '/'.$item->id : ''))) }}

<div class="row">
    <div class="col-sm-6">
        <div class='form-group'>
        {!! Form::label('datetime', 'Date and time:') !!}
        {!! Form::text('datetime', isset($item) ? $item->datetime : null, ['class' => 'form-control', 'data-datetime' => 'true']) !!}
        </div>

        <div class='form-group'>
        {!! Form::label('place', 'Place:') !!}
        {!! Form::text('place', isset($item) ? $item->place : null, ['class' => 'form-control', 'maxlength' => '255']) !!}
        </div>

        <div class='form-group'>
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::select('company_id', $companies, isset($item) ? $item->company_id : null, ['class' => 'form-control', 'onchange' => 'getPeople($(this));']) !!}
        </div>

        <div class='form-group'>
        {!! Form::label('person_id', 'Person:') !!}

        @if (isset($item) && $person_list)
            {!! Form::select('person_id', $person_list,  isset($item) ? $item->person_id : null, ['class' => 'form-control']) !!}
        @else
            {!! Form::select('person_id', [],  isset($item) ? $item->person_id : null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class='form-group'>
        {!! Form::label('contacts', 'Contact information:') !!}
        {!! Form::textarea('contacts', isset($item) ? $item->contacts : null, ['class' => 'form-control', 'maxlength' => '2000', 'rows' => '5']) !!}
        </div>
        <div class='form-group'>
        {!! Form::label('note', 'Note:') !!}
        {!! Form::textarea('note', isset($item) ? $item->note : null, ['class' => 'form-control', 'maxlength' => '2000', 'rows' => '5']) !!}
        </div>

        <div class='form-group'>
        {!! Form::submit('Сохранить', ['class' => 'btn btn-lg btn-success form-control']) !!}
        </div>
    </div>

</div>

{{ Form::close() }}

@stop