<?php

class Library {
	
	// Properties (Variables)
	private $foods; // Array
	private $path; // String
	
	
	// Methods (Functions)
	public function setPath($path) {
		$this->path = $path;
	}
	
	public function getPath() {
		return $this->path;
	}
	
	public function getFoods() {
		// Get the file
    	$foods = File::get(app_path().'/database/foods.json');
    	
		// Convert to an array
    	$this->foods = json_decode($foods,true);
    	return $this->foods;
	}
	
	public function search($query) {
		
		# If any foods match our query, they'll get stored in this array
		$results = Array();
		
		# Loop through the foods looking for matches
		foreach($this->foods as $type => $food) {
					
			# First compare the query against the type
			if(stristr($type,$query)) {
			
				# There's a match - add this food the the $results array
				$results[$type] = $food;
			}
			# Then compare the query against all the attributes of the food
			else {
						
				if(self::search_food_attributes($food,$query)) {
					# There's a match - add this food the the $results array
					$results[$type] = $food;
				}
			}
		}
		return $results;
	}
	/**
	* Resursively search through a food's attributes looking for a query match
	* @param Array $attributes
	* @param String $query
	* @return Boolean
	*/
	private function search_food_attributes($attributes,$query) { 
	    
		foreach($attributes as $k => $value) { 
		    
		  	# Dig deeper
		    if (is_array($value)) {
		    	return self::search_food_attributes($value,$query);
		    }
				
				if(stristr($value,$query)) {
					return true;
				}             
		} 
		return false;
	}
	
}