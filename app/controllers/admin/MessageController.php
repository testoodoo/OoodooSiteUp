<?php

use \Illuminate\Config\Repository;

class MessagesController extends BaseController {

	
	public function store(){
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

}