<?php

namespace User;
use BaseController, Auth, view;
use Illuminate\Config\Repository;

class DashboardController extends BaseController {

	
	protected $layout = 'user._layouts.default';

	public function dashboard(){

		$account_id = Auth::user()->get()->account_id;
		$data['user'] = $user = Auth::user()->get();
		return $this->layout->main = View::make('user.dashboard',$data);

		
	}

}