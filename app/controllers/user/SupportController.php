<?php
namespace User;
use View, BaseController, Input, Ticket, Redirect, Auth, User, DB,Masterdata;
use \Illuminate\Config\Repository;

class SupportController extends BaseController {

	protected $layout = 'user._layouts.default';


	public function index(){
		return View::make('user.support.index');
	}

		public function complaint() {

		$data['ticket_types'] = Masterdata::where('type','=','Complaint')->get();
		$data['cities'] = Masterdata::where('type','=','city')->get();
		$data['areas'] = Masterdata::where('type','=','area')->get();

		return View::make('user.support.complaint',$data);
	}

		public function complaint_store() {

		$ticket = new Ticket();
		$ticket->account_id = Auth::user()->get()->account_id;
		$ticket->name = Input::get('name');
		$ticket->mobile = Input::get('mobile');
		$ticket->email = Input::get('email');
		$ticket->address = Input::get('address');
		$ticket->ticket_type_id = Input::get('ticket_type_id');
		$ticket->status_id = 3;
		$ticket->owner_type = "user";
		$ticket->requirement = Input::get('remarks');
		$ticket->city_id = Input::get('city_id');
		//$ticket->belonging_id = Input::get('belonging_id');
		//$ticket->belonging_type = Input::get('belonging_type');
		//$ticket->owner_id = Auth::employee()->get()->id;
		//$ticket->owner_id = Auth::employee()->get()->employee_identity;
		//$ticket->owner_type =Input::get('employee_id');
		$ticket->is_active = 1;
		$ticket->save();



		$ticket->generateTicketNo();
		$ticket->updateStatusUser();

		return Redirect::back()->with('success','Succesfully Created');

		return Redirect::back()->with('success','Ticket created successfully');
	}	
}