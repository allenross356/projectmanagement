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