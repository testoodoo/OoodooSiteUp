<?php
class Api  {

	public function jcloud_login() {

		$Jaze_MainUrl = "https://nas.oodoo.co.in:8000/";

		$username='nas@oodoo.co.in';
		$password='H#ll0123';
		$loginUrl =$Jaze_MainUrl.'login/login_post';
		 
		//init curl
		$ch = curl_init();
		 
		//Set the URL to work with
		curl_setopt($ch, CURLOPT_URL, $loginUrl);

		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);

		// ENABLE HTTP POST
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Set the post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'username='.$username.'&password='.$password);

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		 //Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		 
		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.
		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 
		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		//var_dump($store);	

		$result = json_decode($store, true);
		//var_dump($result);	

		 if ( $result['status'] == 'success' ) {
				return $ch;
			} else {
				return False;
			}
	}


	public static function japi_add_users($jplan_code,$account_id,$password,$userState,$activationDate,$expirationDate)
	{
		//var_dump($jplan_code,$account_id,$password,$userState,$activationDate,$expirationDate);die;
		ini_set('max_execution_time', 3000);
		$Jaze_MainUrl = "https://nas.oodoo.co.in:8000/";
		$Jaze_ApiUrl = "api/v1/";
		$Jaze_UserName='oodoo';
		$Jaze_PassWord='24ecf83908129ef632daccf1150019c2de4895da';

		$AddAccountUrl = $Jaze_MainUrl.$Jaze_ApiUrl.'add_user';
		//echo $AddAccountUrl;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $AddAccountUrl );

		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		 
		curl_setopt($ch, CURLOPT_USERPWD, $Jaze_UserName. ":" . $Jaze_PassWord );

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		// ENABLE HTTP POST
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Set the post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'userGroupId='.$jplan_code.'&userName='.$account_id.'&password='.$password.'&userState='.$userState.'&activationDate=custom&expirationDate=custom&customActivationDate='.$activationDate.'&customExpirationDate='.$expirationDate);
		 
		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.
		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 

		//var_dump($store);

		return $store;


	}

	public static function japi_account_activation($jaccount_no,$userState,$activationDate,$expirationDate)
	{


		ini_set('max_execution_time', 3000);
		$Jaze_MainUrl = "https://nas.oodoo.co.in:8000/";
		$Jaze_ApiUrl = "api/v1/";
		$Jaze_UserName='oodoo';
		$Jaze_PassWord='24ecf83908129ef632daccf1150019c2de4895da';

		$ActivateUrl = $Jaze_MainUrl.$Jaze_ApiUrl.'add_user';
		//echo $AddAccountUrl;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $ActivateUrl );

		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		 
		curl_setopt($ch, CURLOPT_USERPWD,$Jaze_UserName. ":" .$Jaze_PassWord);

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		// ENABLE HTTP POST
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Set the post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'userId='.$jaccount_no.'&userState='.$userState.'&activationDate=custom&customActivationDate='.$activationDate.'&expirationDate=custom&customExpirationDate='.$expirationDate);
		 
		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.
		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 

		//var_dump($store);

		return $store;

	}


public static function japi_password_reset($jaccount_no,$password)
	{


		ini_set('max_execution_time', 3000);
		$Jaze_MainUrl = "https://nas.oodoo.co.in:8000/";
		$Jaze_ApiUrl = "api/v1/";
		$Jaze_UserName='oodoo';
		$Jaze_PassWord='24ecf83908129ef632daccf1150019c2de4895da';

		$ActivateUrl = $Jaze_MainUrl.$Jaze_ApiUrl.'add_user';
		//echo $AddAccountUrl;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $ActivateUrl );

		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		 
		curl_setopt($ch, CURLOPT_USERPWD,$Jaze_UserName. ":" .$Jaze_PassWord);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		// ENABLE HTTP POST
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Set the post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'userId='.$jaccount_no.'&password='.$password);
		 
		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.
		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 

		//var_dump($store);

		return $store;


	}

	function japi_plan_change($jaccount_no,$userGroupId)
	{

		$PlanChangeUrl = $GLOBALS['Jaze_MainUrl'].$GLOBALS['Jaze_ApiUrl'].'add_user';
		//echo $AddAccountUrl;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $PlanChangeUrl );

		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		 
		curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS['Jaze_UserName'] . ":" . $GLOBALS['Jaze_PassWord'] );

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		// ENABLE HTTP POST
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Set the post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'userId='.$jaccount_no.'&userGroupId='.$userGroupId);
		 
		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.
		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 

		//var_dump($store);

		return $store;


	}


	function japi_add_fup($jaccount_id,$fup_bytes)
	{

		$AddFUPUrl = $GLOBALS['Jaze_MainUrl'].$GLOBALS['Jaze_ApiUrl'].'add_fup_quota';
		//echo $AddAccountUrl;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $AddFUPUrl );

		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		 
		curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS['Jaze_UserName'] . ":" . $GLOBALS['Jaze_PassWord'] );

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		// ENABLE HTTP POST
		curl_setopt($ch, CURLOPT_POST, 1);
		 
		//Set the post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'userId='.$jaccount_id.'&quota='.$fup_bytes);
		 
		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.

		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		//var_dump($store);die;

		return $store;

	}

	function japi_get_all()
	{

		$GetAll = $GLOBALS['Jaze_MainUrl'].$GLOBALS['Jaze_ApiUrl'].'get_all';
		//echo $AddAccountUrl;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $GetAll );

		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		 
		curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS['Jaze_UserName'] . ":" . $GLOBALS['Jaze_PassWord'] );

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.

		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		//var_dump($store);die;

		return $store;

	}

	function japi_active_sessions()
	{

		$ch = jcloud_login();

		if ( $ch != False ) {

		$Active_Session = $GLOBALS['Jaze_MainUrl'].'monitoring/active_sessions_data';
		//echo $Active_Session."<br>";

		curl_setopt($ch, CURLOPT_URL, $Active_Session );
		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);

		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.

		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 

		return $store;
		}else{

			echo "J Cloud login Failed";
		}

	}

	public static function japi_user_logs($jaccount_no, $idisplaystart=0, $idisplaylength=10)
	{
		$Jaze_MainUrl = "https://nas.oodoo.co.in:8000/";

		$api=new Api;

		$ch = $api->jcloud_login();

		if ( $ch != False ) {

		$User_Logs = $Jaze_MainUrl.'users/logs_data/'.$jaccount_no.'?iDisplayStart='.$idisplaystart.'&iDisplayLength='.$idisplaylength.'&iSortCol_0=0&sSortDir_0=desc&iSortingCols=1&bSortable_0=true';
		//echo $User_Logs;
		//echo $Active_Session."<br>";

		curl_setopt($ch, CURLOPT_URL, $User_Logs );
		// ENABLE HEADER Print
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		
		 //SET ingnore SSL verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		//Set CAINFO Certicates path
		curl_setopt ($ch, CURLOPT_CAINFO, "/var/www/japi/ca-bundle.pem");

		//Handle cookies for the login
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.

		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request (the login)
		$store = curl_exec($ch);

		//echo curl_getinfo($ch, CURLINFO_HTTP_CODE); 

		return $store;
		}else{

			echo "J Cloud login Failed";
		}

	}
}
?>