<?php

/*
Architecture:


Interface:

**************** PROJECT **************
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

employerRatesProject($projectId,$ratings)
Permission: Employer
Description: Employer gives ratings to everyone once the project in which he was directly involved is completed or cancelled.

coderRatesProject($projectId,$ratings)
Permission: Coder
Description: Coder gives ratings to everyone once the project in which he was directly involved is completed or cancelled.

managerRatesProject($projectId,$ratings)
Permission: Manager
Description: Manager gives ratings to everyone once the project in which he was directly involved is completed or cancelled.

marketerRatesProject($projectId,$ratings)
Permission: Marketer
Description: Marketer gives ratings to everyone once the project in which he was directly involved is completed or cancelled.



**************** REMOTE MEETING **************
invigilatorRatesMeeting($meetingId,$ratings)
Permission: Invigilator (Unrelated Marketer, Unrelated Manager)
Description: If the manager is absent during the meeting and the invigilator facilitates the meeting, then the 

**************** DISPUTE **************
invigilatorRatesDispute($disputeId,$ratings)
Permission: Invigilator (Unrelated Marketer, Unrelated Manager)
Description:

disputeParticipantRatesInvigilator($disputeId,$ratings)
Permission: Participants of Dispute (Manager, Employer, )
Description:

**************** TASK QUALITY **************
invigilatorRatesTaskQuality()
Permission:
Description:

**************** COMPLAINTS **************
invigilatorRatesComplaint
Permission:
Description:

**************** CUSTOMER SERVICE **************
invigilatorRatesComplaint
Permission:
Description:


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