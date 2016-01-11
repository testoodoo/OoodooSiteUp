<?php

namespace Admin;

use View,Roles,Bill, Input,DB,Redirect,Ticket,Masterdata,Routedata,Rolepermission,Route,URL;

	
class RolesController extends \BaseController {

	public function index(){
		$data['roles'] = Roles::paginate(10);
		return View::make('admin.roles.index', $data);
	}

	public function edit($id) {
		$role = Roles::find($id);
		if (is_null($role)) 
			return Redirect::route('admin.roles.index')->with('failure','Invalid Role ID');
		$data['role'] = $role;
		$data['levels'] = [1,2,3,4,5];
		return View::make('admin.roles.edit', $data);
	}

	public function update()	{
		$role = Roles::find(Input::get('role_id'));

		if( $role->exists() ) {

    		$data = Input::all();
    		$data['active'] = Input::get('active',0);
    			
    		if(!$role->update($data)) {
				return Redirect::back()
						->withErrors($role->errors())
						->withInput();
			}
			return Redirect::route('admin.roles.index')
					->with('success','Succesfully saved Role')
					->withInput();
		}
		return Redirect::back()
					->with('failure','Unable to find Role.')
					->withInput();
	}

	public function create() {
		$role =  new Roles();
		$data['role'] = $role;
		$data['levels'] = [1,2,3,4,5];
		$data['routevalues'] =  Route::getRoutes();
		return View::make('admin.roles.create', $data);
	}

	public function store() {
		$role = new Roles(Input::all());
		if( $role->save() ) {
			return Redirect::route('admin.roles.index')->with('success','Role Created Succesfully');
		} else {
			return Redirect::back()->withInput()->withErrors($role->errors());
		}
	}

	public function delete($id){
		$role = Roles::find($id);
		if (is_null($role)) 
			return Redirect::route('admin.roles.index')->with('failure','Invalid Role ID');
		$role->delete();
		return Redirect::route('admin.roles.index')->with('success','Role Deleted Succesfully');
	}


	public function changePermission($id) {
		$role = Roles::find($id);
		if(!is_null($role)) {
			$data['role'] = $role;
			$data['routevalues'] =  Route::getRoutes();
			 $routes=Route::getRoutes();
			 global $base_url;

			  foreach ($routes as $key => $value) {
			 	$root[]= $base_url.$value->getPath();
			 }

			  foreach ($root as $key => $value) {
              	if(stristr($value,"admin")){
				 	$roots[]= $value;
			 	}
			 }
			
			 $data['root']= $roots;

			 foreach ($roots as $key => $value) {
			 	$route_url[]= explode('/',$value);
			 }
			 
                for ($i=0; $i < count($route_url)-1; $i++) { 
                		if(!empty($route_url[$i][1])){																																																																																																																													
                			$route[]=$route_url[$i][1];
                		}
                }
              //var_dump($route);die;
            $gate=array_unique($route);
            foreach ($gate as $key) {
            	if($key != "index" && $key != "login" &&  $key != "forgotpass" &&  $key != "request-forget-password" &&  $key != "reset-password-request" && $key != "reset-password"){
	            	$gateway[]=$key;
            	}
            }
            
              $data['gateway']=$gateway;
              $data['roots']=$roots;
            $role_permission = Rolepermission::where('role_id','=',$role->id)->get();

            if( $role_permission){
            	$data['role_permission']=$role_permission;
            }else{
            	$data['role_permission']=NULL;
            }
            $data['routes'] = Routedata::all();
                //echo $route;
			return View::make('admin.roles.change_routes',$data);
		}
	}

	public function updatePermission()	{
		//var_dump(); die;
		$route_id = Input::get('route_ids');
		$role_id = Input::get('role_id');
		 foreach ($route_id as $key => $value) {
			 	$route_ids[]= explode(',',$value);
			 }


		$existing_routes = Rolepermission::where('role_id','=',$role_id)->get();

		foreach ($existing_routes as $key => $ex_route) {
			$ex_route->delete();
		}

		if (!is_null($route_ids)) {
			foreach ($route_ids as $key => $route) {
               for ($i=0; $i < count($route) ; $i++) { 
				$role_route = new Rolepermission();
				$role_route->role_id = $role_id;
				$role_route->name = $route[$i];
				$role_route->save();
               }
			}
		}

		return Redirect::route('admin.roles.index');
	}

}
