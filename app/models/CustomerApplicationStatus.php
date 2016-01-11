<?php

class CustomerApplicationStatus extends Eloquent {

	protected $table = 'customer_application_status';

	public function statusName(){
		return Masterdata::find($this->status_id)->name;
	}

	public static function statusSanityCheck($customer_id){

		$message = "";

		$status_list = CustomerApplicationStatus::where('customer_id','=',$customer_id)
						->where('done','=',1)->get();

		foreach ($status_list as $key => $current_status) {
			if($current_status->statusName() == "fiber"){
				//check for splicing 
				$splicing_check = CustomerApplicationStatus::where('customer_id','=',$customer_id)
								->where('status_id','=',Masterdata::getId("splicing","customer_activation_process"))
								->first();
				if(!$splicing_check->done){
					$current_status->done = 0;
					$current_status->save();
					$message .= "Splicing Should be Done before proceed to Fiber!! ";
				}				

			}

			




			//check the rest of the status and add the condition

			if($current_status->statusName() == "configuration"){			
				//check for all status the is done
				$all_status = CustomerApplicationStatus::where('customer_id','=',$customer_id)->lists('done');
				if(in_array("0", $all_status)){
					$current_status->done = 0;
					$current_status->save();
					$message .= "All the steps has to be Done before proceed to configuration!! ";
				}
				
			}

		}


		if(empty($message)){
			return array('status' => true);	
		} else {
			return array('status' => false, 'message' => $message);
		}

		
	}

}