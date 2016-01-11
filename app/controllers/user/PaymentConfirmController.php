<?php
namespace User;
use Session, ConstantValue, Auth, Input, round, PlanChangeDetail, Bill, TopupDetail, PaymentTransaction, hash;
use View, Redirect, Request, BaseController;
use \Illuminate\Config\Repository;

class PaymentConfirmController extends BaseController {

protected $layout = 'user._layouts.default';
	
	public function index(){
		$account_id = Auth::user()->get()->account_id;
		$data['payment'] =PaymentTransaction::where('account_id','=',$account_id)
											->orderBy('id','desc')->paginate(20);

		return View::make('user.payment.index',$data);
	}
	
	public function payment_confirm(){
		$bill_no = Session::get("bill_no");
		$payable_amount = Session::get("payable_amount");
		$gateway_charge = 0.01;
		$data['gateway_charge'] = $gateway_charge;
		$data['payable_amount'] = $payable_amount;
		$data['bill_no'] = $bill_no;
		return View::make('user.payment.payment_confirm',$data);
	}

	public function payment_process(){
		
		$account_id = Auth::user()->get()->account_id;
		$gateway_charge_val = 0.01;


		$bill_no = Input::get('bill_no');
		$payable_amount = Input::get('payable_amount');
		$gateway_charge_amount = round($payable_amount * $gateway_charge_val);
		$amount = Input::get('total_amount');

		//pay bill
		$bill_det = Bill::where('bill_no','=',$bill_no)->get()->first();
		$amount_before_due_date = $bill_det->amount_before_due_date;
		$amount_paid = $bill_det->amount_paid;

		$payable_amount_val = $amount_before_due_date - $amount_paid;
		$amount_val = $payable_amount_val + $gateway_charge_amount;
		// Validation
		if($payable_amount_val == $payable_amount && $amount_val == $amount){
			
			$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
			$tran_code = substr( "ABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,26 ) ,1 ). substr($account_id, -3) . substr(Input::get('bill_no'), -3) . sprintf("%06s", count(PaymentTransaction::all()));
			$transaction = new PaymentTransaction();
			$transaction->account_id = Auth::user()->get()->account_id;
			$transaction->transaction_code = $tran_code;
			$transaction->amount = Input::get('payable_amount');
			$transaction->status = "pending";
			$transaction->bill_no = $bill_no;
			$transaction->transaction_type = "cash";
			$transaction->merchant_id = $txnid;
			$transaction->payment_type = "online-acpay";
			$transaction->save();


			// Remove command during production server
			/*$salt = "GQs7yium";
			$key = "JBZaLc";
*/
			$salt = "nhQKVA7x";
			$key = "D2KszY";

			$firstname = Auth::user()->get()->first_name;
			$email = Input::get('email');
			$phone = Input::get('phone');
			$productinfo = "test";

			$udf1 = Auth::user()->get()->account_id;
		    $udf2 = $payable_amount;
		    $udf3 = $gateway_charge_amount;
		    $udf4 = $tran_code;
		    $udf5 = $amount;
		    $udf6 = "";
		    $udf7 = "";
		    $udf8 = "";
		    $udf9 = "";
		    $udf10 = "";

		    $data['s_url'] = Request::root() ."/payment/payment_success";
		    $data['f_url'] = Request::root() . "/payment/payment_failed";

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

		    //Remove command during production server
			//$data['gateway_url'] = "http://test.payu.in/_payment";
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

			return View::make('user.payment.payment_process',$data);

		}else{
			return Redirect::back()->with('failure','Invalid amount, Please try again.');

		}


	}



}

