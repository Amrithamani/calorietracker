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
	
}