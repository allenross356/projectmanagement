<?php
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Paypal\Exception\PayPalConnectionException;
require '../src/start.php';
if(isset($_GET['approved']))
{
	$approved=$_GET['approved']==='true';
	if($approved)
	{
		try
		{
			$payerId=$_GET['PayerID'];
			$r=$db->query("select payment_id from temp_transactions where hash='{$_SESSION['paypal_hash']}'");
			$row=$r->fetch_array();
			$paymentId=$row['payment_id'];
			$payment=Payment::get($paymentId,$api);
			$execution=new PaymentExecution();
			$execution->setPayerId($payerId);
			$payment->execute($execution,$api);	//Charge the user finally.			
		}
		catch(PayPalConnectionException $e)
		{
			header('Location: ../paypal/error.php');
			die();
		}
		
		$r=$db->query("update temp_transactions set complete=1 where payment_id='$paymentId'");
		$r=$db->query("update temp_users set member=1 where id={$_SESSION['user_id']}");
		unset($_SESSION['paypal_hash']);
		header('Location: ../member/complete.php');
	}
	else
	{
		header('Location: ../paypal/canceled.php');
	}
}
?>