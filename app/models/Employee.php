<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


class Employee extends \LaravelBook\Ardent\Ardent implements UserInterface, RemindableInterface {

  	protected $fillable = ['name','email','password','password_confirmation','mobile', 'active',
  							'current_address', 'permanent_address', 'father_husband_name',
  							'qualification','dob','employee_identity','is_active'];
  	
  	public static $passwordAttributes  = array('password','password_confirmation');
  	public $autoHashPasswordAttributes = true;
  	public $autoPurgeRedundantAttributes = true;
  	
  	public static $rules = array(
	    'name' => 'required|min:1',
		'email' => 'required|email|min:6|unique:employees,email',
		'password' => 'required|min:8|confirmed',
		'password_confirmation'=>'required|min:8',
		'employee_identity' => 'unique:employees,employee_identity'
	);

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employees';

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

	public function Role($role_id) {
		return Roles::where('id','=',$role_id)->get()->first();
	}
	

	public function updateEmployeeRole($role_id) {
		DB::table('employees')->where('id','=',$this->id)
			->update(array('role_id' => $role_id));
	}

	public function generateEmployeeId() {
		$emp_id = "1" . sprintf("%05s", $this->id);
		$this->employee_identity = $emp_id;
		$this->save();
	}

	public function roles(){
		$roles = Rolepermission::where('role_id','=',$this->role_id)->get();
		if (count($roles)!= 0) {
			return $roles;
		}
		return 0 ;
	}



	/**
	* Update Role with allowed Routes
	*/

}