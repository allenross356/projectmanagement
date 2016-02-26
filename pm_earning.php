<?php
include_once "pm_session.php";
include_once "pm_math.php";


//<TODO> remove n and d, and implement simple calculations using bc on text and with precision of 20-30
//<TODO> increase referralThreshold automatically with time based on inflation.

//<TODO> implement feature to turn off referrals

//<TODO> put semaphore.
//<TODO> rollback transactions if they fail in middle
//<TODO> Implement the feature to add all transactions to database.
//<TODO> Make sure the get_dbconnection is called in functions only where query is executed.
//<TODO> Add at_from field in pm_accounttransactions table.

//<TODO> When next referral wtihdrawal payment is more than project's earning, then don't pay project's earning to coder at all, and distribute the 20% of his referral withdrawal to the tree upwards, and distribute the full project's earning to manager, marketer, and company.

//<TODO> Implement the design so that the referral system could be switched off anytime easily.

//<TODO> Make sure the referral amount payable for each project is deducted right away from the employee's referral account when the employee is assigned the award. This is to ensure that the correct amount of payable referrals is calculated on future projects. If a project is canceled by the employer after its assigned to employees, the manager will decide whether coder should receive the money for the work, or whether the payable referrals should go back to his referral account.

//<TODO> Remove pm_math.php, and implement calculations using bcscale(100);

//<TODO> Implement error handling so that if the error occurs between a series of transactions, the entire series should be undone before exiting.

/*
Purpose:
Functions related to all the payments on projects and funds transfer.
*/

/*
Interface:
double maxAmountWithdrawable(string $uEmail)	//Gets maximum amount a user can withdraw from his account.
bool canWithdraw(string $uEmail,double $amount)	//Can a user withdraw x amount from his account?
double getOAmount(string $uEmail)				//Gets Own Amount.
double getPAmount(string $uEmail)				//Gets amount earned from projects and referrals.
double getRAmount(string $uEmail)				//Gets amount in referrals account which is not withdrawable yet.
bool canMakePayment($uEmail,$projectId,$amount)	//Can an employer make a payment of x amount on a y project? <TODO>
<TODO>Revise repeat function from pm_milestone.php 		bool makePayment($uEmail,$projectId,$amount)	//Employer makes payment on a project. <TODO>
<TODO>Revise repeat function from pm_milestone.php		bool releaseMilestone($milestone)				//Employer releases a milestone of a project. <TODO>
bool taskCompleted($uEmail,$taskType,$taskId)	//Distributes the referrals amount in the tree. <TODO>



getAdjustedEarningsFromProject($projectId)
Permission: Coder, Manager, Marketer.
Description: Gets the adjusted project income as well as referral income from the project for whoever calls this function.

projectCompleted($projectId)
Permission: Employer only.
Description: Marks the project complete if the project is fully paid, and distributes the earnings to coder, manager, marketer etc.

referralCompleted($uEmail)
Permission: Employer, Manager, Marketer, Coder
Description: Whenever someone makes a payment or earnings for the first time, his referree's referral is considered completed, and he gets some kind of P or R payment.

remoteMeetingCompleted($uEmail)
Permission: Manager, Marketer
Description: Whenever a remote viewing session is over and the report is turned in by both parties (employer, and the invigilator), the invigilator gets some kind of P or R payment.

disputeInvigilationCompleted()
Permission: Manager, Marketer
Description: Whenever a dispute is invigilated and resolved by making a decision by the invigilator, the invigilator gets some kind of P or R payment.

onlineCustomerServiceTaskCompleted($uEmail)
Permission: Manager, Marketer
Description: Whenever a new incoming client is helped by getting his questions answered by one of the employees, the employee gets some kind of P or R payment. The service may require him to answer the client's questions on how to use the platform, or what the cost will be for his requirements, or any other platform.

trainingTaskCompleted($uEmail)
Permission: Marketer, Manager, Coder
Description: Whenever a project is completed or cancelled and at least one question was asked by the coder/manager/marketer involved from the trainer(s), then the trainer(s) get(s) some kind of P or R payment.

specialTaskCompleted($uEmail)
Permission: 
Description:

*/



bcscale(100);	//<TODO> Revise the 100. Should I reduce to 50?


/*private RealNumber or double*/ function getHelperHelper(/*string*/ $uEmail,/*string*/ $tableName,/*string*/ $field,/*string*/ $condition=null) //private
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();	
	if($condition==null)
		$r=$g->query("select $field from $tableName where u_email='$uEmail'");
	else
		$r=$g->query("select $field from $tableName where u_email='$uEmail' and $condition");		
	if($r)
	{
		if($r->num_rows>1)
			return more_than_1_rows_error_code();
		elseif($row=$r->fetch_array())
			return $row[$field];
		else	 
			return no_rows_error_code();
	}
	else
		return query_error_code();	
}

function getEarningHelper($uEmail,$projectId,$field)
{
	return getHelperHelper($uEmail,"pm_projectsuserroles",$field,"p_id=$projectId");
}

/*private RealNumber or double*/ function getAmountHelper(/*string*/ $uEmail,/*string*/ $field) //private
{
/*
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();	
	$r=$g->query("select $field from pm_users where u_email='$uEmail'");
	if($r)
	{
		if($r->num_rows>1)
			return more_than_1_rows_error_code();
		elseif($row=$r->fetch_array())
		{
			return $row[$field];
		}
		else	 
			return no_rows_error_code();
	}
	else
		return query_error_code();	
*/
	return getHelperHelper($uEmail,"pm_users",$field);
}

/*private*/ function addAmountHelper(/*string*/ $uEmail,/*int*/ $amount,/*string*/ $field)  
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	//<TODO>Put mysql table semwait() A if projectamount, B if referralamount;
	$n=getAmountHelper($uEmail,$field); if(isSqlError($n)) return $n;
	$n=bcadd($n,$amount);
	$r=$g->query("update pm_users set $field='$n' where u_email='$uEmail'");
	//<TODO>Put mysql table semrelease() A, B if referralamount;
	if($r)
	{
		if($g->affected_rows==0)
			return no_rows_error_code();
		elseif($g->affected_rows==1)
			return true;
		else
			return more_than_1_rows_error_code();
	}
	else
		return query_error_code();	
}

/*private*/ function setZeroAmountHelper(/*string*/ $uEmail,/*string*/ $field)  
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=$g->query("update pm_users set $field='0' where u_email='$uEmail'";
	if($r)
	{
		if($g->affected_rows==0)
			return no_rows_error_code();
		elseif($g->affected_rows==1)			//<TODO> what if more than 1 rows
			return true;
		else
			return more_than_1_rows_error_code();
	}
	else
		return query_error_code();
}

//************************************ Own Amount START ************************************
//returns totalamount in dollars
/*public*/ function getOAmount(/*string*/ $uEmail) //public
{
	return getAmountHelper($uEmail,"u_oamount");
}

//assumption $amount is in dollars.
/*private*/ function addOAmount(/*string*/ $uEmail,/*double string*/ $amount)  
{
	return addAmountHelper($uEmail,$amount,"u_oamount");	
}

//assumption $amount is in dollars.
/*private*/ function subtractOAmount($uEmail,$amount) 
{
	return addOAmount($uEmail,bcmul($amount,"-1"));
}

/*private*/ function setZeroOAmount($uEmail) 
{
	return setZeroAmountHelper($uEmail,"u_oamount");
}
//************************************ Own Amount END ************************************

//************************************ Projects Amount START ************************************
//returns totalamount in dollars
/*public*/ function getPAmount($uEmail) //public
{
	return getAmountHelper($uEmail,"u_pamount");
}

//assumption $amount is in dollars.
/*private*/ function addPAmount($uEmail,$amount)  	 
{
	return addAmountHelper($uEmail,$amount,"u_pamount");	
}

//assumption $amount is in dollars.
/*private*/ function subtractPAmount($uEmail,$amount)  
{
	return addPAmount($uEmail,bcmul($amount,"-1"));
}

/*private*/ function setZeroPAmount($uEmail)  
{
	return setZeroAmountHelper($uEmail,"u_pamount");
}
//************************************ Projects Amount END ************************************

//************************************ Referral Amount START ************************************
//returns totalamount in dollars
/*public*/ function getRAmount($uEmail) //public
{
	return getAmountHelper($uEmail,"u_ramount");
}

//assumption $amount is in dollars.
/*private*/ function addRAmount($uEmail,$amount)  
{
	return addAmountHelper($uEmail,$amount,"u_ramount");	
}

//assumption $amount is in dollars.
/*private*/ function subtractRAmount($uEmail,$amount) 
{
	return addRAmount($uEmail,bcmul($amount,"-1"));
}

/*private*/ function setZeroRAmount($uEmail) 
{
	return setZeroAmountHelper($uEmail,"u_ramount");
}
//************************************ Referral Amount END ************************************

//************************************ Earning from Project START ************************************
//get Original earning
function getOEarning($uEmail,$projectId)
{
	return getEarningHelper($uEmail,$projectId,"pur_oearning");
}

//get Adjusted earning
function getPEarning($uEmail,$projectId)
{
	return getEarningHelper($uEmail,$projectId,"pur_pearning");	
}

//get Referral earning
function getREarning($uEmail,$projectId)
{
	return getEarningHelper($uEmail,$projectId,"pur_rearning");	
}

//get Amount earned so far
function getEarning($uEmail,$projectId)
{
	return getEarningHelper($uEmail,$projectId,"pur_earning");	
}
//************************************ Earning from Project END ************************************

//************************************ Payment Distribution START ************************************
/*private*/ function getParent($uEmail) //private 
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=$g->query("select u_referralemail from pm_users where u_email='$uEmail'");
	if($r)
	{
		if($r->num_rows>1)
			return more_than_1_rows_error_code();
		elseif($row=$r->fetch_array())
			return $row['u_referralemail'];
		else		 
			return no_rows_error_code();
	}
	else
		return query_error_code();
}

/*private*/ function distributeAmount($uEmail,$amount) //private
{
	addRAmount($uEmail,$amount);
	$uEmail=getParent($uEmail); 
	if($uEmail==no_rows_error_code()) 
		return true; 
	elseif(isSqlError($uEmail)) 
		return $uEmail; //<TODO> Implement better way to handle the query_error here. Undone the operation before exiting.
	return distributeAmount($uEmail,bcdiv($amount,2)); //<TODO> Confirm if the recursion stack won't go out of memory.
}

//called when to pay amount or milestones on a project
//adds the amount in receiver's account.. but doesn't subtract from the sender's account 
//deals only with the user accounts and doesn't update the pm_projectsuserroles table yet <TODO>
/*private*/ function payPAmount($uEmail,$amount)
{
	$r=fetchVal("referralPercentage"); if(isSqlError($r)) return $r;
	$fee=bcdiv(bcmul($r,$amount),100);
	$fee2=bcmul($fee,2);
	$s=addPAmount($email,bcsub($amount,$fee2)); if(isSqlError($s)) return $s;  //<TODO> Implement better way to handle the query_error here. Undone the operation before exiting.
	$s=distributeAmount($uEmail,$fee); if(isSqlError($s)) return $s; //<TODO> Implement better way to handle the query_error here. Undone the operation before exiting.
	return true;
}

//<TODO> Check if earning after paying this $amount is not greater than $oEarning, if it is, then update the table

//<TODO> Update the payments in pm_projectsuserroles table as well.

//only updates the pm_projectsuserroles table
/*private*/ function adjustEarning()
{
	
}


/*private*/ function payRemainingReferralReward($uEmail,$projectId=null)	//
{
	if($projectId==null)
	{
		$r=fetchVal("referralWithdrawablePercentage"); if(isSqlError($r)) return $r; 
		$ramount=getRAmount($uEmail); if(isSqlError($ramount)) return $ramount; //<TODO> Implement better way to handle the query_error here. Undone the operation before exiting.
		$amount=bcdiv(bcmul($rAmount,$r),100);
		subtractRAmount($uEmail,$amount);
		$s=addPAmount($uEmail,$amount);	if(isSqlError($s)) return $s;
	}
	else
	{ 
		$earning=getEarning($uEmail,$projectId); if(isSqlError($earning)) return $earning;
		$pEarning=getPEarning($uEmail,$projectId); if(isSqlError($pEarning)) return $pEarning;
		$rEarning=getREarning($uEmail,$projectId); if(isSqlError($rEarning)) return $rEarning;
		$s=addPAmount($uEmail,$pEarning+$rEarning-$earning); if(isSqlError($s)) return $s;		 
	}
}




//called when a task (project or other task) finishes 
//subtract from the referral earnings account and adds to the project earnings account.
/*private*/ function payReferralReward($uEmail,$amount,$distributeUpwards=true)  
{
	
	$c=$amount;
	$e=func1_get_y_z($c);
	subtractRAmount();
	
	if(bccomp($threshold,$ramount,2)<0)
	{	//$rPay=$threshold+($ramount-$threshold)*$ratio2/100;
		$rPay=bcadd($threshold,bcdiv(bcmul(bcsub($ramount,$threshold,2),$ratio2,2),100,2),2);
		if(bccomp(bcadd($rPay,"1",2),$ramount,2)>=0)
		{
			$rPay=$ramount;
			$r=setZeroRAmount($uEmail); if(isSqlError($r)) return $r;			
		}
		else
			$r=subtractRAmount($uEmail,bcmul($rPay,"100",2),"100"); if(isSqlError($r)) return $r;
	}
	else
	{
		$rPay=$threshold;
		$r=setZeroRAmount($uEmail); if(isSqlError($r)) return $r;
	}
	if($distributeUpwards)
		$r=payPAmount($uEmail,$rPay);
	else
		$r=addPAmount($uEmail,bcmul($rPay,"100",2),"100");
	if(isSqlError($r)) return $r; //<TODO> Implement better way to handle the query_error here. Undone the operation before exiting.
	return true;
}
//************************************ Payment Distribution END ************************************




//************************************ Withdrawal Rules START ************************************
/*private*/ function fetchAmountWithdrawn($uEmail,$inPastXDays=30) 
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();	
	$r=$g->query("select * from pm_accounttransactions where u_email='$uEmail' and at_accounttype=1 and at_transactiontype=1 (at_datetime between now()-interval $inPastXDays day and now())"); //<TODO> Confirm if the query works as intended.
	if($r)
	{
		$amt="0";
		while($row=$r->fetch_array())
			$amt=bcadd($amt,$row['at_amount']);			
		return $amt;
	}
	else
		return query_error_code();
}

/*public*/ function canWithdraw($uEmail,$amount) 
{	
	$maxAmt=maxAmountWithdrawable($uEmail);
	if(bccomp($maxAmt,$amount)>0) return false;
	return true;

/*		//MORE EFFICIENT
	$oamount=getOAmount($uEmail); if(isSqlError($oamount)) return $oamount;
	if(bccomp($oamount,$amount,2)>=0) return true;
	$amount=bcsub($amount,$oamount);
	$pamount=getPAmount($uEmail); if(isSqlError($pamount)) return $pamount;
	if(bccomp($pamount,$amount)<0) return false;
	$amtWithdrawn=fetchAmountWithdrawn($uEmail); if(isSqlError($amt)) return $amt;
	$amtLimit=fetchUserMonthlyWithdrawalLimit($uEmail);
	if(bccomp(bcadd($amtWithdrawn,$amount,2),$amtLimit,2)>0) return false;
	return true;
*/
}

/*public*/ function maxAmountWithdrawable($uEmail) 
{
	$oamount=getOAmount($uEmail); if(isSqlError($oamount)) return $oamount;
	$pamount=getPAmount($uEmail); if(isSqlError($pamount)) return $pamount;
	$amtWithdrawn=fetchAmountWithdrawn($uEmail); if(isSqlError($amtWithdrawn)) return $amtWithdrawn;
	$amtLimit=fetchUserMonthlyWithdrawalLimit($uEmail); if(isSqlError($amtLimit)) return $amtLimit;
	return bcadd($oamount,bcmin($pamount,bcsub($amtLimit,$amtWithdrawn)));
}
//************************************ Withdrawal Rules END ************************************


function func1_get_y_z($c)
{
	$p=fetchVar("referralThresholdPercentage")/100;
	$q=fetchVar("referralWithdrawablePercentage")/100;
	$r=getR();	//getRAmount() 
	$k=(1.0-$p*$q-$p)/$q;
	if($r<=$p*$c)	//intersection: (c,pc)
	{
		$y=$p*$r;
		$z=$c;
	}
	elseif($r<=$c*$k)	//intersection: (ck,c)		where k=(1+pq-p)/q
	{
		$y=$p*$c+$q*($r-$p*$c);
		$z=$c;
	}
	elseif($r<=2*$c*$k)		//intersection: (2ck,2c(1+pq-p))
	{
		$y=$r*(1-2*$p*$q-2*$p)/$k+(1-$q)*2*$c*$p;
		$z=$c*(2-$r/$c/$k);
	}
	else	
	{
		$y=$r*$p;
		$z=0;
	}
}

function func2_get_c($projectId)
{
	
}

function amountToEarnOnProject()
{
	
}




/*public bool*/ bool canMakePayment($uEmail,$projectId,$amount)	//Can an employer make a payment of x amount on a y project? <TODO>
{
	//add amount from all milestones created on the project, as well as Own account and compare the 2 amounts.
}

/*public bool*/ function makePayment($uEmail,$projectId,$amount)
{
	//first check if the amount is withdrawable. Return false if it isn't.
	//first withdraw money from all or any milestones created for the project, then withdraw the remaining balance from the Own Account. 
	//update the fields in pm_projectsuserroles table as well as the pm_users table
	//Then return true.
}

/*public bool*/ function releaseMilestone($milestoneId)
{
	//release the milestone
}

/*public bool*/ function taskCompleted($uEmail,$taskType,$taskId)
{
	//$taskType = 0 (project), 1 (referral who made payment on a project or released milestone)
	//$taskId is projectId if taskType is 0.
	//Distribute the referral funds to the employee who completed the task as well as to the tree upwards.
}


?>