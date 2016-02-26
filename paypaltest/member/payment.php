<?php

use PayPal\Api\Payer;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use Paypal\Exception\PayPalConnectionException;

require '../src/start.php';

$payer=new Payer();
$details=new Details();
$amount=new Amount();
$transaction=new Transaction();
$payment=new Payment();
$redirectUrls=new RedirectUrls();

$payer->setPaymentMethod('paypal');
$details->setShipping('2.00')
	->setTax('0.00')
	->setSubtotal('20.00');
$amount->setCurrency('GBP')
	->setTotal('22.00')
	->setDetails($details);
$transaction->setAmount($amount)
	->setDescription('Membership');
$payment->setIntent('sale')
	->setPayer($payer)
	->setTransactions([$transaction]);
$redirectUrls->setReturnUrl('http://localhost:8080/projectmanagement/paypaltest/paypal/pay.php?approved=true')
	->setCancelUrl('http://localhost:8080/projectmanagement/paypaltest/paypal/pay.php?approved=false');
$payment->setRedirectUrls($redirectUrls);

try
{
	$payment->create($api); //Call to paypal. Paypal will return useful information and token.
	
	$hash=md5($payment->getId());
	$_SESSION['paypal_hash']=$hash;
	$r=$db->query("insert into temp_transactions(user_id,payment_id,hash,complete) values ({$_SESSION['user_id']},'{$payment->getId()}','$hash',0)");
	
}
catch(PayPalConnectionException $e)
{
	//Perhaps log an error
	header('Location: ../paypal/error.php');
}

var_dump($payment->getLinks());

foreach($payment->getLinks() as $link)
{
	if($link->getRel()=='approval_url')
	{
		$redirectUrl=$link->getHref();
		break;
	}
}

var_dump($redirectUrl);
header("Location: ".$redirectUrl);

?>