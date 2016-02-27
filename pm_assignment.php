<?php
/* 
TODO:
function for calculating the satisfaction rating 
function for calculating the total rating
function for calculating the total rating on past 30 projects
function for calculating the rating reliability
function for calculating the project success probability based on ratings and other factors 
function for assigning the Coder for each project based on their preference and ratings 

function for calculating at what threshold to cut off the pay of the coder on project.. 

function for scheduling the tasks for the Coder manager and marketer..


function for retrieving the undelivered msgs to client 
*/



/*
Interface:
autoassignProjectToCoder($projectId)
assignProjectToCoder($projectId,$coderEmail)




requestReassignToCoder($projectId)
Permission: Employer only.
Description: 

reassignToNewCoder($projectId,$newCoderEmail)
Permission: Manager only.
Description: If only 1 coder is hired for the project, that coder will be removed from the project, and the new coder will be hired.

reassignToNewCoder($projectId,$coderEmail,$newCoderEmail)
Permission: Manager Only.
Description: If 1 or more coders are hired for the project, a coder will be replaced by another coder.

reassignToNewManager($projectId,$managerEmail)
Permission: Employer of project
Description: Employer can reassign to a different manager the project.

reassignToNewManager($projectId)
Permission: Employer of project
Description: Employer can reassign to a new manager. This function will find an available manager automatically and assign him.

autoassignProjectToManager($projectId)
Permission: Employer of Project or Creator of Project (Employer, Marketer, Manager) 	
Description: Assigns the project to manager automatically. If the project is created by a manager, preference will be given to assign the same manager to the project. If he is not available, another manager will be assigned.

assignProjectToManager($projectId,$managerEmail);
Permission: Marketer, Employer, Manager
Description: <TODO>

assignProjectToCoder($projectId,$coderEmail)
Permission: Manager of the project only.
Description: If the coder put an interest in the project, the project will be assigned without permission from coder. If the coder didn't put an interest, he will be awarded the project which he may or may not accept. In either case, it will happen only if he is available, else it will give an error and manager will be notified.



*/ 



function getBestAvailableManager()
{
/*
Manager:
- Completion rate.. Eg. 78% .. total of 80 projects
- Client satisfaction rate.. 
	- Professionalism and Etiquettes.. Eg 80% .. total of 62 completed projects
	- Fast Communication
	- Found right coder
	- Good with details and Testing


First priority sort with completion rate
Second priority sort with Satisfaction rate 
*/
}

//gets the best available coder among the ones who showed interest in the project
function getBestAvailableCoder($projectId)
{
	
}

function reassignToNewCoder()
{
	
}

function reassignToNewManager()
{
	
}

function reassignToNewMarketer()
{
	
}


?>