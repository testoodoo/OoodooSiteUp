<?php

namespace Admin;

use View,Role,Bill, Input,DB,Redirect,DataUsage,Jsubs,Datatables;

class UsagesController extends \BaseController {

	protected $config;

	public function index(){

		$query = Input::get('query');
		if ( !is_null($query) && !empty($query)){
			$data['usages'] = Jsubs::orWhere('account_id','like','%'.$query.'%')
								->orWhere('plan','like','%'.$query.'%')
								->orWhere('status','like','%'.$query.'%')
								->orWhere('duration','like','%'.$query.'%')
								->orWhere('bytes_down','like','%'.$query.'%')
								->orWhere('bytes_up','like','%'.$query.'%')
								->orWhere('bytes_total','like','%'.$query.'%')
								->orWhere('status','like','%'.$query.'%')
								->paginate(15);
			$data['usag']=NULL;
			$data['query'] = $query;
		} else {
			$data['query'] = "";
			$data['usag'] = Jsubs::all();
			$data['usages'] = Jsubs::paginate(15);
		}
		return View::make('admin.usages.index',$data);
	}

	public function indexAjax(){

		$usages= DB::table('jsubs_det')->select('account_id','plan','status',
							'current_plan','duration','bytes_down','bytes_up','bytes_total');

        $usage= Datatables::of($usages)->addColumn('total_gb','{{$bytes_total}}',false)->make();

        return $usage;
	}

	public function userUsage(){
		$account_id=Input::get('account_id');
		$usages= DB::table('jsubs_det')->select('jaccount_no','plan','status',
							'current_plan','duration','bytes_down','bytes_up','bytes_total')
							->where('account_id','=',$account_id);

       	if($usages){
        $usage_user= Datatables::of($usages)->addColumn('total_gb','{{$bytes_total}}',false)
        									->addColumn('operations','<button type="button" class="btn btn-minier btn-primary" onclick="datausage({{$jaccount_no}});" >
                                                view
                                                </button>'
        										,false)
        									->make();
        	return $usage_user;
    	}else{
    		return null;
    	}
	}

}