<?php 

namespace Support;

use Session, Input, Validator, Auth, Password, BaseController, View, Redirect, Lang, Hash, Employee, Mail;

class AuthController extends BaseController {

		protected $layout = 'support.auth.index1';
		//protected $layout = 'support.auth.index';

	
	public function index() {
		if( !Auth::check() ) {
			$this->layout->main = View::make('support.auth.index1');
			//$this->layout->main = View::make('support.auth.index');
			//$this->layout->main = View::make('support.auth.login');

		}
		
	}

	public function login() {
		$credentials = array(
			'employee_identity'    => Input::get('employee_id'),
			'password' => Input::get('password')
		);
		$rules = ['employee_identity' => 'required','password'=>'required'];
        $validator = Validator::make($credentials,$rules);
        if($validator->passes()) {
        	if(Auth::employee()->attempt($credentials)) {
        		return Redirect::to("/query");
        	}
        	else
        		Session::flash('message', 'Employee ID or Password is Invalid!');
        		return Redirect::back()->withInput();
        		//return Redirect::back()->withInput()->with('failure',Lang::get('username or password is invalid!'));
		} else {
			Session::flash('message',$validator);
			return Redirect::back()->withInput();
			//return Redirect::back()->withErrors($validator)->withInput();
		}
	}



	public function getForgotPass() {

			return View::make('support.auth.forget_pass1');
	}

	
	public function logout() {
		Auth::employee()->logout();
		return Redirect::route('support.login');
	}


	public function postResetRequest() {
		$response = Password::employee()->remind(Input::only('email'), function($message) {
			$message->subject(Lang::get("7Vachan Adminstrator - Password Reset Request"));
		});
		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('failure', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('success', Lang::get($response));
		}
	}
	public function getResetRequest($group = null, $token = null)
	{
		if (is_null($token) || is_null($group)) App::abort(404);

		return View::make('admin.auth.resetpassword')->with( array('token' => $token,'group' => $group) );
	}

	public function postPasswordReset()
	{

		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::employee()->reset($credentials, function($employee, $password)
		{
			//$employee->password = Hash::make($password);
			$employee->forceSave();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('failure', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::route('admin.login')->with('success', "Password Reset successful. Please login with your new password");
		}
	}

	public function requestForgetPassword(){
		$email = Input::get('email');


		$employee = Employee::where('email','=',$email)->get()->first();

		if(!is_null($employee)) {
			$token = substr( md5(rand()), 0, 10);

			$employee::$rules = [];
			$employee->forget_password_token = $token;
			$employee->save();

			$data['employee'] = $employee;
			$data['token'] = $token;

			Mail::send('emails.forgotpassword', $data, function($message) use ($employee) {
	 	       $message->from('support@oodoo.co.in',"Support OODOO")->to($employee->email, "Password Reminder")->subject("Reset your OODOO Admin Password");
	 	    });
			Session::flash('success','Password Details has been sent to your Email.');
	 	    return Redirect::to('/forgetPass');
		}
		Session::flash('message','Not authorized to do this action');
		return Redirect::to('/forgetPass');
	}

	public function resetPasswordRequest(){
		$employee = Employee::where('forget_password_token','=',Input::get('token'))->get()->first();
		if(!is_null($employee)){
			$data['employee'] = $employee;
			return View::make('support.auth.resetpass',$data);		
		}
		return Redirect::route('/login')->with('failure',"Invalid Request");		
	}

	public function resetPassword(){
		$employee = Employee::where('employee_identity','=',Input::get('employee_identity'))->get()->first();

		if(!is_null($employee)) {
	
			$employee->password = Input::get('password');
			$employee->password_confirmation = Input::get('password');

			if ($employee->forcesave()){
				Session::flash('message','Please Sign In with your New password!');
				return Redirect::route('support.login');
			}
			return Redirect::to('/forgetPass');
		}
		Session::flash('message', 'Invalid Request');
		return Redirect::route('support.login');	
	}

}