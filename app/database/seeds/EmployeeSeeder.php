<?php

class EmployeeSeeder extends Seeder {

	public function run() {
		
        $employee = new Employee();
	    $employee->name = 'Ganesh';
	    $employee->email = 'ganesh@oodoo.co.in';
	    $employee->password = '00d00@ganesh';
	    $employee->password_confirmation = '00d00@ganesh';
	    $employee->mobile = '9999999999';
	    $employee->active = 1;
	    $employee->save(); 

	    $employee::$rules = [];

	    $employee->generateEmployeeId();

	}
}