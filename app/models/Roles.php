<?php

class Roles extends Eloquent {

	protected $table = 'roles';

	protected $fillable = ['name','level','active'];
  	
  	public static $rules = array(
		'name' => 'required|min:2',
		'level' => 'required',
	);

	public function employees(){
		return $this->hasMany('Employee');
	}

}