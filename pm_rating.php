<?php

/*
Architecture:


Interface:

markProjectImpossible($projectId)
Permission: Manager
Description: Once the project is completely paid off or cancelled by the employer, the manager can mark the project impossible. This will give an indication to the system that the project was indeed a hard and technical impossible project. However, the system won't take the manager's feedback for granted, and implement other ways to confirm this.

markProjectAbandonded($projectId)

*/

function employerRatesManager()
{
	
}

function employerRatesMarketer()
{
	
}

function employerRatesProject()
{
	
}

function employerRatesOverall()
{
	
}

function managerRatesCoder()
{
	
}

function managerRatesMarketer()
{
	
}

function managerRatesEmployer()
{
	
}

function coderRatesManager()
{
	
}

function coderRatesProject()
{
	
}

function marketerRatesManager()
{
	
}

function marketerRatesEmployer()
{
	
}

//<TODO> Admin can edit rating system
function getRatingsSystem()
{
	$response="[response=true,last_updated=2016/02/09 18:44:00,system=[employer=[],marketer=[],manager=[],coder=[]]]";	//<TODO>
}

function lastUpdationDateOfRatingsSystem()
{
	
}

?>