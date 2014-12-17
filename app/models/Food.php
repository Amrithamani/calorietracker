<?php

class Food extends Eloquent {

	public function recipe() {
        
        # Define a one-to-many relationship.
        return $this->hasMany('Recipe');
    }

}