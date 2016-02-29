<?php

/*
Architecture:


Interface:

markProjectImpossible($projectId)
Permission: Manager
Description: The manager can mark the project impossible. This will give an indication to the system that the project was indeed a hard and technical impossible project. However, the system won't take the manager's feedback for granted, and implement other ways to confirm this.

markProjectAbandonded($projectId)
Permission: Marketer
Description: The Marketer can mark the project abandoned by employer if the employer doesn't reply for over a threshold period of time. This is different from the system marking the project abandoned automatically with manager's approval after the employer doesn't respond for a threshold period of time and giving the employer several warnings.

markProjectIncomplete($projectId)
Permission: Marketer
Description: Marketer can mark a project incomplete by the manager. This is different from the employer cancelling or abandoning the project.

markProjectComplete($projectId)
Permission: Employer
Description: Employer can mark the project complete after the entire payment is done. This is different from the system automatically marking the project complete.

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