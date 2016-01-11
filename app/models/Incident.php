<?php

class Incident extends Eloquent {

	protected $table = 'incident';

	public function assigned_to(){
			return Employee::where('employee_identity',$this->assigned_to)->first();
	}
	
	public function assigned_by(){
			return Employee::where('employee_identity',$this->assigned_by)->first();
	}

	public function status(){
		$s =  Stattus::where('object_id','=',$this->id)
				->orderBy('id','desc')->get()->first();
		if (!is_null($s)) {
			return $s->status;
		}
	}

	public function employee_identity(){
			$name=Employee::all();
			if($name){
			return $name;
		}
		return NULL;
	}


	public function ticket_type(){
		$md = Masterdata::where('id','=',$this->ticket_type_id)->get()->first();
		if(!is_null($md)){
			return $md->name;
		}
	}


	public function status_history(){
		$status =Stattus::where('object_id','=',$this->id)
				->orderBy('id','desc')->get();
		return $status;
	}

	public function incident_status(){
		$incident =IncidentUpdate::where('incident_id','=',$this->id)->get();
		if(count($incident)!=0){
			return $incident;
		}
		return NULL;
	}

	public function incident(){
		$incident =IncidentUpdate::where('incident_id','=',$this->id)->orderBy('id','desc')->first();
		if(count($incident)!=0){
			return $incident;
		}
		return NULL;
	}

	public function message_history(){
		return Message::where('object_id','=',$this->id)
				->orderBy('id','desc')->get();
	}

	public function otdr_det(){
		$incident =OtdrDetails::where('incident_id','=',$this->id)->get();
		if(count($incident)!=0){
			return $incident;
		}
		return NULL;
	}

	static public function IncidentStatus($status,$area,$from_date,$to_date,$from,$to){
		
		if(!is_null($status)){

		if(!is_null($area)){
			$tickets=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->get();
	        $ticket=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
	    }else{
	        $tickets=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->get();
	        $ticket=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
	    }

		if(count(Incident::whereIn('status_id',$status)->get()) == 0 && count(Incident::whereIn('ticket_type_id',$status)->get()) != 0)   {
			if(!is_null($area)){
		 		$tickets=Incident::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->get();
      			$ticket=Incident::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
			}else{
		 		$tickets=Incident::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->get();
      			$ticket=Incident::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
			}
    	}
            
        if(count(Incident::whereIn('status_id',$status)->get()) != 0 && count(Incident::whereIn('ticket_type_id',$status)->get()) != 0 ){
            if(!is_null($area)){
             	$tickets=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->whereIn('ticket_type_id',$status)->get();
	         	$ticket=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->whereIn('ticket_type_id',$status)
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
	       		}else{
	       			$tickets=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])
	                                  ->whereIn('ticket_type_id',$status)->get();
	         		$ticket=Incident::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])
	                                  ->whereIn('ticket_type_id',$status)
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
	       		}
	        }
	   	}else if(is_null($status) && !is_null($area)){
	   			$tickets=Incident::whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->get();
	         	$ticket=Incident::whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
	   	}
	   	else if(is_null($status) && is_null($area) && $from && $to && ($from!="undefined" && $to!="undefined")){
	   			$tickets=Incident::whereBetween('created_at',[$from_date,$to_date])->get();
	         	$ticket=Incident::whereBetween('created_at',[$from_date,$to_date])
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
	   	}else{
			$ticket= DB::table('incident')->select('id','ticket_no','name','mobile','address','area','requirement')->orderBy('id','desc');
	   		$tickets= DB::table('incident')->get();
	   	}
	   	return  array('ticket' => $ticket,'tickets' => $tickets);
	
	}

}