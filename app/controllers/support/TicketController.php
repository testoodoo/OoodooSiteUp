<?php

namespace support;
use Auth, View, Ticket, Input, Redirect, CusDet, DB, Datatables, Employee, Session, PaymentTransaction, MailController;

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
		$ticket->assigned_to =Input::get('employee_id');
		$ticket->assigned_by = Auth::employee()->get()->employee_identity;

		if(Input::get('crf_no')){
	    	$ticket->crf_no = Input::get('crf_no');
	    	$area=NewCustomer::where('application_no',$ticket->crf_no)->first()->address3;
		}else{
			$ticket_open=Ticket::where('account_id',Input::get('account_id'))->where('status_id',3)->first();
			$ticket_process=Ticket::where('account_id',Input::get('account_id'))->where('status_id',5)->first();
			if($ticket_open || $ticket_process){
				Session::flash('message','Ticket has been taken which status open');
				//return Redirect::back();				
				//return Redirect::back()->with('failure','Ticket has been taken which status open');
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
			$message = 'compilant '.'Ticket No '.$ticket->ticket_no.' '.$ticket->name.' '.$ticket->account_id.' '.$ticket->mobile.' '.$ticket->address;
			$mobileNumber = $employee->mobile;	

			$to_mail = Input::get('email');

			app('MailController')->autoMessage($to_mail, 'testoodoo1@gmail.com', 'Ticket Raised', $ticket->ticket_no, $body);	
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
}

