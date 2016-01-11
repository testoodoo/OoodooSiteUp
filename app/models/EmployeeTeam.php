<?php

class EmployeeTeam extends \LaravelBook\Ardent\Ardent {

	protected $table = 'employees_team';

	public function employees($members){
		$employee=json_decode($members);
		foreach ($employee as $key) {
			$employ[]=Employee::where('employee_identity',$key)->first()->name;
		}
		return $employ;
	}

	public function ticket($members){
		$employee=json_decode($members);
		foreach ($employee as $key) {
			$ticket=Ticket::where('assigned_to',$key)->where('ticket_type_id',28)->where('status_id',3)->get();
			if(count($ticket)){
				foreach ($ticket as $key) {
					$id[]=$key->id;
				}
			}else{
				$id[]=NULL;
			}
		}
		return $id;
	}


}