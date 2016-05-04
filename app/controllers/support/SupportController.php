<?php
namespace Support;
use View, BaseController, Masterdata, MailSupport, Mail, PaymentTransaction, Auth, Input, Redirect, CusDet, Ticket, TempAccountDetail, DB, Datatables, Bill, SessionDhh, Response, JAccountDetail, Api, Session;
class SupportController extends BaseController {
	public function index($account_id){

		$data['area'] = Masterdata::where('type','=','area')->get();
		$data['user'] = $user = CusDet::where('account_id','=',$account_id)->get()->first();
		$ticket=Ticket::where('account_id',$user->account_id)->orderBy('id','desc')->where('status_id','3')->first();
		if(count($ticket)!=0){
			$date = date('Y-m-d 00:00:00', strtotime($ticket->created_at . ' + 24 hour'));
			$data['tickets']=Ticket::where('account_id',$user->account_id)->where('status_id','3')->whereBetween('created_at',[$ticket->created_at,$date])->get();
		}else{
			$data['tickets']=NULL;
		}		
		return View::make('support.userDetails.account_det',$data);
		//return View::make('support.userDetails.now',$data);
	
	}


	public function query(){
		$data['areas'] =Masterdata::where('type','area')->get();
		$query = Input::get('query');
		if($query){
			$data['cusDet'] = CusDet::where('account_id','like','%'.$query.'%')->orWhere('phone','like','%'.$query.'%')->get();
		}
		return View::make('support.userDetails.query',$data);


	}

	public function userDetails(){
		$query = Input::get('query');
		$cusDet = CusDet::select('first_name','address1','address2', 'account_id')
							->where('account_id','like','%'.$query.'%')
							->orWhere('phone','like','%'.$query.'%');
		$cus_det = Datatables::of($cusDet)->make();
		return $cus_det;
	}

	public function payment_det(){
		$account_id = Input::get('account_id');
		$payment= DB::table('payment_transactions')
						->select('created_at','bill_no',
								'amount','transaction_code','transaction_type',
								'remarks','payment_type',
								'status')->where('account_id','=',$account_id)->orderBy('bill_no','desc');
        if($payment){
        $payment_user = Datatables::of($payment)->make();
        	return $payment_user;
    	}else{
    		return null;
    	}								
	}

	public function bill_det(){
		$account_id=Input::get('account_id');
		$bill= Bill::select('bill_no','for_month','cust_current_plan',
							'bill_date','prev_bal','last_payment','adjustments','current_rental',
							'amount_before_due_date','amount_paid','status')->where('account_id','=',$account_id)->orderBy('bill_no','desc');
		$bill_user = Datatables::of($bill)->make();
		return $bill_user;
	    }

	public function session_det(){
		$account_id=Input::get('account_id');
		$session= SessionDhh::select('session_id','ip_address','mac_address',
							'start_time','stop_time','bytes_down','bytes_up','bytes_total')
							->where('account_id','=',$account_id)->orderBy('start_time','desc');
		 $session_history = Datatables::of($session)->make();
		 
		return $session_history;		
	}	

	public function usage_det(){
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

	public function ticket_det(){
    	$account_id = Input::get('account_id');
    	if($account_id){
    		$ticket= DB::table('tickets')->select('id','requirement','updated_at','created_at','assigned_to')->where('account_id',$account_id)->orderBy('id','desc');
	    	$ticket_det = Datatables::of($ticket)->addColumn('ticket_type','@if($status=DB::table("tickets")->where("id",$id)->first())
	        																@if($type=DB::table("master_data")->where("id",$status->ticket_type_id)->first())
	        																	{{$type->name}}
	        																@else
	        																	Not Found
	        																@endif
        																@endif',false)
        									->addColumn('status','@if($status=DB::table("tickets")->where("id",$id)->first())
        																@if($tic_status=DB::table("master_data")->where("id",$status->status_id)->first())
        																	{{$tic_status->name}}
        																@else
        																	Not Found
        																@endif
        															@endif',false)
        									->addColumn('operation','<button type="button" class="label label-success" onclick="ticketPop({{$id}})" >
                                                                view
                 												</div>',false)->make();

        	return $ticket_det;
	    }

	}  
	 
	 public function log_det(){

    	$account_no = Input::get('account_id');
    	$account=CusDet::where('account_no','=',$account_no)->get()->first();
    	if($account){
	    		$jaccount=JAccountDetail::where('account_id','=',$account->account_id)->get()->first();

	    		$logs=Api::japi_user_logs($jaccount->jaccount_no,0,5);

				if(json_decode($logs)->aaData){		
					return json_decode($logs)->aaData;
				}else{
					return Response::json(array('found' => "false"));
				}
			}
		return Response::json(array('found' => "false"));

	}

	public function active_session_det(){
    	$account_id = Input::get('account_id');
/*    	var_dump($account_id); die;*/
    	if($account_id){
	    		$active_session=DB::table('jactive_session')->select('account_id','mac_address','ip_address','bytes_down','bytes_up',
	    			'download_rate','upload_rate','start_time','duration')
	    					->where('account_id','=',$account_id);
	    	$session_det = Datatables::of($active_session)->make();
	    	return $session_det;
	    }		
	}

	public function bill_waiver_det(){
		$account_id = Input::get('account_id');
		$bill= DB::table('billwaiver')->select('id','account_id','for_month','amount','waiver_data','remarks')
										->where('account_id',$account_id)->orderBy('id','desc');
		$bill_waiver = Datatables::of($bill)->make();
		return $bill_waiver;
	}

	public function notifyPassword($id){
		$user = CusDet::where('account_no','=',$id)->get()->first();
		if (!is_null($user)) {

			$temp_accout = TempAccountDetail::where('account_id','=',$user->account_id)->get()->first();
			//var_dump($temp_accout); die;
				if($temp_accout){
					$password = $temp_accout->password;
				}
			
			$employee_id=Input::get('employee_id');
			$passwordChange=Input::get('password');
	 	    
	 	    if($employee_id){
	 	    	
	 	    	$employee=Employee::where('employee_identity','=',$employee_id)->get()->first();
	 	       	$senderId = "OODOOS";
				$message = "Hi, User $user->first_name $user->last_name \n Account ID \n". $user->account_id ."  \n Password \n".$password;
				$mobileNumber =$employee->mobile;
				
				}else if($passwordChange){
					$new_password=$this->generateStrongPassword(7);
					$jsubs=Jsubs::where('account_id',$user->account_id)->first();
					if($jsubs){
					$new_password_api=Api::japi_password_reset($jsubs->jaccount_no,$new_password);
					$password_set=json_decode($new_password_api);
						if($password_set->status == "success"){
							DB::table('temp_act_det')->where('account_id', $user->account_id)
									            	->update(array('password' => $new_password));
							$password=$new_password;
							$senderId = "OODOOP";
							$message = "Hi, $user->first_name $user->last_name \n Your Account ID \n". $user->account_id ."  \n Your Password \n". $password ."  \n For any assistance please contact our customer care at +91 8940808080";
							$mobileNumber = $user->phone;
						}else{
							Session::flash('message','Successfully Created');
							return Redirect::back();
						}
					}else{
						Session::flash('message','Successfully Created');
						return Redirect::back();	
					}

				}else{
					$email = $user->email;		
					$data = array('password' => $password, 'user' => $user);
					Mail::send('emails.user_password_remainder', $data, function($message) use ($user,$email) {
			 	       $message->to($email, $user->first_name )
			 	       			->subject("Password Reminder");
			 	    });	
			 	    $senderId = "OODOOP";
					$message = "Hi, $user->first_name $user->last_name \n Your Account ID \n". $user->account_id ."  \n Your Password \n". $password ."  \n For any assistance please contact our customer care at +91 8940808080";
					$mobileNumber = $user->phone;
				}


			PaymentTransaction::sendsms($mobileNumber, $senderId, $message);
			Session::flash('message','Sent Successfully!');
			return Redirect::back();
		}
		Session::flash('message','Successfully Created');		
		return Redirect::back()->with('success','Employee Not Found');	
	}		


}


//OFCHN1089464 mejestic residency
//seevaram 
//1088561