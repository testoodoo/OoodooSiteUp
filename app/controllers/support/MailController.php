<?php

define('STDIN',fopen("php://stdin","r"));
define('APPLICATION_NAME', 'Gmail API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/gmail-php-quickstart.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
define('SCOPES', implode(' ', array(
  Google_Service_Gmail::MAIL_GOOGLE_COM)
));

require 'vendor/autoload.php';



class MailController extends BaseController {

   public function index(){
    $query = Input::get('query');
    if($query != NULL){
        $data['mails'] = MailSupport::where('from_mail','like','%'.$query.'%')
                                    ->orWhere('body','like','%'.$query.'%')
                                    ->orWhere('subject','like','%'.$query.'%')->get();
    }else{
        $data['mails'] = MailSupport::whereIn('id', function($query){ $query->selectRaw('max(id)')->from('create_mail_table')->orWhere('label','INBOX')->orWhere('label','SENT')->orderBy('time','ASC')->groupBy('thread_id'); })
                                    ->get();
    }    
    return View::make('support.mailSupport.mail',$data);
   }

   public function ticket($thread_id){
        $data['ticket_type'] = Masterdata::where('type','=','ticket_type')->get();
        $data['team_type'] = Masterdata::where('type','=', 'customer_activation_process')->get();
        $data['complaints'] = Masterdata::where('type','=', 'complaint')->get();
        $data['list'] = MailSupport::where('thread_id', $thread_id)->orderBy('time','ASC')->get()->first();
        $data['mails'] = MailSupport::where('thread_id', $thread_id)->orderBy('time','ASC')->get();
        $data['team_list'] = Masterdata::where('type','=','customer_activation_process')->get();
        return View::make('support.mailSupport.ticket', $data);

   }
   

   public function updateMessage() {

            $client = $this->getClient();
            $service = new Google_Service_Gmail($client);
            $userId='me';
            $list = $service->users_messages->listUsersMessages($userId,['maxResults' => 1000]);
            $messageList = $list->getMessages();

            foreach($messageList as $mlist){
                $idCheck = InboxMail::where('message_id', $mlist->id)->get();
                if(count($idCheck) == 0){

                $optParamsGet2['format'] = 'full';
                $single_message = $service->users_messages->get('me',$mlist->id, $optParamsGet2);
                #var_dump($single_message); die;
                #var_dump($single_message->getPayload()->getFilename());die;
                #$raw = $single_message->getRaw();  // while using $optParamsGet2 "format" is "raw" instead of "full"
                $messageId = $single_message->getId();
                $threadId = $single_message->getThreadId();
                $historyId = $single_message->getHistoryId();
                $labelIds = $single_message->getLabelIds();
                #var_dump(json_decode(json_encode($labelIds))); die;

                $headers = $single_message->getPayload()->getHeaders();
                    foreach ($headers as $header) {
                        if ($header->getName() == 'Subject') {
                            $subject = $header->getValue();
                        }
                        if($header->getName() == 'From'){
                            $from = $header->getValue();
                        }
                        if($header->getName() == 'To'){
                            $to = $header->getValue();
                            #var_dump($to); die;
                        } 
                        if ($header->getName() == 'Date') {
                            $message_date = $header->getValue();
                            $time = date('Y-m-d H:i:s', strtotime($message_date));
                        }

                }

                $prefix = array("Re: ", "Fwd: ");
                $new_subject = str_replace($prefix, "", $subject);
                $fromCheck = InboxMail::where('from_mail', $from)->get();
                $subjectCheck = InboxMail::where('subject', $new_subject)->get()->first();
                if(count($fromCheck) > 0 && count($subjectCheck) > 0){
                    $old_thread_id = $subjectCheck->thread_id;
                    $single_message->setThreadId($old_thread_id);
                    $threadId = $single_message->getThreadId();


                }

                /*  body message   */
                $body = $single_message->getPayload()->getBody();

                #var_dump($this->decode_body("PGRpdiBkaXI9Imx0ciI-dW5yZWFkIG1lc3NhZ2UgYm9keTwvZGl2Pg0K")); die;
                $body_new = $this->decode_body($body['data']);
                #var_dump($body_new); die;
                #var_dump($single_message->getPayload()->getParts()); die;
                if(!$body_new){
                    $parts = $single_message->getPayload()->getParts();
                    foreach($parts as $part){
                            if($part['body']) {
                            $body_new = $this->decode_body($part['body']->data);
                            if($body_new === true){
                                break;
                            }
                        }
                        if($part['parts'] && !$body_new) {
                            foreach ($part['parts'] as $p) {
                                if($p['mimeType'] === 'text/plain' && $p['body']) {
                                    $body_new = $this->decode_body($p['body']->data);
                                    break;
                                }
                            }
                        }
                        if($body_new) {
                            break;
                        }
                    }
                }

                $body = $body_new;

                //attachment success
                unset($attachment);
                $parts = $single_message->getPayload()->getParts();
                foreach ($parts as $part ) {
                    if ($part->getFilename() != null && strlen($part->getFilename())   > 0) {
                        $filename = $part->getFilename();
                        $attId = $part->getBody()->getAttachmentId();
                        $attachPart = $service->users_messages_attachments->get($userId, $messageId, $attId);
                        $attachPart = strtr($attachPart->getData() , "-_" , "+/" );
                        $code_base64 = $attachPart;
                        $code_binary = base64_decode($code_base64);
                        $file_ext = new SplFileInfo($filename);
                        $file_ext = $file_ext->getExtension();
                        $file_hash = hash('sha256', $attId);
                        $file_location = public_path().'/attachId/';
                        #var_dump($file_ext); die;
                        file_put_contents($file_location, $code_binary);
                        #echo "Your attachment ". $filename." with id ".$attId." saved succesfully at ".$file_location;
                        $attachment[] = array(
                        'filename' => $filename,
                        'attachmentId' => $attId,
                        'filelocation' => $file_location
                        );
                        // $image= imagecreatefromstring($code_binary);
                        // header('Content-Type: image/jpeg');
                        // imagejpeg($image);
                        // imagedestroy($image);
                    }
                }
/* remove re and fwd from subject
                $subject = preg_replace('/^Re: /', '', $subject);
                $subject = preg_replace('/^Fwd: /', '', $subject);*/
                $thread_id = MailSupport::where('thread_id',$threadId)->get();
                if(!count($thread_id) && $labelIds['0'] == 'INBOX'){
                    $this->autoMessage($from, $to, $subject, 123, 'test', 123);

                }
                    $inboxmail=new InboxMail();
                    $inboxmail->message_id = $mlist->id;
                    $inboxmail->thread_id = $threadId;
                    $inboxmail->history_id = $historyId;
                    if(isset($labelIds['0'])){
                        $inboxmail->label = $labelIds['0'];
                    }
                    $inboxmail->subject = $subject;
                    $inboxmail->from_mail = $from;
                    $inboxmail->to_mail = $to;
                    $inboxmail->body = $body;
                    if(isset($attachment)){
                        $inboxmail->attachment = json_encode($attachment);
                    }
                    $inboxmail->time = $time;
                    $inboxmail->save();



            }   

        }



    }

    public function autoMessage($from, $to, $subject, $ticket_no, $body, $assigned_to){

        $client = $this->getClient();
        $service = new Google_Service_Gmail($client);
        $userId='me';
        $label = 'ACK';
        if($subject != "Ticket Raised"){

        $subject = "Ticket Received - ".$subject."";
        $body = "Dear ".$from.",\n\nWe would like to acknowledge that we have received your request and a ticket has been created.A support representative will be reviewing your request and will send you a personal response in a short time.\n\nThank you for your patience.\n\nSincerely,\nOODOO Fiber Support Team";
        }else{
            $label = 'SENT';
            $body = "Dear ".$from.",\n\nTicket No: ".$ticket_no." \n\nWe would like to acknowledge that we have received your request and a ticket has been created.A support representative will be reviewing your request and will send you a personal response in a short time.\n\n".$body."\n\nThank you for your patience.\n\nSincerely,\n".Auth::employee()->get()->name."\nOODOO Fiber Support Team";

        }


    $message = new Google_Service_Gmail_Message();
    $text = 'From: '.$to.'
To: '.$from.'
Subject:'.$subject.'

'.$body.'';

        $encoded_message = rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
        $message->setRaw($encoded_message);

        $message = $service->users_messages->send($userId, $message);

        if($subject == "Ticket Raised"){
            $ticketMail = new TicketSupport();
            $ticketMail->thread_id = $message->getThreadId();
            $ticketMail->ticket_no = $ticket_no;
            $ticketMail->status = 'open';
            $ticketMail->assign_to = $assigned_to;
            $ticketMail->save();

        }                      

                    

        $inboxmail=new InboxMail();
        $inboxmail->message_id = $message->getId();
        $inboxmail->thread_id = $message->getThreadId();
        $inboxmail->history_id = 2222;
        $inboxmail->label = $label;
        $inboxmail->subject = $subject;
        $inboxmail->from_mail = $from;
        $inboxmail->to_mail = $to;
        $inboxmail->body = $body;
        if(isset($attachment)){
        $inboxmail->attachment = json_encode($attachment);
        }
        $inboxmail->time = Date("Y-m-d H:i:s");
        $inboxmail->save();        
    }

    public function replyMessage(){
            $client = $this->getClient();
            $service = new Google_Service_Gmail($client);
            $userId='me';
            $thread_id = Input::get('thread_id');
            $assign_to = Input::get('assign_to');
            $employee = Employee::where('employee_identity',$assign_to)->get()->first();
            $employee_name = $employee->name;
            $employee_mobile = $employee->mobile;
            DB::table('create_mail_table')->insert(['thread_id' => $thread_id, 'label' => 'ASSIGN', 'body' => ''.Auth::employee()->get()->name.' assigned the complaint to '.$employee_name.'', 'from_mail' => Auth::employee()->get()->name ,  'time' => Date("Y-m-d H:i:s") ]);
            $ticket_no = TicketSupport::where('thread_id',$thread_id)->get()->first();
            if(!$ticket_no){
                $ticket_no = $this->generateTicketNo();
                $ticketMail = new TicketSupport();
                $ticketMail->thread_id = $thread_id;
                $ticketMail->ticket_no = $ticket_no;
                $ticketMail->status = 'open';
                $ticketMail->assign_to = $assign_to;
                $ticketMail->save();
            }else{
                $ticket_no = $ticket_no->ticket_no;
            }
            $senderDet = MailSupport::where('thread_id',$thread_id)->orderBy('time','ASC')->get()->first();
            $from = $senderDet->to_mail;
            $to = $senderDet->from_mail;
            $subject = $senderDet->subject;
            $content = Input::get('body');
            $body = 'Hi '.$from.'\n Ticket No : '.$ticket_no.'\n\n'.$content.'\n\nSincerely\n'.Auth::employee()->get()->name.'\nOODOO Support team.';
            $message = new Google_Service_Gmail_Message();
            $text = 'From: '.$from.'
To: '.$to.'
Subject: Re: '.$subject.'

'.$body.'';

            $encoded_message = rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
            $message->setRaw($encoded_message);

            
            $message = $service->users_messages->send($userId, $message);
            $thread = $message->setThreadId($thread_id);
            #var_dump($message); die;
            $senderId = "OODOOS";
            $content = 'compilant '.'Ticket No '.$ticket_no;

            $return = PaymentTransaction::sendsms($employee_mobile, $senderId, $content); 
            $inboxmail=new MailSupport();
            $inboxmail->message_id = $message->getId();
            $inboxmail->thread_id = $thread_id;
            $inboxmail->history_id = 1111;
            $inboxmail->label = 'SENT';
            $inboxmail->subject = $subject;
            $inboxmail->from_mail = $from;
            $inboxmail->to_mail = $to;
            $inboxmail->body = $body;
            if(isset($attachment)){
            $inboxmail->attachment = json_encode($attachment);
            }
            $time = Date("Y-m-d H:i:s");
            $inboxmail->time = $time;
            if($inboxmail->save()){
                return Response::json(array('from' => $from, 'body' => $body, 'time' => $time, 'assign_to' => $assign_to));
            }else{
                return Response::json(array('mail' => "false"));
            }
            
    }  

public function addNote(){
    $thread_id = Input::get('thread_id');
    $note = Input::get('note');
    $inboxmail = new InboxMail();
    $inboxmail->message_id = ' ';
    $inboxmail->thread_id = $thread_id;
    $inboxmail->history_id = 1111;
    $inboxmail->label = 'NOTE';
    $inboxmail->subject = ' ';
    $name = Auth::employee()->get()->name.' added Note';


    $inboxmail->from_mail = $name;
    $inboxmail->to_mail = '';
    $inboxmail->body = $note;
    if(isset($attachment)){
    $inboxmail->attachment = json_encode($attachment);
    }
    $time = Date("Y-m-d H:i:s");
    $inboxmail->time = $time;
    if($inboxmail->save()){
        return Response::json(array('from' => $name , 'body' => $note, 'time' => $time, 'label' => 'note'));
    }else{
        return Response::json(array('mail' => "false"));
    }    


}  




public function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = $this->	expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = file_get_contents($credentialsPath);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    #var_dump(fgets(STDIN)); die;
    $authCode = trim(fgets(STDIN));
    #var_dump($authCode); die;

    // Exchange authorization code for an access token.
    $accessToken = $client->authenticate($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, $accessToken);
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->getRefreshToken();
    file_put_contents($credentialsPath, $client->getAccessToken());
  }
  #var_dump($client); die;
  return $client;
}

function decode_body($body) {
    $rawData = $body;
    $sanitizedData = strtr($rawData,'-_', '+/');
    $decodedMessage = base64_decode($sanitizedData);
    if(!$decodedMessage){
        $decodedMessage = FALSE;
    }
    return $decodedMessage;

}


public function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

    public function generateTicketNo(){
        $today_tickets = DB::select('SELECT * FROM create_ticket_status_table where DATE(created_at) = DATE(NOW())');
        $count = strval(count($today_tickets));
        $ticket_no = sprintf("%02s", date('d')). sprintf("%02s", date('m')) .  date('y') . sprintf("%04s", $count+1);
        return $ticket_no;
    }

}
