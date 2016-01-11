<?php
namespace Admin;
use View,Role,Bill, Input,DB,Redirect,PlanCostDetail,CustDet,Response,Plan,Adjustment,PaymentTransaction,CardTransaction;
use NewCustomer,Api,CusDet,Validator,SiteLoginPassword,InternetPassword,JAccountDetail,TempAccountDetail,ChequeTransaction;

class JactivationController extends \BaseController {

	public function Activation(){
		$customer_id=Input::get('customer_id');
		$plan_start_date=Input::get('plan_start_date');
		$customer = NewCustomer::find(Input::get('customer_id'));
		$plan_code=PlanCostDetail::where('plan_code','=',$customer->plan_code)->get()->first();

		$months=$plan_code->number_of_months;

		$start_day =date("d",strtotime($plan_start_date));
		if($start_day < 25 && $months==1)
		{
			$plan_end_date = date("Y-m-05", strtotime("+".$months." month") );
		} else if($start_day >= 25 && $months==1) {
			if($start_day == 31){
				$plan_cycle=date("Y-m-d", strtotime("+1 day") );
				$plan_end_date = date("Y-m-05", strtotime("+1 month",strtotime($plan_cycle) ));
			}else{
				$plan_end_date = date("Y-m-05", strtotime("+2 month") );
			}
		}else{
			$plan_end_date = date("Y-m-d", strtotime("+".$months." month") );
		}

		if(!is_null($customer)){
		
		$account_details=CusDet::where('crf_no','=',$customer->application_no)->get()->first();
				if($account_details)
				{
					$account_exist=CusDet::where('account_id','=',$account_details->account_id)->get()->first();
							if(substr($account_exist->account_id,0,5)== "OFCHN"){
								if($account_exist->account_id){
										$Jaccount=JAccountDetail::where('account_id','=',$account_exist->account_id)->get()->first();
										if($Jaccount){
											return Redirect::back()->with('failure','Account Already Activated');
										}else{
											return Redirect::back()->with('failure','Jaccount No Null');
										}
								}else{
									$account=$this->UpdateCustomer($customer);
								}
						}else{
							$account=$this->UpdateCustomer($customer);
						}
				}else{
					$account = $this->copyCustomerToAccount($customer);
				}

				if($account !== false ){

				$password = $this->createPasswords($account->account_no);

				$account_id = "OFCHN".$account->account_no;
				$this->updateTempAccDet($account_id,$password);

				$plan_end_date_j=$plan_end_date." 23:59:59";
				//var_dump($plan_code->jplan_code,$account_id,$password,'active',$plan_start_date,$plan_end_date_j);die;
				$add_user=Api::japi_add_users($plan_code->jplan_code,$account_id,$password,'active',$plan_start_date,$plan_end_date_j);
				$add_user_status=json_decode($add_user);
							
							if($add_user_status->status=='success'){

								$this->updateJaccoutDet($account_id,$add_user_status->message->userId);
								
								$jaccount_activation=Api::japi_account_activation($add_user_status->message->userId,'active',$plan_start_date,$plan_end_date_j);


								$jacc_active_status=json_decode($jaccount_activation);


								if($jacc_active_status->status=='success'){

									$this->updateAccountID($account->account_no,$account_id);
									$this->updatePlanDet($account_id,$plan_start_date,$plan_end_date,$customer->plan_code,$plan_code->plan);
									$this->updatePaymentTransaction($account->crf_no,$account_id);
									$data['account_id']=$account_id;
									$data['plan_details']=Plan::where('account_id','=',$account_id)->get()->first();
									$data['cust_details']=CusDet::where('account_id','=',$account_id)->get()->first();
									//send sms...	
									$senderId = "OODOOP";
									$mobileNumber =$data['cust_details']->phone;
									$message="Your OODOO Fiber account details \nUserName : $account_id\nPassword : $password";
									
									$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message);
									
									return View::make('admin.new_customers.activation',$data);
								}
								return Redirect::back()->with('failure','JSON '.$jacc_active_status->message);
							}

							return Redirect::back()->with('failure','JSON '.$add_user_status->message);
				}

				return Redirect::back()->with('failure','Account not created');
		}
		return Redirect::back()->with('failure','customer not created');
	}

	public function UpdateCustomer($customer){
	    DB::table('cust_det')->where('crf_no',$customer->application_no)
	            		->update(array(
	            				'title' => $customer->title,
								'first_name' => $customer->first_name,
								'last_name' => $customer->last_name,
								'email' => $customer->email,
								'address1' => $customer->address1,
								'address2' => $customer->address2,
								'address3' => $customer->address3,
								'city' => $customer->city,
								'state' => $customer->state,
								'pincode' => $customer->pincode,
								'phone' => $customer->phone,
								'dob' => $customer->dob,
								'gender' => $customer->gender,
								'active' => 1,
								'crf_no' => $customer->application_no
	            			));

	    $account_det=CusDet::where('crf_no','=',$customer->application_no)->get()->first();

		if($account_det) {
				return $account_det;
		}
		return false;

	}


	public function copyCustomerToAccount($customer){
		$account = new CusDet();
		$account->title = $customer->title;
		$account->first_name = $customer->first_name;
		$account->last_name = $customer->last_name;
		$account->email = $customer->email;
		$account->address1 = $customer->address1;
		$account->address2 = $customer->address2;
		$account->address3 = $customer->address3;
		$account->city = $customer->city;
		$account->state = $customer->state;
		$account->pincode = $customer->pincode;
		$account->phone = $customer->phone;
		$account->dob = $customer->dob;
		$account->gender = $customer->gender;
		$account->active = 1;
		$account->crf_no = $customer->application_no;
		$account->save();

		$account_det=CusDet::where('crf_no','=',$customer->application_no)->get()->first();

		if($account_det) {
				return $account_det;
		}
		return false;
	}

	public function updateAccountID($account_no,$account_id){
		//generate Account ID 
		DB::table('cust_det')
            ->where('account_no', $account_no)
            ->update(array('account_id' => $account_id));
	}

	public function createPasswords($account_no){
		$account_id="OFCHN".$account_no;
		$password_exist=TempAccountDetail::where('account_id','=',$account_id)->get()->first();
		if(!$password_exist){
			$account = CusDet::where('account_no','=',$account_no)->get()->first();

			$password =$this->generateStrongPassword(7);
			//Insert the Password to site_login_passwords and internet_passwords table

		return $password;
		}
		return $password_exist->password;

	}

	public function getAccountId($account_no){
		return CusDet::where('account_no','=',$account_no)->get()->first()->account_id;
	}

	public function updatePlanDet($account_id,$start_date,$end_date,$plan_code,$plan_name){
		$plan_det=new Plan();
		$plan_det->account_id=$account_id;
		$plan_det->plan_start_date=$start_date;
		$plan_det->plan_end_date=$end_date;
		$plan_det->plan_code=$plan_code;
		$plan_det->plan=$plan_name;
		$plan_det->save();
	}

	public function updateJaccoutDet($account_id,$jaccount_no){
		$Jaccount_det=new JAccountDetail();
		$Jaccount_det->account_id=$account_id;
		$Jaccount_det->jaccount_no=$jaccount_no;
		$Jaccount_det->save();
	}

	public function updateTempAccDet($account_id,$password){
		$password_exist=TempAccountDetail::where('account_id','=',$account_id)->get()->first();
		if($password_exist){
			$Temp_Acc_det=TempAccountDetail::where('account_id','=',$account_id)->get()->first();
		}else{
			$Temp_Acc_det=new TempAccountDetail();
		}
		$Temp_Acc_det->account_id=$account_id;
		$Temp_Acc_det->password=$password;
		$Temp_Acc_det->save();
	}

	function generateStrongPassword($length)
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

	public function	updatePaymentTransaction($crf_no,$account_id){
	$payments_details=PaymentTransaction::where('account_id','=',$crf_no)->get()->first();
		if($payments_details){

			if($payments_details->transaction_type=="cash"){
				DB::table('payment_transactions')
			            ->where('account_id', $crf_no)
			            ->update(array('account_id' => $account_id));
			}

			if($payments_details->transaction_type=="cheque"){
						$payments=PaymentTransaction::where('account_id','=',$crf_no)->get();
							foreach ($payments as $key => $value) {
							$payment_id[]=$value->id;
						}

				$transaction=DB::table('cheque_transactions')->whereIn('transaction_id',$payment_id)->get();

				DB::table('payment_transactions')
						->where('account_id', $crf_no)
						->update(array('account_id' => $account_id));

				$cheque_transaction=DB::table('cheque_transactions')->whereIn('transaction_details',array($transaction[0]->transaction_details))->get();
					foreach ($cheque_transaction as $key => $value) {
					$id[]=$value->transaction_id;
					}

				$payment_transaction=DB::table('payment_transactions')->whereIn('id',$id)->get();
					foreach ($payment_transaction as $key => $value) {
						$account_ids[]=$value->account_id;
						$bill_nos[]=$value->bill_no;
						$amounts[]=$value->amount;
					}

				$transaction_details = array($account_ids,$bill_nos,$amounts);

				foreach ($payment_transaction as $key => $value) {
					DB::table('cheque_transactions')
					->where('transaction_id',$value->id)
					->update(array('transaction_details' => json_encode($transaction_details)));
				}
			}

	    	if($payments_details->transaction_type=="card"){

	    		$payments=PaymentTransaction::where('account_id','=',$crf_no)->get();
					foreach ($payments as $key => $value) {
					$payment_id[]=$value->id;
				}

				$transaction=DB::table('card_transactions')->whereIn('transaction_id',$payment_id)->get();

				DB::table('payment_transactions')
			            ->where('account_id', $crf_no)
			            ->update(array('account_id' => $account_id));

			    $card_transaction=DB::table('card_transactions')->whereIn('transaction_details',array($transaction[0]->transaction_details))->get();
			    
			    foreach ($card_transaction as $key => $value) {
						$id[]=$value->transaction_id;
				}

				$payment_transaction=DB::table('payment_transactions')->whereIn('id',$id)->get();
		            foreach ($payment_transaction as $key => $value) {
		    			$account_ids[]=$value->account_id;
		    			$bill_nos[]=$value->bill_no;
		    			$amounts[]=$value->amount;
		            }

				    $transaction_details = array($account_ids,$bill_nos,$amounts);

		            foreach ($payment_transaction as $key => $value) {
		            	DB::table('card_transactions')
			            		->where('transaction_id',$value->id)
			            		->update(array('transaction_details' => json_encode($transaction_details)));
		            }
			}
		}		
     
    }

}