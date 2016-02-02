<?php
namespace Support;
use View, BaseController, Masterdata, MailSupport, Input, CusDet;
class SupportController extends BaseController {
	public function index(){
	    $mails = MailSupport::where('label', 'INBOX')->get();
		$data['mails'] = $mails;
	    #return View::make('support.mailSupport.mail', $data);
		#return View::make('support.mailSupport.mail');
	}

	public function query(){
		$data['areas'] =Masterdata::where('type','area')->get();
		$query = Input::get('query');
		if($query){
			$data['cusDet'] = CusDet::where('account_id','like','%'.$query.'%')->orWhere('phone','like','%'.$query.'%')->get();
		}
		return View::make('support.userDetails.query',$data);

	}

	public function userDetails(){
		$query = Input::get('query');
		$data['cusDet'] = CusDet::where('account_id','like','%'.$query.'%')
								->orWhere('phone','like','%'.$query.'%')->get();
		echo json_encode($data);
	}

}


//OFCHN1089464 mejestic residency
//seevaram 
//1088561