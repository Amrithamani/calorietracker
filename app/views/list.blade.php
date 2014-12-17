@extends('master')

@section('title')
	List all the foods
@stop

@section('content')
	<h1>List all foods</h1>
	
	View as:
	<a href='/list/json' target='_blank'>JSON</a> 
	<a href='/list/pdf' target='_blank'>PDF</a><br>
	
	@foreach($foods as $type => $food)
		<section class='food'>
			<h2>{{ $type }}</h2>
			{{ $food['calories'] }} ({{$food['protein']}})
			
			{{ $food['potassium'] }} ({{$food['calcium']}})
			
			
		</section>
	@endforeach
	
@stop