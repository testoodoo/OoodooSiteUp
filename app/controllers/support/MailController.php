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
    #$data['mails'] = MailSupport::where('label','INBOX')->get(); 
    $data['mails'] = MailSupport::whereIn('id', function($query) { $query->selectRaw('max(id)')->from('create_mail_table')->groupBy('thread_id'); })->get();
    return View::make('support.mailSupport.mail',$data);
   }

   public function ticket($id){


    $thread_id = MailSupport::where('id',$id)->get()->first()->thread_id;
    $data['thread_id'] = $thread_id;
    $data['mails'] = MailSupport::where('thread_id', $thread_id)->orderBy('time','ASC')->get();
    $data['subject'] = MailSupport::where('thread_id', $thread_id)->orderBy('time','ASC')->get()->first()->subject;
    $remark = Input::get('remark');
    if($remark){
        $ticket = new MailTicket();
        $ticket->thread_id = $thread_id;
        $ticket->message = $remark;
        $ticket->save();
    }
    $data['messages'] = MailTicket::where('thread_id', $thread_id)->orderBy('created_at','ASC')->get();
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
                        $file_location = '/tmp/'.$file_hash.'.'.$file_ext;
                        #var_dump($file_ext); die;
                        file_put_contents($file_location, $code_binary);
                        #echo "Your attachment ". $filename." with id ".$attId." saved succesfully at ".$file_location;
                        $attachment[] = [
                        'filename' => $filename,
                        'attachmentId' => $attId,
                        'filelocation' => $file_location
                        ];
                        // $image= imagecreatefromstring($code_binary);
                        // header('Content-Type: image/jpeg');
                        // imagejpeg($image);
                        // imagedestroy($image);
                    }
                }
/* remove re and fwd from subject
                $subject = preg_replace('/^Re: /', '', $subject);
                $subject = preg_replace('/^Fwd: /', '', $subject);*/



                    $inboxmail=new InboxMail();
                    $inboxmail->message_id = $mlist->id;
                    $inboxmail->thread_id = $threadId;
                    $inboxmail->history_id = $historyId;
                    $inboxmail->label = $labelIds['0'];
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

    public function replyMessage($thread_id){
            $client = $this->getClient();
            $service = new Google_Service_Gmail($client);
            $userId='me';
            $senderDet = MailSupport::where('thread_id',$thread_id)->orderBy('created_at','ASC')->get()->first();
            $from = $senderDet->to_mail;
            $to = $senderDet->from_mail;
            $subject = $senderDet->subject;
            $body = Input::get('body');
                $message = new Google_Service_Gmail_Message();

$text ='From: '.$from.'
To: '.$to.'
Subject:'.$subject.'

'.$body.'';

            $encoded_message = rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
            $message->setRaw($encoded_message);
            $message = $service->users_messages->send($userId, $message);
           /* $inboxmail=new InboxMail();
            $inboxmail->message_id = $message->getId();
            $inboxmail->thread_id = $thread_id;
            $inboxmail->history_id = '0000';
            $inboxmail->label = 'SENT';
            $inboxmail->subject = $subject;
            $inboxmail->from_mail = $from;
            $inboxmail->to_mail = $to;
            $inboxmail->body = $body;
            if(isset($attachment)){
            $inboxmail->attachment = json_encode($attachment);
            }
            $inboxmail->time = Date("Y-m-d H:i:s");
            $inboxmail->save();
            */
            print 'Message with ID: ' . $message->getId() . ' sent.';
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
    var_dump(fgets(STDIN)); die;
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

}
