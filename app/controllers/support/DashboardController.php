<?php

namespace Support;
use DB, Response, BaseController, JactiveSession;

Class DashboardController extends BaseController{
	public function navbar() {
			$activeSession=JactiveSession::all();
			$server_0=DB::table('server_det')->whereIn('status',array(0))->get();
			$server_1=DB::table('server_det')->whereIn('status',array(1))->get();

			$newTime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -15 minutes"));

			$exo_call_status=DB::table('exo_call_log')->where('start_time','>',$newTime)->where('call_status','=','answered')->first();

			$response = array(
						'found' => "true",
						'active_session' => count($activeSession),
						'server_0' => count($server_0),
						'server_1' => count($server_1),
						'network'  => $server_0,
						'exo_call' => count($exo_call_status)
					);
			return Response::json($response);
	}

}	