<?php

class Rolepermission extends Eloquent {

	protected $table = 'role_permission';

	public static function checkRouteExists($role_id,$route_ids){
		$exist_role_permission = Rolepermission::where('role_id','=',$role_id)
						->where('name','=',$route_ids)->get();
		if(count($exist_role_permission) != 0) {
			return true;
		} else {
			return false;
		}
	}

}