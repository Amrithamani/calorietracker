<?php


# Homepage
Route::get('/', function() {

    return View::make('welcom');
});


// List all foods / search
Route::get('/list/{format?}', function($format = 'html') {

     $library = new Library();

	    $library->setPath(app_path().'/database/foods.json');

	    $foods = $library->getFoods();

	    if($format == 'json') {
	        return 'JSON Version';
	    }
	    elseif($format == 'pdf') {
	        return 'PDF Version;';
	    }
	    else {
	        return View::make('list')
	            ->with('name','Amritha')
	            ->with('foods', $foods);
	    }


});


// Display the form for a new foods
Route::get('/add', function() {
	return View::make('add');
});


// Process form for a new foods
Route::post('/add', function() {
});


// Display the form to edit a foods
Route::get('/edit/{title}', function() {
});


// Process form for a edit foods
Route::post('/edit/', function() {
});


Route::get('/data', function() {

    // Get the file
    $foods = File::get(app_path().'/database/foods.json');

    // Convert to an array
    $foods = json_decode($foods,true);

    // Return the file
    echo Pre::render($foods);
});