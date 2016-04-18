<?php
namespace Support;
use View, BaseController, Masterdata, MailSupport, Auth, Input, Redirect, CusDet, Ticket, DB, Datatables, Bill, SessionDhh, Response, JAccountDetail, Api, Session;
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
		$data['cusDet'] = CusDet::where('account_id','like','%'.$query.'%')
								->orWhere('phone','like','%'.$query.'%')->get();
		echo json_encode($data);
	}

	public function payment_det(){
		$account_id = Input::get('account_id');
		$payment= DB::table('payment_transactions')
						->select('created_at','bill_no',
								'amount','transaction_code','transaction_type',
								'remarks','payment_type',
								'status')->where('account_id','=',$account_id)->orderBy('bill_no','desc');
        if($payment){
        $payment_user = Datatables::of($payment)->addColumn('operations','<button type="button" class="btn btn-minier btn-primary" onclick="payment({{$bill_no}})" >
								                                            view
								                                            </button>'
        																,false)->make();

        return $payment_user;
    	}else{
    		return null;
    	}								
	}

	public function bill_det(){
		$account_id=Input::get('account_id');
		$bill= Bill::select('bill_no','for_month','cust_current_plan',
							'bill_date','prev_bal','last_payment','adjustments','current_rental',
							'amount_before_due_date','amount_after_due_date','amount_paid','status')->where('account_id','=',$account_id)->orderBy('bill_no','desc');

		if(count($bill) != 0){
        $bill_user = Datatables::of($bill)->addColumn('sendsms','@if($status=="not_paid")
        														<a href="bills/notify_user_for_bill/{{$bill_no}}">Send SMS</a>
        														@elseif($status=="partially_paid")
        														<a href="bills/notify_user_for_bill/{{$bill_no}}">Send SMS</a>
        														@else
        														-----
        														@endif',false)->addColumn('operations',
        															'<button type="submit" class="btn btn-minier btn-primary" onclick="bill({{$bill_no}});" >
									                                    view
									                                    </button>'
      																,false)->make();
				return $bill_user;
			}
				return null;
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
        									->addColumn('operation','<button type="button" class="btn btn-minier btn-primary" onclick="ticket({{$id}})" >
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



}


//OFCHN1089464 mejestic residency
//seevaram 
//1088561