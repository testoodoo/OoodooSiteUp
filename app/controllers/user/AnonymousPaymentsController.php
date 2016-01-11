<?php

namespace User;
use View, BaseController, Input, CusDet, PaymentTransaction, Redirect, Request, Response, Bill, PaymentPayu, DB, ConstantValue,ActivationDetails,Jsubs;
use \Illuminate\Config\Repository;

class AnonymousPaymentsController extends BaseController {

	public function anonymousPay(){
		return View::make('user.payment.anonymous_pay');
	}


	public function confirmPayment(){
		$input_amount = Input::get('amount');
		if ($this->checkemptyParams() && $this->amountCheck() && $this->accountCheck() && Input::get('bill_no') ){
			return $this->payment_process();
		}
		return Redirect::back()->with('failure',"Invalid Inputs");
	}

	

	private function payment_process(){
		$account = CusDet::where('account_id','=',Input::get('account_id'))->get()->first();
		$tran_code = substr( "ABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,26 ) ,1 ). substr($account->account_id, -3) . substr(Input::get('bill_no'), -3) . sprintf("%06s", count(PaymentTransaction::all()));
		$transactions = PaymentTransaction::where('transaction_code','=',$tran_code)->get();
		$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		if (count($transactions) != 0) {
			$transaction = $transactions->first();
		} else {
			$transaction = new PaymentTransaction();
			$transaction->account_id = $account->account_id;
			$transaction->transaction_code = $tran_code;
			$transaction->amount = Input::get('payable_amount');
			$transaction->status = "pending";
			$transaction->bill_no = Input::get('bill_no');
			$transaction->transaction_type = "cash";
			$transaction->merchant_id = $txnid;
			$transaction->payment_type = "online-anpay";
			$transaction->save();
		}

// Remove command during production 
		 /*$key = "JBZaLc";
		 $salt = "GQs7yium";*/

		$key = "D2KszY";
		$salt = "nhQKVA7x";

		$productinfo = "internet";
		$firstname = Input::get('firstname');
		$email = Input::get('email');
		$phone = Input::get('phone');
		$amount = intval(Input::get('amount'));
		$payable_amount = intval(Input::get('payable_amount'));
		$gateway_amount = round($payable_amount * Input::get('gateway_amount'));
		$udf1 = $account->account_id;
	    $udf2 = $payable_amount;
	    $udf3 = Input::get('gateway_amount');
	    $udf4 = $tran_code;
	    $udf5 = $amount;
	    $udf6 = "";
	    $udf7 = "";
	    $udf8 = "";
	    $udf9 = "";
	    $udf10 = "";

	    $data['s_url'] = Request::root() ."/payments/anonymous-payment-success";
	    $data['f_url'] = Request::root() . "/payments/anonymous-payment-failed";

	    $data['udf1'] = $udf1;
	    $data['udf2'] = $udf2;
	    $data['udf3'] = $udf3;
	    $data['udf4'] = $udf4;
	    $data['udf5'] = $udf5;
	    $data['udf6'] = $udf6;
	    $data['udf7'] = $udf7;
	    $data['udf8'] = $udf8;
	    $data['udf9'] = $udf9;
	    $data['udf10'] = $udf10;

	    $data['key'] = $key;

		
		//Remove command during production
		//$data['gateway_url'] = "https://test.payu.in/_payment";
		$data['gateway_url'] = "https://secure.payu.in/_payment";

		$data['txnid'] = $txnid;

		$data['service_provider'] = "payu_paisa";

		$data['amount'] = $amount;
		$data['email'] = $email;
		$data['phone'] = $phone;
		$data['firstname'] = $firstname;
		$data['productinfo'] = $productinfo;

		$hash_string = "$key|$txnid|$amount|$productinfo|$firstname|$email|$udf1|$udf2|$udf3|$udf4|$udf5|$udf6|$udf7|$udf8|$udf9|$udf10|$salt";

		$hash = strtolower(hash('sha512', $hash_string));

		$data['hash_str'] = $hash;
		/*var_dump( $data['s_url'] ,$data['f_url'],$data['amount'],$data['txnid'],$data['productinfo'],$data['firstname'],$data['email'],$data['phone'],
			$data['service_provider'],$data['udf1'],$data['udf2'],$data['udf3'],$data['udf4'],$data['udf5'],$data['hash_str']);die;*/
		return View::make('user.payment.payment_process',$data);

  	}

  	public function payment_success(){

		$salt = "nhQKVA7x";

		$status = Input::get('status');
		$udf5 = Input::get('udf5');
		$udf4 = Input::get('udf4');
		$udf3 = Input::get('udf3');
		$udf2 = Input::get('udf2');
		$udf1 = Input::get('udf1');
		$email = Input::get('email');
		$firstname = Input::get('firstname');
		$productinfo = Input::get('productinfo');
		$amount = Input::get('amount');
		$txnid = Input::get('txnid');
		$key = Input::get('key');

		$hash = Input::get('hash');

		$str = "$salt|$status||||||$udf5|$udf4|$udf3|$udf2|$udf1|$email|$firstname|$productinfo|$amount|$txnid|$key";

		$hash_str = strtolower(hash('sha512', $str));
		$transaction_code = $udf4;
		$transaction = PaymentTransaction::where('transaction_code','=',$transaction_code)->get()->first();

		if ($hash_str != $hash) {
			//check sum mismatch!! somebody might have hacked between redirection
			$this->updateTransaction("failed");
			$this->logToPayments();
			return Redirect::to('/pay')
				->with('failure',"Your txn id ".$transaction->transaction_code." for Payment of Rs.".$udf2." towards bill no ".$transaction->bill_no." of Account ID ".$transaction->account_id." is Failed. For Queries please contact our support");
		} else {
			//success fully paid
			$this->updateTransaction("success");
			$this->updateBill($transaction);
			$this->logToPayments();
			$this->UpdateActivation($transaction->account_id,$transaction->bill_no);
			$this->PlanChangeUpdate($transaction->account_id,$transaction->bill_no);
			$this->notifyUserSuccess($transaction);
			//$this->update_amount_to_customer($amount);	
			return Redirect::to('/pay')
				->with('success',"Your txn id ".$transaction->transaction_code." for Payment of Rs.".$udf2." towards bill no ".$transaction->bill_no." of Account ID ".$transaction->account_id." is successful. For Queries please contact our support");
		}
   	}


  	public function payment_failed(){
  		$this->updateTransaction("cancelled");
  		$this->logToPayments(); 	
		$transaction_code = Input::get('udf4');
		$udf2 = Input::get('udf2');
		$transaction = PaymentTransaction::where('transaction_code','=',$transaction_code)->get()->first();

		$amount = Input::get('amount');

  		return Redirect::to('/pay')
				->with('failure',"Your txn id ".$transaction->transaction_code." for Payment of Rs.".$udf2." towards bill no ".$transaction->bill_no." of Account ID ".$transaction->account_id." is Cancelled. For Queries please contact our support");
	}	


	private function checkemptyParams(){
		if (empty(Input::get('email')) || empty(Input::get('phone')) || empty(Input::get('amount')) || 
			is_null(Input::get('email')) || is_null(Input::get('phone')) || is_null(Input::get('amount')))
		{
			return false;
		} else {
			
			return true;
		}
	}

	private function amountCheck(){
		if (Input::get('amount') < 0) {
			return false;
		} else {
			return true;	
		}
	}

	private function updateTransaction($status){
		$transaction_code = Input::get('udf4');
		$transaction = PaymentTransaction::where('transaction_code','=',$transaction_code)->get()->first();
		$transaction->status = $status;
		$transaction->transaction_type = Input::get('mode');
		$transaction->save();
	}

	private function updateBill($transaction) {
			$total_charges = Bill::where('Bill_No','=',$transaction->bill_no)->get()->first()->amount_before_due_date;
			$bill = Bill::where('Bill_No','=',$transaction->bill_no)->get()->first();
			$payment_amount= PaymentTransaction::where('bill_no','=',$transaction->bill_no)
												->where('status','=','success')->sum('amount');
			$amount_paid = intval($bill->amount_paid+ $payment_amount);
				if ( $payment_amount >= $total_charges ) {
					DB::table('bill_det')
		            ->where('bill_no', $transaction->bill_no)
		            ->update(array('status' => "paid","amount_paid" => $payment_amount));
				} else {
					DB::table('bill_det')
		            ->where('bill_no', $transaction->bill_no)
		            ->update(array('status' => "partially_paid","amount_paid" => $payment_amount));
				}
	}

	public function logToPayments(){

		$payment_payu = new PaymentPayu();

		$payment_payu->udf1 = Input::get('udf1');
		$payment_payu->udf2 = Input::get('udf2');
		$payment_payu->udf3 = Input::get('udf3');
		$payment_payu->udf4 = Input::get('udf4');
		$payment_payu->udf5 = Input::get('udf5');
		$payment_payu->udf6 = Input::get('udf6');
		$payment_payu->udf7 = Input::get('udf7');
		$payment_payu->udf8 = Input::get('udf8');
		$payment_payu->udf9 = Input::get('udf9');
		$payment_payu->udf10 = Input::get('udf10');

		$payment_payu->mode = Input::get('mode');
		$payment_payu->productinfo = Input::get('productinfo');
		$payment_payu->amount = Input::get('amount');
		$payment_payu->email = Input::get('email');
		$payment_payu->phone = Input::get('phone');
		$payment_payu->firstname = Input::get('firstname');
		$payment_payu->lastname = Input::get('lastname');
		$payment_payu->txnid = Input::get('txnid');
		$payment_payu->address1 = Input::get('address1');
		$payment_payu->address2 = Input::get('address2');
		$payment_payu->city = Input::get('city');
		$payment_payu->state = Input::get('state');
		$payment_payu->country = Input::get('country');
		$payment_payu->zipcode = Input::get('zipcode');

		$payment_payu->hash = Input::get('hash');


		$payment_payu->mihpayid = Input::get('mihpayid');
		$payment_payu->status = Input::get('status');
		$payment_payu->unmappedstatus = Input::get('unmappedstatus');
		$payment_payu->key = Input::get('key');
		$payment_payu->addedon = Input::get('addedon');
		$payment_payu->txnid = Input::get('txnid');
		$payment_payu->txnid = Input::get('txnid');
		$payment_payu->txnid = Input::get('txnid');

		$payment_payu->field1 = Input::get('field1');
		$payment_payu->field2 = Input::get('field2');
		$payment_payu->field3 = Input::get('field3');
		$payment_payu->field4 = Input::get('field4');
		$payment_payu->field5 = Input::get('field5');
		$payment_payu->field6 = Input::get('field6');
		$payment_payu->field7 = Input::get('field7');
		$payment_payu->field8 = Input::get('field8');
		$payment_payu->field9 = Input::get('field9');

		$payment_payu->PG_TYPE = Input::get('PG_TYPE');		
		$payment_payu->bank_ref_num = Input::get('bank_ref_num');		
		$payment_payu->bankcode = Input::get('bankcode');		
		$payment_payu->error = Input::get('error');		
		$payment_payu->error_Message = Input::get('error_Message');		

		if (!is_null(Input::get('card_token'))) $payment_payu->card_token = Input::get('card_token');		
			
		$payment_payu->name_on_card = Input::get('name_on_card');		
		$payment_payu->cardnum = Input::get('cardnum');		
		$payment_payu->cardhash = Input::get('cardhash');		
		$payment_payu->amount_split = Input::get('amount_split');		
		$payment_payu->payuMoneyId = Input::get('payuMoneyId');		

		$payment_payu->save();

	}

	public function notifyUserSuccess($transaction){
		$params = array('email' => $transaction->payu_info()->email,
	         'firstname' => $transaction->payu_info()->firstname,
	         'phone' => $transaction->payu_info()->phone );

		$transaction->sendSmsPaymentSuccess($params);
		$transaction->sendEmailPaymentSuccess($params);
	}

	public function accountCheck(){
		$account = CusDet::where('account_id','=',Input::get('account_id'))->get()->first();
		if (!is_null($account)) {
			return true;
		} else {
			return false;
		}
	}

	public function getBillNoAjax(){
		$account_id = Input::get('account_id');
		$account = CusDet::where('account_id','=',$account_id)->get()->first();
			if (!is_null($account)) {
				$bill = Bill::where('account_id','=',$account->account_id)
								->orderBy('bill_no', 'desc')->get()->first();
				if (!is_null($bill)) {
					$amount = $bill->amount_before_due_date - $bill->amount_paid;
						if($amount < 0){
							$amount = 0;
						}
						return Response::json(
							array(
								'status' => 'success', 
								'bill_no' => $bill->bill_no,
								'firstname' => $account->first_name,
								'email' => $account->email,
								'phone' => $account->phone,
								'payable_amount' => $amount
								)
							);
			} 
			return Response::json(array('status' => 'failure','status' =>'Bill is yet to not Generated.'));
		}
		return Response::json(array('status' => 'failure','status' =>'Account ID is Invalid'));
	}

	public function UpdateActivation($account_id,$bill_no){
		$bills=Bill::where('account_id','=',$account_id)->get();
		if(count($bills)>=2){
			$active_det=DB::table('activation_details')->where('account_id','=',$account_id)->orderBy('expiry_date','desc')->first();
			if($active_det){
				$bill=Bill::where('account_id','=',$account_id)->orderBy('bill_no','desc')->get()->first();
				if($bill){
					$bill_check=Bill::where('bill_no','=',$bill->bill_no)->where('status','=','paid')->get()->first();
					$paid = $bill->amount_before_due_date - $bill->amount_paid;
					if($paid <= 0 && $bill_check){
						$jsubs=Jsubs::where('account_id','=',$account_id)->where('expiry_date','<',$bill->bill_end_date)->get()->first();
						 if($jsubs){
							if($active_det->expiry_date < $bill->bill_end_date){
								$this->CreateActivationDetails($bill->account_id,$bill->bill_end_date,$bill->amount_paid,$bill->bill_no);
							}
						}
					}
				}
			}else{
				$bill=Bill::where('account_id','=',$account_id)->orderBy('bill_no','desc')->get()->first();
				if($bill){
					$bill_check=Bill::where('bill_no','=',$bill->bill_no)->where('status','=','paid')->get()->first();
					$paid = $bill->amount_before_due_date - $bill->amount_paid;
					if( $paid <= 0 && $bill_check){
						$this->CreateActivationDetails($account_id,$bill->bill_end_date,$bill->amount_paid,$bill->bill_no);
					}
				}
			}
		}
	}

	public function PlanChangeUpdate($account_id,$bill_no){

		if(count(DB::table('plan_change_details')->where('account_id',$account_id)->where('bill_no',$bill_no)->first())!=0){
			DB::table('planchange_details')->where('account_id',$account_id)->update(array('status' => "pending"));
			DB::table('plan_change_details')->where('account_id',$account_id)->where('bill_no',$bill_no)->delete();
		}

		if(count(DB::table('top_up_details')->where('account_id',$account_id)->where('bill_no',$bill_no)->first())!=0){
			DB::table('topup_details')->where('account_id',$account_id)->update(array('status' => "pending"));
			DB::table('top_up_details')->where('account_id',$account_id)->where('bill_no',$bill_no)->delete();
		}
	}

	public function CreateActivationDetails($account_id,$expiry_date,$amount_paid,$bill_no){

		$activation=new ActivationDetails();
		$activation->account_id =$account_id;
		$activation->save();
		if($activation){
			$activation_up=ActivationDetails::where('id',$activation->id)->first();
			$activation_up->bill_no =$bill_no;
			$activation_up->status="approved";
			$activation_up->expiry_date=$expiry_date." 23:59:59";
			$activation_up->request_id =444444;
			$activation_up->bill_no =$bill_no;
			$activation_up->remarks ="amount_paid :".$amount_paid;
			$activation_up->save();
		}

	}

}
