<?php
namespace Support;
use View, BaseController, Masterdata, MailSupport;
class SupportController extends BaseController {
	public function index(){
	    $mails = MailSupport::where('label', 'INBOX')->get();
		$data['mails'] = $mails;
	    return View::make('support.mailSupport.mail', $data);
		#return View::make('support.mailSupport.mail');
	}

	public function query(){
		$data['areas'] =Masterdata::where('type','area')->get();
		return View::make('support.userDetails.query', $data);
	}

}