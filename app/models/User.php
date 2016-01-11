<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \LaravelBook\Ardent\Ardent implements UserInterface, RemindableInterface {

	protected $fillable = ['first_name','last_name','email','password','password_confirmation','mobile', 'active','country','about_me','occupation','website_url'];

	public static $passwordAttributes  = array('password','password_confirmation');
  	public $autoHashPasswordAttributes = true;
  	public $autoPurgeRedundantAttributes = true;


  	public static $rules = array(
    	'email' => 'email|min:6|',
    	'account_id' => 'required|min:6|unique:users,account_id',
    	'password' => 'required|between:6,15|confirmed',
    	'password_confirmation'=>'required|between:6,15',
    	'mobile' => 'required|digits:10'
  	);

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function getRememberToken()
	{
    	return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}

	public function bills(){
		return Bill::where('account_id','=',$this->account_id)->get();
		//return Bill::where('account_id','=',User::find(5)->account_id)->get();
	}

	public function wallet(){
		$wallet = Wallet::where('user_id','=',$this->id)->get();
		if (count($wallet)!= 0) {
			$wallet = $wallet->first();
		} else {
			$wallet = new Wallet();
			$wallet->user_id = $this->id;
			$wallet->account_id = $this->account_id;
			$wallet->save();
		}
		return $wallet;
	}

	public function payableAmount(){
		$bills = Bill::where('account_id','=',$this->account_id)->orderBy('bill_no','desc')->get();
		if(count($bills)!=0){
			$amount_before_due_date = $bills->first()->amount_before_due_date;
			$amount_paid = $bills->first()->amount_paid;
			$bill_bal = round($amount_before_due_date - $amount_paid) ;
			if($bill_bal>0){
				return $bill_bal;
			}else{
				return null;
			}
		}
		return null;

	}

	public function payableBill(){
		$bills = Bill::where('account_id','=',$this->account_id)
			->where('status','!=','paid')
			->orderBy('bill_date', 'desc')->get();
		if (count($bills) != 0) {
			return $bills->first();
		} 
		return "";
	}

	public function plan(){
		$plans = Plan::where('account_id','=',$this->account_id)->get();
		if (count($plans) != 0) {
			return $plans->first();
		} 
		return null;
	}

	public function jsubs(){
		$jsubs = Jsubs::where('account_id','=',$this->account_id)->get();
		if (count($jsubs)!= 0) {
			return $jsubs->first();
		}
		return null;
	}	

	public function data_usage(){
		$usage = Jsubs::where('account_id','=',$this->account_id)->get();
		if (count($usage)!= 0) {
			return $usage->first();
		}
		return null;
	}
	
	public function data_duration(){
		$usage = Jsubs::where('account_id','=',$this->account_id)->get();
		if (count($usage)!= 0) {
			return $usage->first()->duration;
		}
		return 0 ;
	}

	

	public function data_usage_in_gb(){
		$usage = Jsubs::where('account_id','=',$this->account_id)->get();
		if (count($usage)!= 0) {
			$usage =  $usage->first();
			$usage_bytes_total = $usage->bytes_total;
			$get_GB = $usage_bytes_total / 1000000000;
			$get_gb_percent = number_format((float)$get_GB, 2, '.', '');

			DB::table('usage_det')
            ->where('account_id', $this->account_id)
            ->update(array('gb_percent' => $get_gb_percent));


			return $get_gb_percent;
		}
		return 0 ;
	}

	public function bytes_in_gb(){
		$usage = Jsubs::where('account_id','=',$this->account_id)->get();
		if (count($usage)!= 0) {
			$usage =  $usage->first();
			$usage_bytes_in = $usage->bytes_down;
			$get_GB = (float)$usage_bytes_in / 1000000000;
			$get_gb_percent = number_format((float)$get_GB, 2, '.', '');
			return $get_gb_percent;
		}
		return null;
	}

	public function bytes_out_gb(){
		$usage = Jsubs::where('account_id','=',$this->account_id)->get();
		if (count($usage)!= 0) {
			$usage =  $usage->first();
			$usage_bytes_out = $usage->bytes_up;
			$get_GB = (float)$usage_bytes_out / 1000000000;
			$get_gb_percent = number_format((float)$get_GB, 2, '.', '');
			return $get_gb_percent;
		}
		return null;
	}

	public function data_usage_total_gb(){
		$usage = Jsubs::where('account_id','=',$this->account_id)->get();
		if (count($usage)!= 0) {
			$usage =  $usage->first();
			$usage_bytes_in = $usage->bytes_up;
			$usage_bytes_out = $usage->bytes_down;
			$usage_total = (float)$usage_bytes_in + (float)$usage_bytes_out;
			
			$get_gb_percent = number_format((float)$usage_total, 2, '.', '');
			return $get_gb_percent;
		}
		return null;
	}


}
