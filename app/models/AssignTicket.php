<?php

class AssignTicket extends Eloquent {

	protected $table = 'assign_tickets';

	public function assigned($update){
			return Employee::where('employee_identity',$update)->first();
	}

}