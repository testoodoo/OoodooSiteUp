<?php

class Ticket extends \LaravelBook\Ardent\Ardent {

	protected $table = 'tickets';

		public function generateTicketNo(){
		$today_tickets = DB::select('SELECT * FROM tickets where DATE(created_at) = DATE(NOW())');
		$count = strval(count($today_tickets));
		$ticket_no = sprintf("%02s", date('d')). sprintf("%02s", date('m')) .  date('y') . sprintf("%04s", $count);
		$this->ticket_no = $ticket_no;
		$this->save();
	}

	

	public function AssignUpdate($remarks,$team_type,$complete){
			$ticket=new AssignTicket();
			$ticket->ticket_id=$this->id;
			$ticket->ticket_no=$this->ticket_no;
			$ticket->remarks=$remarks;
			$ticket->team_type=$team_type;
			$ticket->complete=$complete;
			$ticket->assigned_to=$this->assigned_to;
			$ticket->assigned_by=$this->assigned_by;
			$ticket->save();
	}

	public function assigned_to(){
			return Employee::where('employee_identity',$this->assigned_to)->first();
	}
	
	public function assigned_by(){
			return Employee::where('employee_identity',$this->assigned_by)->first();
	}

	public function updateStatus(){
		$md_id = Masterdata::getId('Open','ticket_status');

		$status = new Stattus();
		$status->status_id = Masterdata::getId('Open','ticket_status');
		$status->object_type = "ticket";
		$status->object_id = $this->id;
		$status->updated_by = Auth::employee()->get()->employee_identity;
		$status->save();

		$this->status_id = Masterdata::getId('Open','ticket_status');
		$this->save();
	}

	public function updateStatusUser(){
		$md_id = Masterdata::getId('Open','ticket_status');

		$status = new Stattus();
		$status->status_id = Masterdata::getId('Open','ticket_status');
		$status->object_type = "ticket";
		$status->object_id = $this->id;
		$status->updated_by = Auth::user()->get()->account_id;
		$status->save();

		$this->status_id = Masterdata::getId('Open','ticket_status');
		$this->save();
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

	public function assigned_status(){
		$employee =AssignTicket::where('ticket_id','=',$this->id)->get();
		if(count($employee)!=0){
			return $employee;
		}
		return NULL;
	}

	public function message_history(){
		return Message::where('object_id','=',$this->id)
				->orderBy('id','desc')->get();
	}

	public function alert_message(){
		return TicketInfo::where('ticket_id','=',$this->id)
				->orderBy('id','desc')->get();
	}

	public function getOwnStatus(){
		return $this->belongsTo('Masterdata', 'status_id');	
	}

	static public function TicketStatus($status,$area,$from_date,$to_date,$from,$to){
		
		if(!is_null($status)){

			if(!is_null($area)){
				$tickets=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->get();
		        $ticket=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
		    }else{
		        $tickets=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->get();
		        $ticket=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
		    }

			if(count(Ticket::whereIn('status_id',$status)->get()) == 0 && count(Ticket::whereIn('ticket_type_id',$status)->get()) != 0)   {
				if(!is_null($area)){
			 		$tickets=Ticket::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->get();
	      			$ticket=Ticket::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
				}else{
			 		$tickets=Ticket::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->get();
	      			$ticket=Ticket::whereIn('ticket_type_id',$status)->whereBetween('created_at',[$from_date,$to_date])->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
				}
    	}

    	//////////////////////////////////////////////
            
        if(count(Ticket::whereIn('status_id',$status)->get()) != 0 && count(Ticket::whereIn('ticket_type_id',$status)->get()) != 0 ){
            if(!is_null($area)){
             	$tickets=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->whereIn('ticket_type_id',$status)->get();
	         	$ticket=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->whereIn('ticket_type_id',$status)
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
	       		}else{
	       			$tickets=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])
	                                  ->whereIn('ticket_type_id',$status)->get();
	         		$ticket=Ticket::whereIn('status_id',$status)->whereBetween('created_at',[$from_date,$to_date])
	                                  ->whereIn('ticket_type_id',$status)
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
	       		}
	        }
	   	}else if(is_null($status) && !is_null($area)){
	   			$tickets=Ticket::whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)->get();
	         	$ticket=Ticket::whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
		
	   	}
	   	else if(is_null($status) && is_null($area) && $from && $to && ($from!="undefined" && $to!="undefined")){
	   			$tickets=Ticket::whereBetween('created_at',[$from_date,$to_date])->get();
	         	$ticket=Ticket::whereBetween('created_at',[$from_date,$to_date])
	                                  ->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
	   	}else{
			$ticket= DB::table('tickets')->select('id','ticket_no','name','mobile','address','area','requirement','assigned_to')->orderBy('id','desc');
	   		$tickets= DB::table('tickets')->get();
	   	}

	
	   	return  array('ticket' => $ticket,'tickets' => $tickets);
	
	}

}
