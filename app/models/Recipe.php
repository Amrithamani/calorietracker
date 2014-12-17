<?php

class Recipe extends Eloquent {

	public function food() {
       
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('Food');
    }

}