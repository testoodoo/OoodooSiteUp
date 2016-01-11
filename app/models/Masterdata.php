<?php

class Masterdata extends Eloquent {

	protected $table ='master_data';

	
	protected $fillable = ["name","type","active"];

	public static function getId($name,$type) {
		$id=Masterdata::where('name','=',$name)
					->where('type','=',$type)->first();
		if(!is_null($id)){
			return $id->id;
		}else{
			return null; 
		}
		
	}

	public static $rules = array(
		'name' => 'required|unique_with:master_data,type',
	);

}