<?php
namespace Support;
use View, BaseController, Masterdata;
class SupportController extends BaseController {
	public function index(){
		return View::make('support.mailSupport.mail');
	}

	public function query(){
		$data['areas'] =Masterdata::where('type','area')->get();
		return View::make('support.userDetails.query', $data);
	}

}