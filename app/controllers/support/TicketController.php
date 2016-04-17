<?php

namespace support;
use Auth, View, Ticket, Input, Redirect, Employee, PaymentTransaction;

class TicketController extends \BaseController {

	public function store(){
		$ticket = new Ticket();
		if(Input::get('crf_no')){
	    	$ticket->crf_no = Input::get('crf_no');
		}else{
			$account_id = Input::get('account_id');
			$ticket_open=Ticket::where('account_id',$account_id)->where('status_id',3)->first();
			$ticket_process=Ticket::where('account_id',$account_id)->where('status_id',5)->first();
			if($ticket_open || $ticket_process){
				return Redirect::back()->with('failure','Ticket has been taken which status open');
			}
			$ticket->account_id = $account_id;
		}
		$ticket->name = Input::get('name');
		$ticket->mobile = Input::get('mobile');
		$ticket->email = Input::get('email');
		$ticket->address = Input::get('address');
		$ticket->ticket_type_id = Input::get('ticket_type_id');
		$ticket->city_id = Input::get('city_id');
		$ticket->requirement = Input::get('requirement');
		$ticket->area = Input::get('area');
		$ticket->assigned_to =Input::get('employee_id');
		$ticket->assigned_by = Auth::employee()->get()->employee_identity;
		$ticket->active = 1;
		$ticket->save();
		$ticket->generateTicketNo();
		$ticket->updateStatus();
		$ticket->AssignUpdate($ticket->requirement);

		$employee=Employee::where('employee_identity','=',Input::get('employee_id'))->get()->first();
		 if($employee){
			$senderId = "OODOOS";
			$message = 'compilant '.'Ticket No '.$ticket->ticket_no.' '.$ticket->name.' '.$ticket->account_id.' '.$ticket->mobile.' '.$ticket->address;
			$mobileNumber = $employee->mobile;		

			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message); 
		}

		return Redirect::back()->with('success','Succesfully Created');

}

}