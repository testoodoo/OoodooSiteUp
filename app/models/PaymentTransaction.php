<?php

class PaymentTransaction extends \LaravelBook\Ardent\Ardent {

	protected $table = 'payment_transactions';


	public function sendEmailPaymentSuccess($params){

		
		$user = CusDet::where('account_id','=',$this->account_id)->get()->first();
			                //var_dump($params);die;

		if (!is_null($user)) {
			$bill = Bill::where('bill_no','=',$this->bill_no)->get()->first();
			if (!is_null($bill)) {

				$email = Config::get('custom_config.email');

				if (is_null($email))  $email = $user->email;

				$data = array();
				$data['email'] = $email;
				$data['transaction'] = $this;
				$data['user'] = $user;
				$data['bill'] = $bill;
				$data['payer_email'] = $params['email'];
				$data['payer_name'] = $params['firstname'];
				$data['payer_phone'] = $params['phone'];

				if (!empty($data['email']) && !empty($data['payer_email'])) {

					if ($email == $data['payer_email']) {
						if ($this->transaction_type == "cheque") {
							Mail::send('emails.payment_success_cheque', $data, function($message) use ($data) {
					 	       $message->to($data['email'], $data['user']->first_name )
					 	       			->subject("Payment Successfull");
					 	    });
						} else {
							Mail::send('emails.payment_success_cash', $data, function($message) use ($data) {
					 	       $message->to($data['email'], $data['user']->first_name )
					 	       			->subject("Payment Successfull");
					 	    });	
						}
					} else {
						if ($this->transaction_type == "cheque") {
							Mail::send('emails.payment_success_cheque', $data, function($message) use ($data) {
					 	       $message->to($data['email'], $data['user']->first_name )
					 	       			->subject("Payment Successfull");
					 	    });

					 	    Mail::send('emails.payment_success_to_payer_cheque', $data, function($message) use ($data) {
					 	       $message->to($data['payer_email'], $data['payer_name'])
					 	       			->subject("Payment Successfull");
					 	    });	
						} else {
							Mail::send('emails.payment_success_cash', $data, function($message) use ($data) {
					 	       $message->to($data['email'], $data['user']->first_name )
					 	       			->subject("Payment Successfull");
					 	    });	

					 	     Mail::send('emails.payment_success_to_payer_cash', $data, function($message) use ($data) {
					 	       $message->to($data['payer_email'], $data['payer_name'])
					 	       			->subject("Payment Successfull");
					 	    });	
						}
					}
				}

			}
		}
		
	}

	public function sendSmsPaymentSuccess($params){
		$user = User::where('account_id','=',$this->account_id)->get()->first();

		if (!is_null($user)) {
			$senderId = "OODOOP";
			$message = "Your Payment of Rs.".$this->amount." for Account ID ".$this->account_id." is Successful.\n Your transaction id is". $this->transaction_code ." \n for your future reference. Contact support@oodoo.co.in or +91 8940808080 for more info.";

			$mobileNumber = Config::get('custom_config.mobile');

			if (is_null($mobileNumber))  $mobileNumber = $user->mobile;		
				
			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message);
		}
	}

	public static function sendsms($mobileNumber, $senderId, $message){
		//Your authentication key
		$authKey = "68252AGguI2SK45395d8f7";
		$messageF = urlencode($message);
		$route = "4";
		$response = "json";

		$postData = array(
		    'authkey' => $authKey,
		    'mobiles' => $mobileNumber,
		    'message' => $messageF,
		    'sender' => $senderId,
		    'route' => $route,
			'response' => $response
		);

		$url="https://control.msg91.com/api/sendhttp.php";
		$ch = curl_init();
		if (!$ch) {
		    //die("Couldn't initialize a cURL handle");
			return false;
		}
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 2,
		));
		$output = curl_exec($ch);
		if(!curl_errno($ch)) {
			$str = json_decode($output, true);
			
			if ($str['type'] == 'success') {
				return $output;
			}else{
				return false;
			}
		} else {
			return false;
		}
		curl_close($ch);
	}

	public function cheque(){
		return ChequeTransaction::where('transaction_id','=',$this->id)->get()->first();
	}

	public function payu_info(){
         return PaymentPayu::where('udf4','=',$this->transaction_code)->get()->first();
	}
}