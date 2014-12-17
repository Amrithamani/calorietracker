<?php


# Homepage
Route::get('/', function() {

    return View::make('welcom');
});


// List all foods / search
Route::get('/list/{format?}', function($format = 'html') {

     $query = Input::get('query');

	     $library = new Library();
	     $library->setPath(app_path().'/database/foods.json');

	     $foods = $library->getFoods();

	     if($query) {
	         $foods = $library->search($query);
	     }

	     if($format == 'json') {
	         return 'JSON Version';
	     }
	     elseif($format == 'pdf') {
	         return 'PDF Version;';
	     }
	     else {
	         return View::make('list')
	             ->with('name','Amritha')
	             ->with('foods', $foods)
	             ->with('query', $query);
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


Route::get('/get-environment',function() {

    echo "Environment: ".App::environment();

});

Route::get('/trigger-error',function() {

    # Class Foobar should not exist, so this should create an error
    $foo = new Foobar;

});

