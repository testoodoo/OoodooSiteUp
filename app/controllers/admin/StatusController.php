<?php
use \Illuminate\Config\Repository,Ticket,Incident,ServerDetails;

class StatusController extends BaseController {

	
	public function store(){

				$status = new Stattus();
				$status->object_type = Input::get('object_type');
				$status->updated_by =Auth::employee()->get()->employee_identity;
				$status->status_id = Input::get('status_id');
				if(Input::get('object_type')=='ticket'){
					$Ticket=Ticket::where('id',Input::get('object_id'))->first();
					if(Input::get('status_id')!=$Ticket->status_id){
							$status->object_id = Input::get('object_id');
							$status->save();
							$status->updateParent($status->object_id);
							
							return Redirect::back()->with('success','Status Updated Succesfully');
					}else{
						return Redirect::back()->with('failure','Dupilcate Status Not Updated');
					}
				}else{
					$object_id = Input::get('object_id');
					if($object_id){
						foreach ($object_id as $key) {
							$Incident=Incident::where('id',$key)->first();
							$server=ServerDetails::where('id',$Incident->incident_id)->first();
							if($server->status==0 && Input::get('status_id')==4){
								return Redirect::back()->with('failure','Incident Yet not to be closed');
							}else{
								$status->object_id = $key;
								$status->save();
								$status->updateParent($status->object_id);
							}
						}
						return Redirect::back()->with('success','Status Updated Succesfully');
					}
					return Redirect::back()->with('failure','Incident Invaild');
				}

	}
}