<?php

namespace Admin;

use Employee;
use View,Roles,Input,DB,Redirect,Masterdata,EmployeeTeam,Datatables;
class EmployeesController extends \BaseController {

	protected $config;

	public function index(){
		$query = Input::get('query');
		if ( !is_null($query) && !empty($query)){
			$data['employees'] = Employee::orWhere('name','like','%'.$query.'%')
								->orWhere('email','like','%'.$query.'%')
								->orWhere('mobile','like','%'.$query.'%')
								->orWhere('office_mobile','like','%'.$query.'%')
								->orWhere('employee_identity','like','%'.$query.'%')
								->paginate(10);
			$data['query'] = $query;
			} else {
			$data['query'] = "";
			$data['employees'] = Employee::paginate(10);
		}
		$data['query'] = $query;
		return View::make('admin.employees.index', $data);
	}

	public function edit($id) {
		$employee = Employee::find($id);
		if (is_null($employee)) 
			return Redirect::route('admin.employees.index')->with('failure','Invalid Employee ID');
		$data['employee'] = $employee;
		$data['roles'] = Roles::all();
		return View::make('admin.employees.edit', $data);
	}

	public function update()	{
		$employee = Employee::find(Input::get('id'));

		if( !is_null($employee) ) {
		DB::table('employees')->where('id',Input::get('id'))->update(array(
            'name'                   => Input::get('name'),
            'email'                  => Input::get('email'),
            'role_id'                => Input::get('role_id'),
            'mobile'                 => Input::get('mobile'),
            'office_mobile'          => Input::get('office_mobile'),
            'office_email'           => Input::get('office_email'),
            'qualification'          => Input::get('qualification'),
            'dob'                    => Input::get('dob'),
            'father_husband_name'    => Input::get('father_husband_name'),
            'current_address'        => Input::get('current_address'),
            'permanent_address'      => Input::get('permanent_address')));
    		
			return Redirect::route('admin.employees.index')
					->with('success','Succesfully saved Employee');
		}
		return Redirect::back()
					->with('failure','Unable to find Employee.');
	}

	public function create() {
		$employee =  new Employee();
		$data['employee'] = $employee;
		$data['roles'] = Roles::all();
		return View::make('admin.employees.create', $data);
	}

	public function store() {
		$employee_id=Input::get('employee_id');
		$employee = new Employee();
            $employee->name                   = Input::get('name');
            $employee->email                  = Input::get('email');
            $employee->password               = Input::get('password');
            $employee->password_confirmation  = Input::get('password_confirmation');
            $employee->role_id                = Input::get('role_id');
            $employee->mobile                 = Input::get('mobile');
            $employee->office_mobile          = Input::get('office_mobile');
            $employee->office_email           = Input::get('office_email');
            $employee->qualification          = Input::get('qualification');
            $employee->dob                    = Input::get('dob');
            $employee->father_husband_name    = Input::get('father_husband_name');
            $employee->current_address        = Input::get('current_address');
            $employee->permanent_address      = Input::get('permanent_address');
            if($employee_id){
            	$employee->employee_identity  = $employee_id;
            }
            if($employee->save())
            {
            $employee::$rules = [];


            if(!$employee_id){
					$employee->generateEmployeeId();
			}

			return Redirect::route('admin.employees.index')->with('success','Employee Created Succesfully');
		}
			return Redirect::back()->withInput()->withErrors($employee->errors());
	}

	public function delete($id){
		$employee = Employee::find($id);
		if (is_null($employee)) 
			return Redirect::route('admin.employees.index')->with('failure','Invalid Employee ID');
		$employee->delete();
		return Redirect::route('admin.employees.index')->with('success','Employee Deleted Succesfully');
	}

	public function assign(){
		$data['employees'] = Employee::all();
		$data['roles'] = Roles::all();
		return View::make('admin.employees.assign', $data);

	}

	public function assignRoles(){
		$employee_select=Input::get('roles');
		$role_id=Input::get('role');
		$employees = Employee::all();

		if($role_id){
			foreach ($employee_select as $key) {
			$employ=Employee::where('employee_identity',$key)->get()->first();
			$employ->role_id=$role_id;
			$employ->forcesave();
			}
		}else{
			foreach ($employees as $key) {
				$employ=Employee::where('employee_identity',$key->employee_identity)->get()->first();
				$employ->is_onduty=0;
				$employ->forcesave();
			}
			foreach ($employee_select as $key) {
				$employ=Employee::where('employee_identity',$key)->get()->first();
				$employ->is_onduty=1;
				$employ->forcesave();
			}
		}

		return Redirect::route('admin.employees.assign')->with('success','Employee assigned Succesfully');
	}

	public function Team(){
		$data['team']= EmployeeTeam::select('id','team','vehicles','members')->get();
		return View::make('admin.employees.employee_team',$data);

	}

	public function TeamEdit($id){
		$data['team']=EmployeeTeam::find($id);
		$employ=json_decode($data['team']->members);
		$data['employ']=Employee::whereIn('employee_identity',$employ)->get();
		$data['vehicles']=json_decode($data['team']->vehicles_no);
		$data['employee']=Employee::whereNotIn('employee_identity',$employ)->get();
		return View::make('admin.employees.team_edit', $data);		
	}

	public function TeamEditPost(){
		$id=Input::get('id');
		$team=EmployeeTeam::find($id);

		$name=Input::get('vehicles_name');
		$employees=Input::get('employees');

		$team->team=Input::get('team');
		$team->members=json_encode($employees);
		$team->vehicles=Input::get('vehicles');
		$team->vehicles_no=json_encode($name);
		$team->save();

		return Redirect::route('admin.employees.team')->with('success','Employee Team Updated Succesfully');

	}

	public function TeamCreate(){
		$data['employee']=Employee::all();
		return View::make('admin.employees.team_create', $data);

	}

	public function TeamPost(){
		$name=Input::get('vehicles_name');
		$employees=Input::get('employees');
		$team=new EmployeeTeam();
		$team->team=Input::get('team');
		$team->members=json_encode($employees);
		$team->vehicles=Input::get('vehicles');
		$team->vehicles_no=json_encode($name);
		$team->save();

		return Redirect::route('admin.employees.team')->with('success','Employee Team Created Succesfully');

	}
	

}