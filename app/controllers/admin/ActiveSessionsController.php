<?php

namespace Admin;

use View,Role,Bill, Input,DB,Redirect,ActiveSession,JactiveSession,Datatables;

class ActiveSessionsController extends \BaseController {

	protected $config;

	public function index(){

		$query = Input::get('query');
		if ( !is_null($query) && !empty($query)){
			$data['active_sessions'] = JactiveSession::orWhere('account_id','like','%'.$query.'%')
								->orWhere('ip_address','like','%'.$query.'%')
								->orWhere('mac_address','like','%'.$query.'%')
								->orWhere('start_time','like','%'.$query.'%')
								->orWhere('duration','like','%'.$query.'%')
								->orWhere('download_rate','like','%'.$query.'%')
								->orWhere('upload_rate','like','%'.$query.'%')
								->orWhere('bytes_down','like','%'.$query.'%')
								->orWhere('bytes_up','like','%'.$query.'%')
								->paginate(15);
			$data['active_session']=NULL;
			$data['query'] = $query;
		} else {
			$data['query'] = "";
			$data['active_session'] = JactiveSession::all();
			$data['active_sessions'] = JactiveSession::paginate(15);
		}
		return View::make('admin.active_sessions.index',$data);
	}

	public function indexAjax(){

		$active= DB::table('jactive_session')->select('account_id','mac_address','ip_address',
							'bytes_down','bytes_up','download_rate','upload_rate','start_time','duration');

        $active_session = Datatables::of($active)->make();

        return $active_session;
	}
}