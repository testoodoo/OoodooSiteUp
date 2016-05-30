<?php


class ApiController extends \BaseController {

	public function update() {
		$client = $this->getClient();
		$service = new Google_Service_Gmail($client);
		$userId='me';
		$list = $service->users_messages->listUsersMessages($userId,['maxResults' => 1000]);
		$messageList = $list->getMessages();
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


}