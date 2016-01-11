<?php

class Stattus extends Eloquent {
	protected $table ='status';

	public function status(){
		return $this->belongsTo('Masterdata', 'status_id');	
	}

	public function assgined_to(){
			return Employee::where('employee_identity',$this->updated_by)->first();
	}



	public function updateParent($object_id){
		if ($this->object_type == "ticket") {
			$ticket = Ticket::find($object_id);
			$ticket->status_id = $this->status_id;
			$ticket->save();
		}else if($this->object_type == "incident") {
			$ticket = Incident::find($object_id);
			$ticket->status_id = $this->status_id;
			$ticket->save();
		}
	}

}
