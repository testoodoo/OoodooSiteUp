<?php

namespace Support;
use DB, Response, BaseController, MailSupport, JactiveSession, Input, CusDet, Bill, PaymentTransaction, Redirect ;

Class DashboardController extends BaseController{
	public function navbar() {
			$total_ticket = MailSupport::where('label','INBOX')->orWhere('label','SENT')->groupBy('thread_id')->get();
			$new_ticket = MailSupport::where('label','INBOX')->whereNotIn('thread_id', function($qu){ $qu->selectRaw('thread_id')->from('create_ticket_status_table'); })->groupBy('thread_id')->get();
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
						'exo_call' => count($exo_call_status),
						'total_ticket' => count($total_ticket),
						'new_ticket' => count($new_ticket)
					);
			return Response::json($response);
	}

    public function sendNotify(){
    	$account_no = Input::get('account_no');
		$customer = CusDet::where('account_no','=',$account_no)->get()->first();
		$account_id = $customer->account_id;
		$bill = Bill::where('account_id',$account_id)->orderBy('bill_no','DESC')->get()->first();

		if(is_null($bill)) {
		$data['message'] = "Bill No Not Found.";
		}else if($bill->status == 'paid'){
			$data['message'] = "No dues are up to date.";
		}else{	
			$senderId = "OODOOP";
			$message = "Hi, $customer->first_name $customer->last_name \n Your Data Usage Bill amount is $bill->amount_before_due_date is pending! \n if u already paid please ignore!! \n For any assistance please contact our customer care at +91 8940808080";
			$mobileNumber = $customer->phone;		
			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message);
			if ($return) {
				$data['message'] = "Message Send Successfully!";
			} else {
				$data['message'] = "Message Send Failure.";
			}
		}
		return $data;
	}	

}	