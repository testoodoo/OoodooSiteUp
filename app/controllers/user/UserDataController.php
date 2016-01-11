<?php
namespace User;
use ActiveSession, View, Request, BaseController;
class UserDataController extends BaseController {
	public function index(){
		$ip = Request::getClientIp();
		$data['usage'] = ActiveSession::where('ip_address','=',$ip)->first();
   		$use = ActiveSession::where('ip_address','=',$ip)->first();
    	if($use != NULL ){
			$usage_bytes_in = $use->avg_bytes_in;
			$usage_bytes_out = $use->avg_bytes_out;
			$usage_total = (float)$usage_bytes_in + (float)$usage_bytes_out;			
			$data['use'] = number_format((float)$usage_total, 2, '.', '');
		}else{
			$data['use'] = NULL;
		}
	return View::make('user.data.data',$data);

	}

}