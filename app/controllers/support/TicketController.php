<?php

namespace support;
use Auth, View, Ticket, TicketInfo, TicketSupport, Stattus, AssignTicket, Message, Input, Redirect, Masterdata, CusDet, DB, Datatables, Employee, Session, PaymentTransaction, MailController;

class TicketController extends \BaseController {

	public function store(){
		$ticket = new Ticket();
		$body = Input::get('message');
		$ticket->name = Input::get('name');
		$ticket->mobile = Input::get('mobile');
		$ticket->email = Input::get('email');
		$ticket->address = Input::get('address');
		$ticket->ticket_type_id = Input::get('ticket_type_id');
		$ticket->city_id =12;
		$ticket->requirement = Input::get('requirement');
		$assigned_to = Input::get('employee_id');
		$ticket->assigned_to =$assigned_to;
		$ticket->assigned_by = Auth::employee()->get()->employee_identity;

		if(Input::get('crf_no')){
	    	$ticket->crf_no = Input::get('crf_no');
	    	$area=NewCustomer::where('application_no',$ticket->crf_no)->first()->address3;
		}else{
			$ticket_open=Ticket::where('account_id',Input::get('account_id'))->where('status_id',3)->first();
			$ticket_process=Ticket::where('account_id',Input::get('account_id'))->where('status_id',5)->first();
			if($ticket_open || $ticket_process){
				Session::flash('message','Ticket has been taken which status open');
				return Redirect::back();				
				return Redirect::back()->with('failure','Ticket has been taken which status open');
			}
			$ticket->account_id = Input::get('account_id');
			$area=CusDet::where('account_id',$ticket->account_id)->first()->address3;
		}
		
		$ticket->area = $area;
		$ticket->active = 1;

		$ticket->save();

		$ticket->generateTicketNo();
		$ticket->updateStatus();


		if($ticket->ticket_type_id==28){
			$team_type="configuration";
		}else if($ticket->ticket_type_id==29){
			$team_type="account";
		}else if($ticket->ticket_type_id==41){
			$team_type="Incident";
		}else if($ticket->ticket_type_id==27){
			$team_type=Masterdata::where('id',Input::get('ticket_type'))->first()->name;
		}
		//var_dump($team_type); die;

		$ticket->AssignUpdate($ticket->requirement,$team_type,0);

		$employee=Employee::where('employee_identity','=',Input::get('employee_id'))->get()->first();
		 if($employee){
			$senderId = "OODOOS";
			$message = 'complaint '.'Ticket No '.$ticket->ticket_no.' '.$ticket->name.' '.$ticket->account_id.' '.$ticket->mobile.' '.$ticket->address;
			$mobileNumber = $employee->mobile;	

			$to_mail = Input::get('email');

			app('MailController')->autoMessage($to_mail, 'testoodoo1@gmail.com', 'Ticket Raised', $ticket->ticket_no, $body, $assigned_to);	
			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message); 
		}

		//return Redirect::back()->with('success','Succesfully Created');	
		Session::flash('message','Successfully Created');
		return Redirect::back();
		}

	public function callDet() {
		return View::make('support.ticket.call_status');
	}

	public function exo_call_status() {
		$call_log= DB::table('exo_call_log')->select('call_sid','start_time','end_time',
		'call_from','call_to','call_status','recording_url')
		->orderBy('start_time','desc');
        
        $call_logs = Datatables::of($call_log)->make();
       
        return $call_logs;		
	}

	public function ticketCheck() {
		$account_id = Input::get('account_id');
		$ticket_open=Ticket::where('account_id',Input::get('account_id'))->where('status_id',3)->first();
		$ticket_process=Ticket::where('account_id',Input::get('account_id'))->where('status_id',5)->first();
		if($ticket_open || $ticket_process){
			$data['ticket'] = true;
		}else{
			$data['ticket'] = false;
		}
		return $data;

	}

	public function findTicket() {
		$id = Input::get('id');
		$ticket_no = Ticket::where('id',$id)->get()->first()->ticket_no;
		$data['thread_id'] = TicketSupport::where('ticket_no',$ticket_no)->get()->first()->thread_id;
		return $data;
	}

	public function ticket_popup($id) {
		$user= Ticket::where('id','=',$id)->get()->first();
		$data['status_list'] = Masterdata::where('type','=','ticket_status')->get();
		$data['team_list']  = Masterdata::where('type','=','customer_activation_process')->get();
		$data['employees'] = Employee::all();
			$data['ticket'] = $user;
		
			return View::make('support.ticket.ticket_popup',$data);
		
	}

	public function message(){
		$message = new Message();
		$message->message = Input::get('message');
		$message->updated_by =Auth::employee()->get()->employee_identity;
		$object_type = Input::get('object_type');
		$msg=Input::get('msg');

		if($msg=="save"){
			if($object_type=='ticket'){
				$message->object_id = Input::get('object_id');
				$message->object_type=$object_type;
				$message->save(); 
				return Redirect::back()->with('success','Message Updated Succesfully');
			}else{
				$object_id = Input::get('object_id');
				if($object_id){
					foreach ($object_id as $key) {
						$message->object_id =$key;
						$message->object_type=$object_type;
						$message->save();
					}
					
					return Redirect::back()->with('success','Message Updated Succesfully');	
				}
				return Redirect::back()->with('failure','Incident Invaild');
			}
			
		}elseif($msg=="update_customer"){
			DB::table('ticket_info')->where('ticket_id','=',Input::get('object_id'))->update(array('updation' =>1));

			$ticket=Ticket::where('id',Input::get('object_id'))->first();

			if($ticket){
				$senderId="OODOOS";
				$message=Input::get('message');
				$mobileNumber=$ticket->mobile;

				$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message);

				$update=new TicketInfo();
				$update->ticket_id=Input::get('object_id');
				$update->message_type=$msg;
				$update->message=Input::get('message');
				$update->msg_info=$return;
				$update->updation=1;
				$update->updated_by=Auth::employee()->get()->employee_identity;
				$update->save();

				return Redirect::back()->with('success','Operation Updated Succesfully');
				
			}else{
				return Redirect::back()->with('failure','Ticket not Found');
			}
			

		}elseif($msg=="update_operation"){

			DB::table('ticket_info')->where('ticket_id','=',Input::get('object_id'))->update(array('updation' =>1));

			$update=new TicketInfo();
			$update->ticket_id=Input::get('object_id');
			$update->message_type=$msg;
			$update->message=Input::get('message');
			$update->updation=0;
			$update->updated_by=Auth::employee()->get()->employee_identity;
			$update->save();

			return Redirect::back()->with('success','Customer Updated Succesfully');


		}elseif($msg=="update_support"){

			DB::table('ticket_info')->where('ticket_id','=',Input::get('object_id'))->update(array('updation' =>1));

			$update=new TicketInfo();
			$update->ticket_id=Input::get('object_id');
			$update->message_type=$msg;
			$update->message=Input::get('message');
			$update->updation=0;
			$update->updated_by=Auth::employee()->get()->employee_identity;
			$update->save();

			return Redirect::back()->with('success','Support Updated Succesfully');

		}

	}	


	public function status(){

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

					$assignTicket=AssignTicket::where('ticket_no',$Ticket->ticket_no)->orderBy('id','desc')->first();
						if($assignTicket && Input::get('status_id')==4){
							$assignTicket->complete=1;
							$assignTicket->save();
						}

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

	public function SendTicket(){

		$employee_id=Input::get('employee_id');
		$ticket_no=Input::get('ticket_no');
		$mobile=Input::get('phone');
		$employee=Employee::where('employee_identity','=',$employee_id)->get()->first();
		$ticket=Ticket::where('ticket_no','=',$ticket_no)->get()->first();
		$assignTicket=AssignTicket::where('ticket_id',$ticket->id)->orderBy('id','desc')->first();
		if($assignTicket){
				if($ticket->assigned_to==$employee_id){
						return Redirect::back()->with('failure','Ticket aleady assigned failure to assign');
				}

				if(!Input::get('team')){
					$team=$assignTicket->team_type;
				}else{
					$team=Input::get('team');
				}


			if($ticket->account_id)
			{
				$account_id=$ticket->account_id;
			}else{
				$account_id=$ticket->crf_no;
			}
			
			$address=$ticket->address;
			$area=$ticket->area;
			$ticket_no=$ticket->ticket_no;
			$name=$ticket->name;
			
			$ticket->assigned_to=$employee_id;
			$ticket->assigned_by=Auth::employee()->get()->employee_identity;
			
			$assignTicket->complete=1;
			$assignTicket->save();

			$ticket->save();


			$ticket->AssignUpdate(Input::get('remarks'),$team,0);

			$senderId = "OODOOS";
			$message = 'compilant '.'Ticket No '.$ticket_no.' '.$name.' '.$account_id.' '.$mobile.' '.$address;
			$mobileNumber = $employee->mobile;		

			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message); 
		
			return Redirect::back()->with('success','Ticket Assigned Succesfully '); 
		}
		return Redirect::back()->with('failure','Ticket Assign Status Not Found');
	}	

public function setEmployee(){
    	$ticket_type=Input::get('ticket_type');
    	$team_type=Input::get('team_type');
		if($ticket_type==28){
			$emp=Employee::where('role_id',6)->get();
		}elseif($ticket_type==29){
			$emp=Employee::whereIn('role_id',array(9,2,1))->get();
		}elseif($ticket_type==1){
			$emp=Employee::all();
		}       
		foreach ($emp as $key) {
			$subs[$key->employee_identity]=$key->name;
		}
        echo json_encode($subs);
}	







}

