<?php
namespace Admin;
use View,Role,Bill, Input,DB,Redirect,PlanCostDetail,CustDet,Response,Plan,Adjustment;
use NewCustomer,Api,CusDet,Validator,SiteLoginPassword,InternetPassword;

class ActivationController extends \BaseController {


	public function post(){
		$fn = Input::get("fn");
		if(!is_null($fn)) {
			$method_name = "post_".$fn;
			if( method_exists($this, $method_name)) 
				return $this->$method_name();
		}
		//return failure
	}

	public function post_customer_to_account(){
		$customer = NewCustomer::find(Input::get('new_customer_id'));
		if(!is_null($customer)){
			$account = $this->copyCustomerToAccount($customer);
			if($account !== false){
				//$s = Api::add_iaccount("dasd", "dasd", "dsdasd");
				$password = $this->internet_password($account->account_no);
				$account_id = $this->getAccountId($account->account_no);

				if(!empty($password) && !empty($account_id)){
					//$s = Api::add_iaccount("TEST0909000", "TEST0909000", $password);
					var_dump($s); die;
				}
				
			}
			
			return Response::json(array('status' => 'failure','message' => 'Account Not Created! Validation Error!'));
		}
		return Response::json(array('status' => 'failure','message' => 'New Customer ID Not Found'));
	}

	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////// Private Methods ////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////

	private function copyCustomerToAccount($customer){
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

		if ($account->save()) {

			//getting account based on customer email, because for some reasons account object returning null
			$account = CusDet::where('email','=',$customer->email)->get()->first();
			$this->updateAccountID($account);
			$this->createPasswords($account->account_no);
			return $account;
		}

		return false;
	}

	private function updateAccountID($account){
		//generate Account ID 
		$account_id = "TEST" . $account->account_no;

		DB::table('cust_det')
            ->where('account_no', $account->account_no)
            ->update(array('account_id' => $account_id));
	}

	private function createPasswords($account_no){

		$account = CusDet::where('account_no','=',$account_no)->get()->first();

		$password = substr( md5(rand()), 0, 10);

		//Insert the Password to site_login_passwords and internet_passwords table

		SiteLoginPassword::create(array('account_id' => $account->account_id, 'password' => $password));				
		InternetPassword::create(array('account_id' => $account->account_id, 'password' => $password));				

	}

	private function internet_password($account_no){
		$account = CusDet::where('account_no','=',$account_no)->get()->first();
		$ip = InternetPassword::where('account_id','=',$account->account_id)->get()->first();
		if(!is_null($ip) && !empty($ip)){
			return $ip->password;
		}
		return "";
	}

	private function getAccountId($account_no){
		return CusDet::where('account_no','=',$account_no)->get()->first()->account_id;
	}

}