<?php

/*
Purpose: 
Functions related to the authentication and registration of the users.
*/

session_start();

include_once "pm_common.php";

//public functions -> that can be accessed by functions in other files as well as within the same file.
//private functions -> that can be accessed by functions within the same files only.


/*public bool*/ function doesUserExist(/*string*/ $email)	
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$q="select u_name from pm_users where u_email='$email'";	//<TODO Make query injection proof>
	$r=$g->query($q);
	if($r)
	{
		if($r->num_rows==0)
			return false;	
		elseif($r->num_rows==1)
			return true;
		else
			return more_than_1_rows_error_code();	 
	}
	else
		return query_error_code();	//<TODO> confirm if it won't return error string when num_rows=0
}

/*public bool*/ function authenticateUser(/*string*/ $email,/*string*/ $pass,/*bool*/ $doLoginIfVerified=false)	//Used for logging the user in as well
{
	$doLoginIfVerified=fixParam($doLoginIfVerified);

	//pass=crypt($pass,"st");	<TODO>
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$q="select u_name from pm_users where u_email='$email' and u_pass='$pass'";	//<TODO Make query injection proof>
	$r=$g->query($q); 
	
	if($r)		//<TODO> confirm thru experimentation that query return false everytime on failure and true everytime on success
	{
		if($r->num_rows>1)
			return more_than_1_rows_error_code();
		elseif($r->num_rows==1)
		{
			if($doLoginIfVerified==true) $_SESSION['email']=$email;
			return true;
		}
		else 
			return false;
	}
	else
		return query_error_code();
}

/*public bool*/ function registerUser(/*string*/ $name,/*string*/ $email,/*string*/ $pass,/*int*/ $type,/*bool*/ $setSession) //<TODO> update parameters later
{
	$setSession=fixParam($setSession);
	
	$r=doesEmailExist($email,true);
	if(isSqlError($r)==true)
		 return $r;
	elseif($r==true)
		return user_already_exists_error_code(); 	
	
	//$pass=crypt($pass,"st");		<TODO>
	
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=insertValues("pm_users",Array("u_name"=>"'$name'","u_email"=>"'$email'","u_pass"=>"'$pass'","u_type"=>"$type","u_oamount"=>"'0'","u_pamount"=>"'0'","u_ramount"=>"'0'"));	//<TODO Make query injection-proof> 	//<TODO> update/add more parameters later
	
	if($r)		
	{
		if($setSession==true)
			$_SESSION['email']=$email;
		return true;
	}
	else
		return query_error_code();	
}

/*public bool*/ function loginUser(/*string*/ $email,/*string*/ $pass)
{
	return authenticateUser($email,$pass,true);
}

/*public*/ function logout()
{
	if(isset($_SESSION["email"]))
	{
		unset($_SESSION["email"]);
		return true;
	}
	else return false;
}

/*public Array(name,email,type)*/ function fetchUserInfo(/*string*/ $uEmail)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$q="select u_name,u_email,u_type from pm_users where u_email='$uEmail'";	 	//<TODO> update more parameters later
	$r=$g->query($q);
	if($r)
	{
		if($r->num_rows>1)
			return more_than_1_rows_error_code();
		elseif($row=$r->fetch_array())
			return Array("name"=>$row[0],"email"=$row[1],"type"=>$row[2]);
		else 
			return no_rows_error_code();		
	}
	else
		return query_error_code();
}

/*public Array(name,email,type)*/ function fetchLoggedInUserInfo()
{
	return fetchUserInfo($_SESSION['email']);
}

/*public int*/ function getUserType(/*string*/ $uEmail)
{	//0=Employer	1=Marketer	2=Manager	3=Coder
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$q="select u_type from pm_users where u_email='$uEmail'";
	$r=$g->query($q);
	if($r)
	{
		if($r->num_rows>1)
			return more_than_1_rows_error_code();
		elseif($row=$r->fetch_array())	 
			return $row["u_type"];	
		else	 
			return no_rows_error_code();	//No matching user.
	}
	else
		return query_error_code();
}

/*public int*/ function getLoggedInUserType()
{
	return getUserType($_SESSION['email']);
}

/*public int*/ function fetchUserMonthlyWithdrawalLimit(/*string*/ $uEmail) 
{
	$uType=getUserType($uEmail); if(isSqlError($uType)) return $uType;	
	switch($uType)
	{
		case "0":
			return "0";							//<TODO> revise
			break;
		case "1":
			$r=fetchVar("maxPerMonthWithdrawalLimitForMarketer");			
			break;
		case "2":
			$r=fetchVar("maxPerMonthWithdrawalLimitForManager");			
			break;
		case "3":
			$r=fetchVar("maxPerMonthWithdrawalLimitForCoder");			
			break;
		case "4":								//<TODO> revise
			$r=fetchVar("maxPerMonthWithdrawalLimitForAffiliate");			
			break;
		case default:
			return abnormal_error_code();
	}
	//<TODO> revise if(isSqlError($r))
	return $r;	
}

/*public int*/ function fetchLoggedInUserMonthlyWithdrawalLimit()
{
	return fetchUserMonthlyWithdrawalLimit($_SESSION['email']);
}




?>