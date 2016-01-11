<?php

class IncidentUpdate extends \LaravelBook\Ardent\Ardent {

	protected $table = 'incident_eta_det';

	
	public function assigned($update){
			return Employee::where('employee_identity',$update)->first();
	}
	

}