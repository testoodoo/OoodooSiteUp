<?php

namespace Admin;

use View,Role,Bill, Input,DB,Redirect,PlanCostDetail,CusDet,Response,Plan,User,TempAccountDetail,Jsubs,Employee,ActivationDetails,Auth,PlanChangeDet;
use Config,Mail,PaymentTransaction,DataUsageMh,Datatables,Masterdata,Ticket,JAccountDetail,Api,JactiveSession,SoapBox\Formatter\Formatter,DateTime;

class UserOldController extends \BaseController {

	protected $config;

	public function index(){
		return View::make('admin.users_old.index');
	}

	public function custAjax(){

		$customer= DB::table('cust_det')->select('cust_det.crf_no','cust_det.account_id','cust_det.first_name',
			'cust_det.email','cust_det.phone','address1','address2','address3','plan_det.plan')
			->leftJoin('plan_det','plan_det.account_id','=','cust_det.account_id')
			->orderBy('cust_det.account_id','desc');
		
	        $cust_det = Datatables::of($customer)->addColumn('opreations','<span class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
										        													<a href="/admin/users-old/show/{{$account_id}}">
										        													<i class="ace-icon fa fa-search-plus bigger-130"></i></span>
																									</a>',false)
	    										->addColumn('jsubs','@if($status=DB::table("jsubs_det")->where("account_id","$account_id")->first())
	    																@if($status->status == "active")
	    																		1
																		@else
																				0
																		@endif
																	@else 
																			0
																	@endif',false)
	        									->addColumn('jactive_session','@if($data=DB::table("jactive_session")->where("account_id","$account_id")->first())
	        																		1
																			@else 
																					0
	        															@endif',false)
										        
										        ->make();
       
        return $cust_det;
    }

	public function show($id){
		$user= CusDet::where('account_id','=',$id)->get()->first();
		if(!is_null($user)) {
			$data['area'] = Masterdata::where('type','=','area')->get();
			$ticket=Ticket::where('account_id',$user->account_id)->orderBy('id','desc')->where('status_id','3')->first();
			if(count($ticket)!=0){
				$date = date('Y-m-d 00:00:00', strtotime($ticket->created_at . ' + 24 hour'));
				$data['tickets']=Ticket::where('account_id',$user->account_id)->where('status_id','3')->whereBetween('created_at',[$ticket->created_at,$date])->get();
			}else{
				$data['tickets']=NULL;
			}
			$data['user'] = $user;
			return View::make('admin.users_old.show',$data);
		}
		return Redirect::to('/admin/users-old')
				->with('failure','User not found');
		
	}

	public function showpassword($id){
		$user= TempAccountDetail::where('account_id','=',$id)->get()->first();
		if(!is_null($user)) {
			$data['user'] = $user;
			return View::make('admin.users_old.showpassword',$data);
		}else{
			$data['user'] = NULL;
		return View::make('admin.users_old.showpassword',$data)
				->with('failure','User not found');
			}
		
	}

	public function edit($id) {
		$user = CusDet::where('account_id','=',$id)->get()->first();
		if(!is_null($user)) {
			$data['user'] = $user;
			return View::make('admin.users_old.edit',$data);
		}
		return Redirect::to('users-old')
				->with('failure','User not found');
	}
	public function update() {
		$account_id=Input::get('account_id');
		$user = CusDet::where('account_id','=',$account_id)->get()->first();
		if(!is_null($user)) {
		DB::table('cust_det')->where('account_id',$account_id)->update(array(
								'first_name'   => Input::get('first_name'),
								'last_name'    => Input::get('last_name'),
								'email'        => Input::get('email'),
								'address1'     => Input::get('address1'),
								'address2'     => Input::get('address2'),
								'address3'     => Input::get('address3'),
								'city'         => Input::get('city'),
								'phone'        => Input::get('phone'),
								'pincode'      => Input::get('pincode'),
								'state'        => Input::get('state'),
								'dob'          => Input::get('dob'),
								'gender'       => Input::get('gender')));

		return Redirect::to('/admin/users-old')
				->with('success','User updated Succesfully');
		
		}
		return Redirect::to('/admin/users-old')
				->with('failure','User not found');
	}


	public function notifyPassword($id){
		$user = CusDet::where('account_no','=',$id)->get()->first();
		if (!is_null($user)) {

			$temp_accout = TempAccountDetail::where('account_id','=',$user->account_id)->get()->first();
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
							return Redirect::back()->with('success','Password Error in Api');
						}
					}else{
						return Redirect::back()->with('success','Jaccount No Not Found');	
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

			return Redirect::back()->with('success','Sent Succesfully');
		}
		return Redirect::back()->with('success','Employee Not Found');	
	}

	public function generateStrongPassword($length)
		{
			$sets = array();
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
			$sets[] = '23456789';
			$sets[] = '@';

			$all = '';
			$password = '';
			foreach($sets as $set)
			{
				$password .= $set[array_rand(str_split($set))];
				$all .= $set;
			}

			$all = str_split($all);
			for($i = 0; $i < $length - count($sets); $i++){
				$password .= $all[array_rand($all)];
			}

			$password = substr("ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz" ,mt_rand(0 ,46) ,1 ).str_shuffle($password);
			return $password;
	}


	public function ticketPopup($id) {
		$user= Ticket::where('id','=',$id)->get()->first();
		$data['status_list'] = Masterdata::where('type','=','ticket_status')->get();
		$data['employees'] = Employee::all();
			$data['ticket'] = $user;
		
			return View::make('admin.users_old.popups.ticket_popup',$data);
		
	}
	public function datausagePopup($id) {
		$user= Jsubs::where('jaccount_no','=',$id)->get()->first();
			$data['data'] = $user;
		
			return View::make('admin.users_old.popups.datausage_popup',$data);
		
	}
	public function paymentPopup($id) {
		$user= PaymentTransaction::where('bill_no','=',$id)->get()->first();
			$data['user'] = $user;
		
			return View::make('admin.users_old.popups.payment_popup',$data);
		
	}
	public function billPopup($id) {
			$bill=Bill::where('bill_no','=',$id)->get()->first();
			$data['bill']=$bill;
		
			return View::make('admin.users_old.popups.bills_popup',$data);
		
	}
	public function feasiblePopup($id) {
		$feasible=Input::get('feasible');
		$user= CusDet::where('account_id','=',$id)->get()->first();
			$data['user'] = $user;
		    $data['feasible']=$feasible;
			return View::make('admin.users_old.popups.feasible_popup',$data);
		
	}

    public function logAjax(){
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

    public function activeSessionAjax(){
    	$account_id = Input::get('account_id');

    	if($account_id){
	    		$active_session=DB::table('jactive_session')->select('account_id','mac_address','ip_address','bytes_down','bytes_up',
	    			'download_rate','upload_rate','start_time','duration')
	    					->where('account_id','=',$account_id);
	    	$session_det = Datatables::of($active_session)->make();
	    	return $session_det;
	    }
		
    }

    public function TicketAjax(){
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

    public function GetActivationDetails(){
    	return view::make('admin.users_old.activation_details');
    }

    public function ActivationDetails(){
    	return view::make('admin.users_old.show_activation_details');
    }

    public function AjaxActivationDetails(){
    	$activation= DB::table('activation_details')->select('id','account_id','bill_no','expiry_date',
			'request_id','remarks','created_at','status','error')->orderBy('id','desc');
        										
        $active = Datatables::of($activation)->addColumn('activation_count','@if($bills=DB::table("activation_details")->where("bill_no",$bill_no)->first())
        																	{{count(DB::table("activation_details")->where("bill_no",$bills->bill_no)->get())}}
        																	@endif',false)
											->addColumn('Operations','@if($status=="pending")
												<a class="label label-success" href="/admin/users-old/approved/{{$id}}">approved</a> 
												&nbsp;&nbsp;&nbsp;
												<form action="/admin/users-old/approved/{{$id}}">
														<input class="btn btn-minier btn-yellow" type="submit" name="status" value="rejected">
												</form>
												@endif
												',false)
												->make();
       
        return $active;
    }

    public function PostActivationDetails(){
		$account_id=Input::get('account_id');
		$expiry_time=Input::get('expiry_time');
		$remarks=Input::get('remarks');
		$request_id=Input::get('request_id');

		$expiry_date = date("Y-m-d H:i:s", strtotime("+".$expiry_time." hour"));

		$jsubs=Jsubs::where('account_id','=',$account_id)->get()->first();
		if($jsubs){
			$jsubs_status=$jsubs->status;
			$jsubs_expiry_date=$jsubs->expiry_date;
		}else{
			return Redirect::back()
				->with('failure','Account not found Jsubs');
		}

		$today = new DateTime('today');
		$bill=Bill::where('account_id','=',$account_id)->where('bill_start_date','<=',$today->format('Y-m-d'))
													->where('bill_end_date','>=',$today->format('Y-m-d'))->get()->first();
		if($bill){
			$bill_end_date=$bill->bill_end_date;
			$bill_no=$bill->bill_no;
		}else{
			return Redirect::back()
				->with('failure','bill not found for account');
		}

		$active_det=ActivationDetails::where('bill_no','=',$bill_no)->get();
		$activated_count=count($active_det);

		if ($expiry_time == 'month_fully'){
				$expiry_date=$bill_end_date." 23:59:59";
			}
		
		if($expiry_date > $bill_end_date){
			$expiry_date=$bill_end_date." 23:59:59";	
		}
		
			if($expiry_date > $jsubs->expiry_date){
	
				$status="approved";

				if( $activated_count >= 3 ){ 
					 if( $expiry_time < 72 && $expiry_time != 'month_fully'){
							return Redirect::back()
							->with('failure','Account reached maximum activation limit of 3 times');
							}else{
							$status="pending";
						}
				}

				$activation=new ActivationDetails();
				$activation->account_id =$account_id;
				$activation->bill_no    =$bill_no;
				$activation->expiry_date=$expiry_date;
				$activation->request_id =Auth::employee()->get()->employee_identity;
				$activation->remarks ='bill no '.$bill_no.' && amount_paid '.$bill->amount_paid." && Remarks ".$remarks;
				$activation->status=$status;
				$activation->save();
					return Redirect::to('/admin/users-old/activation_details')
											->with('success','Activation request added Succesfully');
			}else{
				return Redirect::back()
				->with('failure','Account is already activated for the requested period');
			}

    }

     public function SetApproved($id){
    	$approved= DB::table('activation_details')->where('id','=',$id)->first();
     	if(Input::get('status')!="rejected"){
    			DB::table('activation_details')->where('id',$approved->id)->update(array(
												'status'   => "approved"));
    	//var_dump(Input::get('status'));die;
    	}else{
    			DB::table('activation_details')->where('id',$approved->id)->update(array(
												'status'   => "rejected"));
  			  }
       
       	return Redirect::to('/admin/users-old/activation_details')
											->with('success','Status Added Activation Details');

    }


    public function GetPlanChangeDetails(){
    	return view::make('admin.users_old.planchange_details');
    }

    public function PlanChangeDetails(){
    	return view::make('admin.users_old.show_planchange_details');
    }

    public function AjaxPlanChangeDetails(){
    	$planchange= DB::table('planchange_details')->select('account_id',
    		'plan_name','plan_change_date',
			'request_id','remarks','status','error')->orderBy('id','desc');
        $active = Datatables::of($planchange)->make();
       
        return $active;
    }

    public function PostPlanChangeDetails(){

    		$plan=PlanCostDetail::where('plan_code','=',Input::get('plan_code'))->get()->first();
    		//var_dump($plan,Input::get('plan_code'));die;

    		if($plan){
				$planchange=new PlanChangeDet();
				$planchange->account_id=Input::get('account_id');
				$planchange->plan_code=Input::get('plan_code');
				$planchange->plan_name=$plan->plan;
				$planchange->plan_change_date=Input::get('plan_change_date');
				$planchange->request_id =Auth::employee()->get()->employee_identity;
				$planchange->remarks =Input::get('remarks');
				$planchange->status="pending";
				$planchange->save();

			 return Redirect::to('/admin/users-old/plan_change_details')
					->with('success','Account PlanChange Details Added Succesfully');
				}else{
					return Redirect::back()
					->with('failure','Account PlanChange Details Not Added');
				}


    }

    public function totalActivationDetails(){

    	$bills=Bill::distinct()->get(array('account_id'));

		foreach ($bills as $key => $value) {
			$active_det=ActivationDetails::where('account_id','=',$value->account_id)->orderBy('expiry_date','desc')->get()->first();
			if($active_det){
				
				$bill=Bill::where('account_id','=',$value->account_id)->orderBy('bill_no','desc')->get()->first();
				if($bill){
					$bill_check=Bill::where('bill_no','=',$bill->bill_no)->where('status','!=','not_paid')->get()->first();
					$paid = $bill->amount_before_due_date - $bill->amount_paid;
					if( $paid <= 100 && $bill_check){
						$jsubs=Jsubs::where('account_id','=',$value->account_id)->where('expiry_date','<',$bill->bill_end_date)->get()->first();
					 	if($jsubs){

								CusDet::CreateActivationDetails($bill->account_id,$bill->bill_end_date,$bill->amount_paid,$bill->bill_no);
						}
					}
				}

				}else{
					$bill=Bill::where('account_id','=',$value->account_id)->orderBy('bill_no','desc')->get()->first();
					if($bill){

						$bill_check=Bill::where('bill_no','=',$bill->bill_no)->where('status','!=','not_paid')->get()->first();
						$paid = $bill->amount_before_due_date - $bill->amount_paid;

						if( $paid <= 100 && $bill_check){
							$jsubs=Jsubs::where('account_id','=',$value->account_id)->where('expiry_date','<',$bill->bill_end_date)->get()->first();
					 		if($jsubs){
							CusDet::CreateActivationDetails($bill->account_id,$bill->bill_end_date,$bill->amount_paid,$bill->bill_no);
							}
						}

					}
				}
		}

    	return Redirect::to('/admin/users-old/activation_details')
						->with('success','Account Activation Details Added Succesfully');
					
    }

    public function SetEmployee(){
    	$ticket_type=Input::get('ticket_type');
		if($ticket_type==28){
			$emp=Employee::where('role_id',6)->get();
		}elseif($ticket_type==29){
			$emp=Employee::whereIn('role_id',array(9,2,1))->get();
		}       
		foreach ($emp as $key) {
			$subs[$key->employee_identity]=$key->name;
		}
        echo json_encode($subs);
    }

  	public function getSendsms(){
    	return view::make('admin.users_old.sendsms');
    }

    public function postSendsms(){
    	$account_no = Input::get('account_id');
    	
    	DB::table('tickets')->where('created_at','<','2015-08-01 00:00:00')->where('ticket_type_id','=','1')->update(array('status_id' =>4));
    	DB::table('tickets')->where('created_at','<','2015-08-18 00:00:00')->where('ticket_type_id','=','29')->update(array('status_id' =>4));
    	DB::table('tickets')->where('created_at','<','2015-08-18 00:00:00')->where('ticket_type_id','=','28')->update(array('status_id' =>4));

    	var_dump("Updated Succesfully");die;

    	$account=CusDet::where('account_no','=',$account_no)->get()->first();
    	$AUTHKEY="AUTHKEY:68252AGguI2SK45395d8f7";
    	$ROUTE="ROUTE:4";
    	$CAMPAIGN="CAMPAIGN:sms";
    	$SENDER="SENDER:OODOOP";
    	$TEXT="HI MANI";
    	$TO=array("-TO"=>"8870300358");
    	$TO=array("-TO"=>"9551904996");
    	
    	$MESSAGE=array("AUTHKEY"=>"68252AGguI2SK45395d8f7","ROUTE"=>"default","CAMPAIGN"=>"TEST",
    		"SENDER"=>"OODOOP");
		$json=array("MESSAGE"=>$MESSAGE);


		$jsn=json_encode($json);

		

		$postData ="<MESSAGE><AUTHKEY>68252AGguI2SK45395d8f7</AUTHKEY><SENDER>SenderID</SENDER><ROUTE>Template</ROUTE><CAMPAIGN>campaign name</CAMPAIGN><COUNTRY>country code</COUNTRY><SMS TEXT='manivannan'>
							<ADDRESS TO='8870300358'></ADDRESS>
						</SMS>
					</MESSAGE>";

		//API URL
		$fields ="data=".urldecode($postData);
		//var_dump($fields);die;
		$url="http://api.msg91.com/api/postsms.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS =>$fields,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		    //CURLOPT_FOLLOWLOCATION => true
		));
		//get response
		$output = curl_exec($ch);

		//Print error if any
		if(curl_errno($ch))
		{
		    echo 'error:' . curl_error($ch);
		}

		curl_close($ch);
		echo $output; die;

		
		return Redirect::to('/admin/users-old/getsendsms')
						->with('success','Sms Sent Succesfully');
		
    }

}