<?php

class TicketInfo extends Eloquent {

	protected $table = 'ticket_info';

	public function updatedBy(){
			return Employee::where('employee_identity',$this->updated_by)->first();
	}

}