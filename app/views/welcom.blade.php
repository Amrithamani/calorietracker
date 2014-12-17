@extends('master')

@section('title')
	Welcome to Calorietracker
@stop

@section('head')
	<link rel="stylesheet" href="welcome.css" type="text/css">
@stop

@section('content')
	
	{{ Form::open(array('url' => '/list', 'method' => 'GET')) }}

		{{ Form::label('query','Search') }}
	
		{{ Form::text('query'); }}

		{{ Form::submit('Search'); }}

	{{ Form::close() }}
	
@stop