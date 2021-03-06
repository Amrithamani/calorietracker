@extends('master')

@section('title')
	List all the foods
@stop

@section('content')
	<h1>List all foods</h1>
	
	<div>
	
	View as:
	<a href='/list/json' target='_blank'>JSON</a> 
	<a href='/list/pdf' target='_blank'>PDF</a><br>
	
	</div>
	
	<h2>You searched for {{{ $query }}}</h2>
	
	@foreach($foods as $title => $food)
		<section class='food'>
			<h2>{{ $title }}</h2>
			{{ $food['calories'] }} ({{$food['protein']}})
			
			{{ $food['potassium'] }} ({{$food['calcium']}})
			
			
		</section>
	@endforeach
	
@stop