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

Route::get('/practice-creating', function() {

    # Instantiate a new Food model class
    $food = new Food();

    # Set

    $food->type = 'Fruit';
    $food->protein = 0.3;
    $food->calcium = 6.1;
    $food->potassium = 109.1;
    $food->calories = 53;

    # This is where the Eloquent ORM magic happens
    $food->save();

    return 'A new food has been added! Check your database to see...';

});

Route::get('/practice-reading', function() {

    # The all() method will fetch all the rows from a Model/table
    $foods = Food::all();

    # Make sure we have results before trying to print them...
    if($foods->isEmpty() != TRUE) {

        # Typically we'd pass $foods to a View, but for quick and dirty demonstration, let's just output here...
        foreach($foods as $food) {
            echo $food->type.'<br>';
        }
    }
    else {
        return 'No foods found';
    }

});

Route::get('/practice-updating', function() {

    # First get a food to update
    $food = Food::where('type', 'LIKE', '%Fruit%')->first();

    # If we found the food, update it
    if($food) {

        # Give it a different title
        $food->type = 'Apple';

        # Save the changes
        $food->save();

        return "Update complete; check the database to see if your update worked...";
    }
    else {
        return "Food not found, can't update.";
    }

});

Route::get('/practice-deleting', function() {

    # First get a food to delete
    $food = Food::where('type', 'LIKE', '%Fruit%');

    # If we found the food, delete it
    if($food) {

        # Goodbye!
        $food->delete();

        return "Deletion complete; check the database to see if it worked...";

    }
    else {
        return "Can't delete - Food not found.";
    }

});

Route::get('/get-environment',function() {

    echo "Environment: ".App::environment();

});

Route::get('/trigger-error',function() {

    # Class Foobar should not exist, so this should create an error
    $foo = new Foobar;

});

Route::get('mysql-test', function() {

    # Print environment
    echo 'Environment: '.App::environment().'<br>';

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    echo Pre::render($results);

});

Route::get('/test', function() {

	$type = Input::get('type');

	    # Write your own SQL select statement
	    $sql = 'SELECT * FROM foods WHERE type LIKE "%$type%"';

	    # Escape your statement if you have any input coming from users to avoid SQL injection attacks
	    # In this example we don't, but it doesn't hurt to do it anyway
	    $sql = DB::raw($sql);

	    # Run your SQL query
	    $foods = DB::select($sql);

	    # Output the results
	    echo Paste\Pre::render($foods,'');
	});

	
	
/*-------------------------------------------------------------------------------------------------
4. Helpers
-------------------------------------------------------------------------------------------------*/
/* 
The best way to fill your tables with sample/test data is using Laravel's Seeding feature.
Before we get to that, though, here's a quick-and-dirty practice route that will
throw three recipes into the `recipes` table.
*/
Route::get('/seed-recipes', function() {
    return 'This seed will no longer work because the recipes table is no longer embedded with the food.';
    
	# Build the raw SQL query
    $sql = "INSERT INTO recipes (title,image,site_link) VALUES 
            ('Apple popcorn ball','images/applepopcornball.jpeg','http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html'),
            ('Carrot muffins','images/carrotmuffins.jpg','http://allrecipes.com/Recipe/Carrot-Muffins/Detail.aspx?prop24=hn_slide1_Carrot-Muffins&evt19=1'),
            ('Plain pasta','images/plain pasta.jpg','http://allrecipes.com/Recipes/Pasta-and-Noodles/Homemade-Pasta/Main.aspx?evt19=1&src=hr_browsedeeper&soid=hr_coll_3')
			";
            
    # Run the SQL query
    echo DB::statement($sql);
    # Get all the recipes just to test it worked
    $recipes = DB::table('recipes')->get();
    # Print all the recipes
    echo Paste\Pre::render($recipes,'');
});
Route::get('/seed-recipes-and-foods', function() {
    
	$clean = new Clean();
    
	# Foods
    $apple = new Food;
    $apple->name = 'Apple';
    $apple->type = 'Fruit';
    $apple->calories = 53;
    $apple->save();

    $carrot = new Food;
    $carrot->name = 'Carrot';
    $carrot->type = 'Vegetable';
    $carrot->calories = 4;
    $carrot->save();

    $pasta = new Food;
    $pasta->name = 'Pasta';
    $pasta->type = 'Salad';
    $pasta->calories = 197;
    $pasta->save();

    # Recipes
    $popcorn = new Recipe;
    $popcorn->title = 'Apple popcorn ball';
    $popcorn->image = 'images/applepopcornball.jpeg';
    $popcorn->site_link = 'http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html';

    # Associate has to be called *before* the food is created (save())
    $popcorn->food()->associate($apple); # Equivalent of $gatsby->author_id = $fitzgerald->id
    $popcorn->save();

    $muffin = new Recipe;
    $muffin->title = 'Carrot muffins';
    $muffin->image = 'images/carrotmuffins.jpg';
    $muffin->site_link = 'http://allrecipes.com/Recipe/Carrot-Muffins/Detail.aspx?prop24=hn_slide1_Carrot-Muffins&evt19=1';
    $muffin->food()->associate($carrot);
    $muffin->save();

    $plain = new Recipe;
    $plain->title = 'Plain pasta';
    $plain->image = 'images/plain pasta.jpg';
    $plain->site_link = 'http://allrecipes.com/Recipes/Pasta-and-Noodles/Homemade-Pasta/Main.aspx?evt19=1&src=hr_browsedeeper&soid=hr_coll_3';
    $plain->food()->associate($pasta);
    $plain->save();
    return 'Done';
	
  
});

Route::get('/seed-recipes-and-foods-with-tags', function() {
    $clean = new Clean();
    
    # Foods
    $apple = new Food;
    $apple->name = 'Apple';
    $apple->type = 'Fruit';
    $apple->calories = 53;
    $apple->save();

    $carrot = new Food;
    $carrot->name = 'Carrot';
    $carrot->type = 'Vegetable';
    $carrot->calories = 4;
    $carrot->save();

    $pasta = new Food;
    $pasta->name = 'Pasta';
    $pasta->type = 'Salad';
    $pasta->calories = 197;
    $pasta->save();

    
    # Tags (Created using the Model Create shortcut method)
    # Note: Tags model must have `protected $fillable = array('name');` in order for this to work
    $rice         = Tag::create(array('category' => 'rice'));
    $lunch        = Tag::create(array('category' => 'lunch'));
    $breakfast    = Tag::create(array('category' => 'breakfast'));
    $brunch       = Tag::create(array('category' => 'brunch'));
    $bread        = Tag::create(array('category' => 'bread'));
    
    
    # Recipes
    $popcorn = new Recipe;
    $popcorn->title = 'Apple popcorn ball';
    $popcorn->image = 'images/applepopcornball.jpeg';
    $popcorn->site_link = 'http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html';
	# Associate has to be called *before* the food is created (save())
    $popcorn->food()->associate($apple); # Equivalent of $gatsby->author_id = $fitzgerald->id
    $popcorn->save();
    
    # Attach has to be called *after* the recipe is created (save()), 
    # since resulting `recipe_id` is needed in the recipe_tag pivot table
    $popcorn->tags()->attach($breakfast); 
    $popcorn->tags()->attach($brunch); 
    $popcorn->tags()->attach($lunch); 
    
    $muffin = new Recipe;
    $muffin->title = 'Carrot muffins';
    $muffin->image = 'images/carrotmuffins.jpg';
    $muffin->site_link = 'http://allrecipes.com/Recipe/Carrot-Muffins/Detail.aspx?prop24=hn_slide1_Carrot-Muffins&evt19=1';
    $muffin->food()->associate($carrot);
    $muffin->save();
    
    
    $muffin->tags()->attach($breakfast);   
    $muffin->tags()->attach($brunch); 
    $muffin->tags()->attach($lunch); 
    $muffin->tags()->attach($bread); 
    
    $plain = new Recipe;
    $plain->title = 'Plain pasta';
    $plain->image = 'images/plain pasta.jpg';
    $plain->site_link = 'http://allrecipes.com/Recipes/Pasta-and-Noodles/Homemade-Pasta/Main.aspx?evt19=1&src=hr_browsedeeper&soid=hr_coll_3';
    $plain->food()->associate($pasta);
    $plain->save();
	
    $plain->tags()->attach($breakfast); 
    $plain->tags()->attach($lunch); 
    $plain->tags()->attach($brunch); 
    
    
    return 'Done';
});

Route::get('/seed-a', function() {


    # Foods
    $apple = new Food;
    $apple->name = 'Apple';
    $apple->type = 'Fruit';
    $apple->calories = 53;
    $apple->save();

    $carrot = new Food;
    $carrot->name = 'Carrot';
    $carrot->type = 'Vegetable';
    $carrot->calories = 4;
    $carrot->save();

    $pasta = new Food;
    $pasta->name = 'Pasta';
    $pasta->type = 'Salad';
    $pasta->calories = 197;
    $pasta->save();

    # Recipes
    $popcorn = new Recipe;
    $popcorn->title = 'Apple popcorn ball';
    $popcorn->image = 'images/applepopcornball.jpeg';
    $popcorn->site_link = 'http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html';

    # Associate has to be called *before* the food is created (save())
    $popcorn->food()->associate($apple); # Equivalent of $gatsby->author_id = $fitzgerald->id
    $popcorn->save();

    $muffin = new Recipe;
    $muffin->title = 'Carrot muffins';
    $muffin->image = 'images/carrotmuffins.jpg';
    $muffin->site_link = 'http://allrecipes.com/Recipe/Carrot-Muffins/Detail.aspx?prop24=hn_slide1_Carrot-Muffins&evt19=1';
    $muffin->food()->associate($carrot);
    $muffin->save();

    $plain = new Recipe;
    $plain->title = 'Plain pasta';
    $plain->image = 'images/plain pasta.jpg';
    $plain->site_link = 'http://allrecipes.com/Recipes/Pasta-and-Noodles/Homemade-Pasta/Main.aspx?evt19=1&src=hr_browsedeeper&soid=hr_coll_3';
    $plain->food()->associate($pasta);
    $plain->save();
    return 'Done';
});	

/*
Print all available routes
*/
Route::get('/routes', function() {

    $routeCollection = Route::getRoutes();
    foreach($routeCollection as $value) {
        echo "<a href='/".$value->getPath()."' target='_blank'>".$value->getPath()."</a><br>";
    }
});

