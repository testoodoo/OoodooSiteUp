<?php

define('STDIN',fopen("php://stdin","r"));
define('APPLICATION_NAME', 'Gmail API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/gmail-php-quickstart.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
define('SCOPES', implode(' ', array(
  Google_Service_Gmail::MAIL_GOOGLE_COM)
));

class ApiController extends \BaseController {



	public function update() {
		$client = $this->getClient();
		$service = new Google_Service_Gmail($client);
		$userId='me';
		$list = $service->users_messages->listUsersMessages($userId,['maxResults' => 1000]);
		$messageList = $list->getMessages();

		foreach($messageList as $message){
			$optParamsGet2['format'] = 'full';
			$single_message = $service->users_messages->get('me',$message->id, $optParamsGet2);			
			$this->updateMail($single_message);
		}


		var_dump(count($messageList)); die;
	}

	public function updateMail($single_message){


		$client = $this->getClient();
		$service = new Google_Service_Gmail($client);
		$userId='me';

        $messageId = $single_message->getId();
        $threadId = $single_message->getThreadId();
        $historyId = $single_message->getHistoryId();
        $labelIds = $single_message->getLabelIds();

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

        $body = $single_message->getPayload()->getBody();
        $body_new = $this->decode_body($body['data']);
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
                //var_dump($attId); die;
                $file_location = public_path().'/assets/dist/support/attach/'.$filename;

                #var_dump($file_ext); die;
                file_put_contents($file_location, $code_binary);
                #echo "Your attachment ". $filename." with id ".$attId." saved succesfully at ".$file_location;
                $attachment[] = array(
                'filename' => $filename,
                'attachmentId' => $attId,
                'filelocation' => $file_location
                );
/*                $image= imagecreatefromstring($code_binary);
                header('Content-Type: image/jpeg');
                imagejpeg($image);
                imagedestroy($image);*/
            }
        }                
                var_dump($attachment); die;

	}


	public function getClient() {
		$client = new Google_Client();
		$client->setApplicationName(APPLICATION_NAME);
		$client->setScopes(SCOPES);
		$client->setAuthConfigFile(CLIENT_SECRET_PATH);
		$client->setAccessType('offline');

		$credentialsPath = $this->	expandHomeDirectory(CREDENTIALS_PATH);
		if (file_exists($credentialsPath)) {
			$accessToken = file_get_contents($credentialsPath);
		} else {
			$authUrl = $client->createAuthUrl();
			printf("Open the following link in your browser:\n%s\n", $authUrl);
			print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));
			$accessToken = $client->authenticate($authCode);
			if(!file_exists(dirname($credentialsPath))) {
				mkdir(dirname($credentialsPath), 0700, true);
			}
			file_put_contents($credentialsPath, $accessToken);
			printf("Credentials saved to %s\n", $credentialsPath);
		}
		$client->setAccessToken($accessToken);
		if ($client->isAccessTokenExpired()) {
			$client->getRefreshToken();
			file_put_contents($credentialsPath, $client->getAccessToken());
		}
		return $client;
	}

	public function expandHomeDirectory($path) {
	  $homeDirectory = getenv('HOME');
	  if (empty($homeDirectory)) {
	    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
	  }
	  return str_replace('~', realpath($homeDirectory), $path);
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


}



