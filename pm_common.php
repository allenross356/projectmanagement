<?php

$gf_con=null;
$isDebugging=true;		//<TODO> Turn false before making live.

include_once 'pm_error.php';
include_once 'pm_defaultvalue.php';

function get_dbconnection()
{
	global $gf_con;
	if ($gf_con);else
	{
		$gf_con = new mysqli("localhost", "root", "", "projectmanagement"); 
	}
	//<TODO> REVISE
//	if ($gf_con->connect_error) 
//		throw new Exception("Database error.",1);
	return $gf_con; 
}

function getSpecialChar()
{
	$specialChar="-*#-(#";
	return $specialChar;
}

function fixParam($x)
{
	if($x==null || $x=="" || $x=="0") return false; else return true;
}

function fixRowsToFetch($numRows=0)
{
	$maxRows=fetchVar("maxRowsToFetch");
	if(isSqlError($maxRows)==true)
	{
		if(isTesting()) return $maxRows;
		$maxRows=maxRowsToFetch();
	}
	if($numRows==0) 
	{	
		$numRows=fetchVar("defaultRowsToFetch");
		if(isSqlError($numRows)==true) 
		{
			if(isTesting()) return $numRows;
			$numRows=defaultRowsToFetch();
		}
	}
	$numRows=intval($numRows);
	$maxRows=intval($maxRows);
	if($numRows>$maxRows) $numRows=$maxRows;	
	return $numRows;
}

function fixShortDescLength($numChars=0)
{
	if($numChars==0)
	{
		$numChars=fetchVar("defaultShortDescLength");
		if(isSqlError($numChars))
		{
			if(isTesting()) return $numChars;
			$numChars=defaultShortDescLength();
		}
	}
	$maxChars=fetchVar('maxShortDescLength');
	if(isSqlError($maxChars))
	{
		if(isTesting()) return $maxChars;
		$maxChars=maxShortDescLength();
	}
	$numChars=intval($numChars);
	$maxChars=intval($maxChars);
	if($numChars>$maxChars) $numChars=$maxChars;
	return $numChars
}

function insertValues($tableName,$fv)	//string $tableName, Array(key=>value) $fv
{	//<TODO> This function won't check the error occuring in db connection or query. The calling function must check itself.
	$g=get_dbconnection();
	$rf="";
	$rv="";
	foreach($fv as $f=>$v)
	{
		$rf.=",".$f;
		$rv.=",".$v;
	}	
	$q="insert into $tableName ($rf) values ($rv)";
	return $gf_con->query($q);
}

function fetchVar($variable)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=$g->query("select ev_value from pm_environmentvariables where ev_name='$variable'");
	if($r)
	{
		if($row=$r->fetch_array())
			return $row['ev_value'];
		else
			return no_rows_error_code();
	}
	else
		return query_error_code();
}

function swap(&$x,&$y) 
{
    $tmp=$x;
    $x=$y;
    $y=$tmp;
}

function isTesting()
{
	global isDebugging;
	return isDebugging;
}


?>