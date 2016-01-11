<?php
namespace User;
use View, Redirect, Auth, DateTime, Input, User, CusDet, BaseController;
use \Illuminate\Config\Repository;

class UsersController extends BaseController {

	
	protected $layout = 'user._layouts.default';

	public function index(){
		return View::make('dashboard');
	}

	public function view(){

		$user = Auth::user()->get();
		if (!empty($user)) {
			return View::make('user.view', array('user' => $user));
		} else {
			return Redirect::route('dashboard')->with('failure',"Invalid User ID");
		}
	}

	public function edit(){

		//$this->migration_cust_det_to_users();
		$user = Auth::user()->get();
		if (!empty($user)) {
			return View::make('user.edit', array('user' => $user));
		} else {
			return Redirect::route('dashboard')->with('failure',"Invalid User ID");
		}
	}

	public function change_password(){
		$user = Auth::user()->get();
		if (!empty($user)) {
			return View::make('user.change_password', array('user' => $user));
		} else {
			return Redirect::route('dashboard')->with('failure',"Invalid User ID");
		}
	}


	public function update() {
		$user = Auth::user()->get();
		if (!empty($user)) {

			$user::$rules = [];	

			// $user::$rules['email'] = $user::$rules['email']. ",$user->id";
			// $user::$rules['mobile'] = $user::$rules['mobile']. ",$user->id";
			// $user::$rules['password'] = (Input::get('password')) ? $user::$rules['password'] : '';
   //  		$user::$rules['password_confirmation'] = (Input::get('password')) ? $user::$rules['password_confirmation'] : '';
    		
    		$data = Input::all();

    		if(!$user->update($data)) {
				return Redirect::back()
						->withErrors($user->errors())
						->withInput();
			}

			if (Input::get('dob')) {
				$user->dob = new DateTime(Input::get('dob'));
				$user->save();	
			} 

			return Redirect::route('users.profile')
					->with('success','Succesfully saved your Information')
					->withInput();
		} else {
			return Redirect::route('dashboard')->with('failure',"Invalid User ID");
		}
			
	}

	private function migration_cust_det_to_users(){
		$cust_det = CusDet::groupBy('account_id')->get();

		foreach ($cust_det as $key => $cus) {
			$user = new User();
			$user->account_no = $cus->Account_No;
			$user->account_id = $cus->Account_ID;
			$user->first_name = $cus->First_Name;
			$user->last_name = $cus->Last_Name;
			$user->email = $cus->Email;
			$user->password = 'oodoo@123';
		    $user->password_confirmation = 'oodoo@123';
			$user->address = $cus->Address1 .' '. $cus->Address2. ' ' . $cus->Address3;
			$user->city = $cus->City;
			$user->state = $cus->State;
			$user->pincode = $cus->Pincode;
			$user->mobile = $cus->Phone;
			$user->dob = new DateTime($cus->DOB);
			$user->gender = $cus->Gender;
			$user->i_account_no = $cus->iAccount_No;
			$user->is_old_customer = $cus->is_old_customer;
			$user->active = 1;
		    $user->save();
		}

		//var_dump("Successfully Migrated from cust_det to users table!!!!!!!! Now comment out the function migration_cust_det_to_users( ) in edit method"); die;
	}



}
