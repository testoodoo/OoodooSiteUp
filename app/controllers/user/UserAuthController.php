<?php 

namespace User;
use Input, Validator, Auth, Password, BaseController, View, Redirect, Lang, Hash, Session, User, CusDet;
use DateTime, DB, TempAccountDetail, Mail;

class UserAuthController extends BaseController {

	protected $layout = 'user._layouts.login';
	
	public function getLogin() {
		if( Auth::check() )
			return Redirect::intended('user');
		$this->layout->main = View::make('user.auth.login');
	}

	
	public function postLogin() {

		$credentials = array(
			'account_id'    => strtoupper(Input::get('account_id')),
			'password' => Input::get('password')
		);
		$rules = ['account_id' => 'required','password'=>'required'];
        $validator = Validator::make($credentials,$rules);

        if($validator->passes()) {

        	if(Auth::user()->attempt($credentials)) {
        		//$after_login_redirect = Session::get('after_login_redirect');
        		//Session::forget('after_login_redirect'); //delete the key on session
        		
        		return Redirect::to("/");
        	} else {
        		if (!empty(Input::get('account_id'))) {
        			if (count(User::where('account_id','=',strtoupper(Input::get('account_id')))->get()) == 0) {
        				return $this->checkInCustDet();	
        			}
					
				}
        		return Redirect::back()->withInput()
        				->with('failure',Lang::get('account_id or password is invalid!'));
        	}
		} else {
			if (!empty(Input::get('account_id'))) {
				if (count(User::where('account_id','=',strtoupper(Input::get('account_id')))->get()) == 0) {
					return $this->checkInCustDet();
				}
			}
			return Redirect::back()->withErrors($validator)->withInput();
		}

	}
	
	public function getLogout() {
		Auth::user()->logout();
		return Redirect::route('user.login');
	}

	private function checkInCustDet(){
		$cust_det = CusDet::where('account_id','=',strtoupper(Input::get('account_id')))->get();
		if (count($cust_det) != 0) {
			$cus = $cust_det->first();
			$tpd = TempAccountDetail::where('account_id','=',$cus->account_id)->first();
			if (count($tpd)!=0) {
				$temp_password = $tpd->first()->password;				
			}else{
				$temp_password ="oodoo@123";
			}

			$user = new User();
            $user->account_no = $cus->account_no;
            $user->account_id = $cus->account_id;
            $user->first_name = $cus->first_name;
            $user->email = $cus->email;

            //$temp_password = substr( md5(rand()), 0, 10);
            $user->password = $temp_password;
            $user->password_confirmation = $temp_password;
            $user->address = $cus->address1 .' '. $cus->address2. ' ' . $cus->address3;
            $user->city = $cus->city;
            $user->state = $cus->state;
            $user->pincode = $cus->pincode;
            $user->mobile = $cus->phone;
            $user->dob = new DateTime($cus->dob);
            $user->gender = $cus->gender;
            $user->is_old_customer = $cus->is_old_customer;
            $user->last_name = $cus->last_name;
            $user->active = 1;

            if ($user->save()) {
            	$credentials = array(
					'account_id'    => $user->account_id,
					'password' => $temp_password
				);

				if(Auth::user()->attempt($credentials)) {
	        		return Redirect::to("/");
	        	}
	        	return Redirect::back()->withInput()
	        		
	        				->with('failure',Lang::get('account_id or password is invalid!'));
            }

		}

		return Redirect::back()->withInput()
	        				->with('failure',Lang::get('Invalid Account ID!'));
            return Redirect::back()->withErrors($user->errors())->withInput();
	}

	public function forgotPasswordRequest(){

		$account_id = Input::get('account_id');

		if (!empty($account_id)) {
			
				$cust_det = CusDet::where('account_id','=',strtoupper(Input::get('account_id')))->get()->first();

			if (isset($cust_det)) {
				$users = User::where('account_id','=',$account_id)->get()->first();
				$tpd = TempAccountDetail::where('account_id','=',$cust_det->account_id)->first();
						if (count($tpd)!=0) {
							$temp_password = $tpd->first()->password;				
						}else{
							$temp_password ="oodoo@123";
						}
				if(!$users){

					$user_det = new User();
		            $user_det->account_no = $cust_det->account_no;
		            $user_det->account_id = $cust_det->account_id;
		            $user_det->first_name = $cust_det->first_name;
		            $user_det->last_name = $cust_det->last_name;
		            $user_det->email = $cust_det->email;
		            $user_det->password = $temp_password;
            		$user_det->password_confirmation = $temp_password;
		            $user_det->address = $cust_det->address1 .' '. $cust_det->address2. ' ' . $cust_det->address3;
		            $user_det->city = $cust_det->city;
		            $user_det->state = $cust_det->state;
		            $user_det->pincode = $cust_det->pincode;
		            $user_det->mobile = $cust_det->phone;
		            $user_det->dob = new DateTime($cust_det->dob);
		            $user_det->gender = $cust_det->gender;
		            $user_det->is_old_customer = $cust_det->is_old_customer;
		            $user_det->active = 1;
		            $user_det->save();
		        }

				$token = substr( md5(rand()), 0, 10);

				DB::table('users')
					->where('account_id', $account_id)
            		->update(array('forget_password_token' => $token,'forget_password_token_created_at' => date('Y-m-d H:i:s')));

            	$user=$cust_det;
				$data['user'] = $cust_det;
				$data['token'] = $token;
				Mail::send('emails.forget_password', $data, function($message) use ($user) {
		 	       $message->from('support@oodoo.co.in',"Support OODOO")->to($user->email, "Password Reminder")->subject("Reset your OODOO Password");
		 	    });
			}else{
				return Redirect::route('user.login')->with('failure',"Invalid Mail Id.");
			}
		return Redirect::route('user.login')->with('success',"Password Details sent to your Email.");
		}
	return Redirect::route('user.login')->with('failure',"Account ID NOT Found.");

	}

	public function resetPasswordRequest(){
		$users = User::where('forget_password_token','=',Input::get('token'))->get();
		if(count($users) != 0){
			$user = $users->first();
			if (!empty($user->forget_password_token)) {
				if (Input::get('token') == $user->forget_password_token) {
					$to_time = strtotime(date('Y-m-d H:i:s'));
					$from_time = strtotime($user->forget_password_token_created_at);
					$time_difference =  round(abs($to_time - $from_time) / 60,2);

					//if ($time_difference >= 1444) {
						$data['user'] = $user;
						return View::make('user.auth.reset_password',$data);		
					//} 
					//return Redirect::route('user.login')->with('failure',"Reset Password Token Expired. Try Again!");		
				}
			}
			return Redirect::route('user.login')->with('failure',"Invalid Token");		
		}
		return Redirect::route('user.login')->with('failure',"Invalid Request");		
		
	}

	public function resetPassword(){
		$user = User::find(Input::get('user_id'));

		if(!empty($user)) {

			$user::$rules = [];	

			$user->password = Input::get('password');
			$user->password_confirmation = Input::get('password');

			$user->save();
			return Redirect::route('user.login')->with('success',"Password Reset Succesful. Login with your New Password");		
		}
		return Redirect::route('user.login')->with('failure',"Invalid Request");		
	}

}
