<?php
//<TODO> Make sure that no other MySQL functions return error codes extracted from pm_projects table or any other tables.

function db_error_code()
{
	return "error_db";
}

function query_error_code()
{
	return "error_query";
}

function no_rows_error_code()
{
	return "error_no_rows";
}

function more_than_1_rows_error_code()
{
	return "error_more_than_1_rows";
}

function limit_exceeded_error_code()
{
	return "error_limit_exceeded";
}

function user_already_exists_error_code()
{
	return "error_user_already_exists";
}

function abnormal_error_code()
{
	return "error_abnormal";
}

function isSqlError($v)
{
	if($v==db_error_code() || $v==query_error_code() || $v==no_rows_error_code() || $v==more_than_1_rows_error_code() || $v==limit_exceeded_error_code()) return true;
	if($v==user_already_exists_error_code() || $v==abnormal_error_code()) return true;
	else return false;
}
?>