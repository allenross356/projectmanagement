<?php

	use PayPal\Rest\ApiContext;
	use PayPal\Auth\OAuthTokenCredential;

	$isTest=false;
	
	session_start();
	$_SESSION['user_id']=1;
	
	require __DIR__ . "/../vendor/autoload.php";
	
	//API
	if($isTest)		//Sandbox
	{
		$api=new ApiContext(new OAuthTokenCredential("AWr41RzBbHQGgl07nlV6hYtvXpmcDX863zzbOb7j2KWInsWS1Zo9m00VUBClAH7CVjmMseegvvJfzDnQ","EOsCGvWCyrF8qBwxPLyFZuYHO06T8ZhHJgLlJnuuZjoGrO4koudLEquno0KbYRUzJoe2HHvVpPp8Mjr4"));				
		$api->setConfig(['mode'=>'sandbox','http.ConnectionTimeOut'=>30,'log.LogEnabled'=>false,'log.FileName'=>'','log.LogLevel'=>'FINE','validation.level'=>'log']);
	}
	else			//Live
	{
		$api=new ApiContext(new OAuthTokenCredential("AQ2PE3wnoXrCQojq9ydjBWmqEIWeEyb9O98-GtxgDCVm6qR5XcKtc7yX9k04nh6ds4PXrhTEq7RoNXod","EEVzv4ES0OGESBQEX9juKaICcL476S-5zcdM_SXXO-ayA5Hj0ZtrsKygPBadcai_Gvk6PYY_9dNP-tdL"));		
		$api->setConfig(['mode'=>'live','http.ConnectionTimeOut'=>30,'log.LogEnabled'=>false,'log.FileName'=>'','log.LogLevel'=>'FINE','validation.level'=>'log']);
	}
		
	$db = new mysqli("localhost", "root", "", "projectmanagement"); 
	$r=$db->query("select * from temp_users where id={$_SESSION['user_id']}");
	$user=$r->fetch_array();
?>