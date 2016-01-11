<?php

class Message extends \LaravelBook\Ardent\Ardent {

	protected $table = 'messages';

	public function assgined_to(){
			$name = Employee::where('employee_identity',$this->updated_by)->first();
			return  $name;
	}

	public function updateParent(){
		if ($this->object_type == "ticket") {
			$ticket = Ticket::find($this->object_id);
			$ticket->status_id = $this->status_id;
			$ticket->save();
		}else if($this->object_type == "incident") {
			$ticket = Incident::find($this->object_id);
			$ticket->status_id = $this->status_id;
			$ticket->save();
		}
	}



}
