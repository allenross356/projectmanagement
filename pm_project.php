<?php

//<TODO> Implement skills to the projects.

//<TODO> If coder puts interest in a project, and after that he creates a question, he should be displayed a warning/recommendation to remove his interest from the project until his question is answered.
//<TODO> Provide managers instructions to keep the discussion on each project clean as a part of his responsibility.

//<TODO> mark all private function with a starting underscore _ in order to avoid clashes between function names between different files


/*
Purpose:
Functions related to project and its life-cycle.
*/


/*
Architecture for Project's Life-Cycle:
1) Objects - 
	(i) Projects
	(ii) Milestones
	(iii) Questions
	(iv) Interest
	(iv) Messages
2) User Types - 
	(i) Coder
	(ii) Manager
	(iii) Marketer
	(iv) Employer
3) Actions -
	Open Project
	Create Project
	Archive Project
	Ask Questions
	Assign Project
	Reassign Project
	Invigilation of Messages or Questions
4) Rules -
	(i) Projects can be created by Employers, Marketers or Managers. (Covered,)
	(ii) Manager can open the Project for Coders or offer the Project directly to a specific Coder. (Covered,)
	(iii) Related coders (or algorithmically-determined coders) will be notified of the Project as soon as the Project is opened.
	
	(iv) If the Project is open for Coders, Coders can put Interest in the project. (Covered,)
	
	Coders can Ask Questions about the Project. The questions will be invigiliated by the manager first before being forwarded to the employer. The manager can mark the questions repeat questions and point the asker to the answer previously created. Or the manager can rephrase the question. And then the manager can let the question be passed which the employer be notified of and can answer. Same way as question is invigilated by the manager, the answer is also invigilated by the manager. The manager can rephrase the answer before letting it post or he can let it post without rephrasing, or the manager can ask the employer to clarify further before posting or ask a more specific questions from the employer or notify him if he missed answering a sub part of the question. Also, the manager can answer the question himself without letting the employer answer it. (Covered,) 
	
	The questions can have references to other questions, answers, description text, attachments etc. 
	
	The manager can set the price for the coder for the project. This price is called the $c in my equations. (Covered,)
	
	The creator of the project can set the price of the project that the employer will pay. (Covered,)
	
	The employer of the project can increase the price of the project without any permissions required. (Covered,) 
	
	The employer of the project can request to decrease the price of the project providing a specific explanation. <TODO> Who will provide the permission? the manager or the coder or both? Will marketer be involved in this. (Covered,)
	
	The coder of the project can reduce the amount that he is willing to get paid on the project without any permissions required. This price is called the $c in my equations. (Covered,)
	
	The coder will need the permission of the manager before increasing the price that he is willing to get paid for the project, providing any explanations. This price is $c. (Covered,)
	
	The manager can decrease the price of the project that employer will pay, but he can reduce it only if he is setting it greater than $c. If he sets smaller then $c, then he has to take permission from the coder, or hire another coder. (Covered,)
	
	The manager can request to increase the price of the project with a explanation. And the employer will have option to give permission. (Covered,)
	
	Employer can create milestones for a project. He can also fund the milestone fully or partially. When he funds the milestone with an amount, the amount gets blocked on the app, and is accessible to neither the employer nor the employees. He can release the milestone so that the amount is accessible to the employees. The manager can cancel or dispute milestones. The employer can dispute the milestones. The manager can also create milestones on behalf of employer, but obviously only employer can fund them. When employer releases a milestone, the manager or marketer or coder doesn't get paid right away. Out of the funds released, the first priority is given to coder's amount. But manager determines when and by how much the coder gets paid from the released milestones. Even though the employer releases the funds, the manager and marketers are not paid until the very end after the coder gets paid, and project is marked complete. (Covered,)
	
	Each employee will get paid an amount that is different from the budget of the project. The payable amount will be calculated from a particular set of equations and will include P and R amounts. This sum of adjusted payable amount of each employee of a proejct is always greater or equal to the amount that the employer is paying for the project. When each milestone payment is released, no employee will be paid. Instead the amount released will be accumulated in a separate account from which the manager can release any amount to the coder. Once the project is marked complete and fully paid (project can be marked complete only when its fully paid), the amount is distributed among the coder, manager and marketer properly along with any referral earnings according to the adjusted earnings amount. (Covered,)

	When an employee is assigned a project, his adjusted earning from the project is calculated. And the R earning part from the earning is deducted from his R account balance immediately. This part might be refunded later on if the employer cancels the project without paying anything, or partially refunded if the employer cancels the project after paying a partial amount, or completes the project with a reduced budget. (Covered,)
	
	When anyone changes the budget or request of changing the budget is accepted, the R earning for each employee is recalculated, and the difference is charged/refunded from/to the R account of each employee. (Covered,)
	
	The employer can mark a project Complete or Canceled. If the project is canceled, the manager will determine if the coder should receive partial or full amount of the R earnings that he was supposed to get if the project was actually marked completed by the employer. This in turn depends on how much the coder actually worked on the project which the manager has to judge himself. However, the manager can make this decision only if the employer pays nothing before canceling the project or he pays upto only 5% of the project. If the employer pays over 5% before cancelling the project, the employees get paid that amount, and the coder doesn't get anything more. The manager and marketer don't earn anything extra from the R income if the project gets cancelled, only the coder does (if the manager wants). (Covered,)
	
	employer can request to reassign the project to another manager, or another coder, or both. (Covered,)

	assigned manager can look at the employer's other projects as a necessary step and can mark his own as a repeat project, in which case the project will be cancelled. (Covered,)
	
	one project may require multiple coders or employees in the team. This decision will be taken by the manager. Manager can higher multiple coders to get the project done. (Covered,)
	
	All coders of one project can communicate with each other individually and in a group. (Covered,)
	
	Employee can take an emergency leave only at a cost of a penalty. The penalty increases with the frequency of taking emergency leaves. (Covered,)
	
	Coder can send msgs to all coders hired in his project. Each msg will be also notified to the manager as well. (Covered,)
	
	Manager can set the budget for each of the coder in the project. A manager can mark a project to be a simple project, or a complex project. For simple project, only one coder will be hired. For complex project, manager can open multiple openings/positions for the project. For each position, the manager will be able to set the budget for the coder and explain the position requirements which will be displayed to the coders along with the orignal project description from the employer. (Covered,)
	
	Manager and marketer can edit the project description from the employer in order to hide the contact details of the project. (Covered,)
	
	If the employer cancels the project while there is a milestone in the project <TODO>
	
	coder can reassign the project to another coder with manager's permission. If the coder stops responding msgs to manager for over a threshold time period, then another coder is assigned automatically. The coder will be charged penalty for transferring. (Covered,)
	
	
	manager can reassign the project to another manager. If the manager stops responding msgs to employer or coder for over a threshold time period, then another manager is assigned automatically. The old manager has is penalized <TODO> how?.
	
	The coder or manager can provide a leave request for a specified duration, which if accepted by the employer, the project won't be reassigned automatically to anyone else until after the threshold period is over. After the threshold period is over, employer will be notified automatically if he wants to reassign the project to another coder or manager. The coder and manager can request to extend the leave period. Once leave accepted, the employer cannot shorten the duration but request shortening the duration. (Covered,)
	
	Employer can  reassign the project to a different manager or request the manager to reassign the project to a different coder. (Covered,)
	
	manager can reassign the project to another coder anytime. (Covered,)
	
	If employer files for a refund during providing ratings, and if his request is accepted, then each of the employees will be charged some amount from their earnings. First they will be charged from the amount that they aren't paid yet, the balance they will be charged from their R account, and then they will be charged in their P account. If their P account goes in negative, they will be charged 10% interest on it every month until they settle it up. If in the meantime, they make money in thier R account, then the negative P account will be deducted from their R account. If they don't settle the P account ever, their account will be shut down, and the user will be deleted from the system. (Covered,)

	The project will be assigned to a manager automatically. Or the Employer can particular request to assign the project to a specific manager. If the manager is available, he will be assigned. If he is unavailable, the employer will be notified of his unavailability. The employer can choose to get notification once the manager becomes available again. And employer can also choose to assign the project to manager automatically as soon as the manager becomes available. If the project is created by the marketer, the project will be assigned automatically to a manager. (Covered,)
	
	
	Similarly, the employer can request the system to assign the project to the same coder. System will let the employer know if the coder is unavailable. If the coder is unvailable, the employer can choose to get notification as soon as the coder becomes available, or employer can choose to award the project to the coder as soon as he becomes available. If the coder is available, the coder must accept the project in order to be assigned for the project, unless he put Interest on the project in which case he must stick with the project if gets awarded. (Covered,)
	
	The project will be assigned to an interested coder automatically. Or the manager can offer a particular coder the project. If the coder is unavailable, the manager will be notified, and he won't be able to assign the project to the coder until he becomes available. He will NOT have the option of autoassigning or autoawarding the coder as soon as he becomes available because the employer might not want any delays in the project. If the employer is OK with the delay, then the manager should convey to the coder that he must not put interest on any other project after he is available again. (Covered,) 
	
	If a coder puts Interest on a project, and if he is assigned the project by the system automatically or by the manager automatically, the coder must stick with the project. (Covered,)

	Manager can mark the project "too low budget", which will negatively impact ratings of marketer if the project was created by the marketer. This will force marketers to get projects with adequate budget. For projects that are not created by the marketer, marketer can mark the project with "too low budget", in which case if the project was created by employer himself and the project was failed then it will reduce bad ratings on the manager and/or coder. (Covered,)
	
	The employer, coder, and manager can upload any files on a project for each other's viewing. When employer uploads a file, its only viewable to the manager, and the manager can mark it to let the coder view. When coder uploads a file, its only visible to manager, and manager can mark it to let the employer view. When manager uploads a file, he can choose whom he wants it to view. Also, the app provides functionality to compress the files before uploading. (Covered,)
	
	The employer can send msgs to manager and marketer of the project. The manager can send msgs to employer, marketer, and coder of the project. The coder can send msgs to manager as well as employer, however, if he sends msg to employer, the msg is invigilated by the manager. The marketer can send msgs to employer and manager. (Covered,)
	
	The employer can make project's payment directly through the system, or can make the payment to the marketer. (Covered,)
	
	The employer can request for remote viewing in order to help him set up, run or debug the project. The remote viewing must be facilitated with a manager or marketer of this project (preferrably) or by another manager or marketer or coder. This is to make sure that the coder of this project and the employer don't get involved in exchanging the contact information or talk about the price of the project. The employer can provide time schedules when he is available. The coder can provide his time schedule when he is available. A common time is agreed, and the manager is requested to make himself available at that time (and if he fails, he is penalized). If he is not available at that time, any online marketer or manager or coder is requested to invigilate the process for little extra income. Once the meeting is over, the invigilator submits a report about the coder and employer. If no invigilator is available, then the employer and client are allowed to communicate on the app for a while in order to be able to coordinate with each other abt the remote viewing. (Covered,)
	
	The employer can mark the project complete, or cancel the project. The manager can mark the project Impossible. The marketer can mark the project abandoned by employer, or unfinished by the manager. Once the entire project amount is released, the project is automatically marked complete. (Covered,)
	
	ratings system

	While working on a project, the coder cannot put interest in other projects. If the employer takes too long to respond, the coder is allowed to put interest in small projects. But he can assigned a maximum of x projects at any time. If the employer doesn't respond for long, he is sent a few notifications, and then project is marked abandoned automatically, and all the milestones (if any) are distributed among the employees.

	The employer or manager can dispute the funded milestone. The other party can contest the dispute or give up. If dispute is contested, then both parties have to put down some payments in order to continue. If one party puts down payment, but other party doesn't then the dispute is resolved in the favor of first party. The other party is given a specific number of days to deposit the funds after the first party deposits. After both parties deposit funds, the issue is looked over by an invigilator. The dispute can result in favor of 1 side completely (in which case the milestone as well as deposit is refunded that side, and the opposite party looses the milestone as well as his deposit), or can result in favor of both sides partially (in which case the milestone is split by a specific proportion, and their deposits are deducted in inverse proportions). An employee can apply to take up a position of invigilation only if he has never worked for or with the employees or employer involved in the dispute in order to keep it fair. However, if this condition is ruining the balance between number of disputes vs number of qualified invigilators, then any this restriction is not applicable.
	
	task system
	Each employee will be assigned tasks if there are following scenarios:
		- One or more types of activities of the employee are under general average.
		- One or more types of the platform's projects/duties (such as projects, disputes, training, remote meeting, online chatting, etc.) are getting lesser response from the employees.
		- If the system needs to expand certain types of users in its community base.
	Each task will be of the following type:
		- Strict
			If the task of such type is not assigned to a user, he will not be able to take such a task up at all.
		- Lenient 
			If the task of such type is not assigned to a user, he will still be able to take such a task up but won't be compensated for it from R account, but will get compensated INTO the R account.
		- Urgent
			He will not be assigned new tasks until he finishes this task.
		- Prioritized
			If the task is not assigned specifically, then he can take the task up and execute as he would normally. If the task is assigned in the task list, then
			

			
	If no tasks of one type are there anymore on the platform, employees who are assigned that type of task if any will have their tasks of that type removed from their task list. The algorithm will be there to make sure that no more tasks are assigned to employees than there are actual tasks of particular type.
		
	
	Whenever an employee gets paid for the first time, his referee's referral is considered completed. Whenever an employer makes payment or release milestone for the first time, his referee's referral is considered complete. When the referral is compeleted, a referral task if assigned is marked completed. Once the referral task is completed, the receiver not only gets paid in his R account, but also get 10% of R account into his P account so that now he can withdraw the money. If the referral task is not assigned (and so there is no task to be completed even though the employee gets paid for the first time or employer makes payment for the first time), then the referee still gets paid but not in his P account but only in his R account. Same way the referee gets paid only in his R account when one of his child employees' or child employers' make payment not for the first time. Each employee is given a referral task to complete every fixed interval of time. The referral task is never given before he makes his first $1000 though in order to get him comfortable first with the system. However, if an affiliate's child gets paid or makes payment, the affiliate gets paid directly in his P account. There is no R account of an affiliate.
	
	Each user can do his normal expected work as well as recruit people of his type, as well as several other tasks such as dispute handling, remote viewing invigilation etc. Whoever employee's any type of activity is lower than average will be assigned specific type of activities periodically in order to regulate his activities. This way he will be carrying out responsibilities equally distributed in different areas of the platform. However, in case of dispute and remote viewing tasks, such monitored control will be implemented if there are more cases than the employees who are willing to handle them. If there are more cases than there are employees to handle them then the referral commission for employees is increased temporarily in order to get more employees on board. Once the balance occurs, then the commission rates are fallen back to normal. 
	
	Automated Controlled growth of the community
	If the number of employees are becoming greater than number of projects incoming so that each employee have less amount of work, then the app will restrict new incoming employees from registration, and will stop giving referral tasks to coders and/or managers to recruit more coders/managers. If the number of projects are becoming more than number of employees/managers who are able to handle them, then marketers will be asked to restrict finding new customers and recruit more managers/coders instead, and managers will be given more tasks of referring more managers and coders periodically too. 
	
	When each of the assigned task is completed, the employee makes a referral earning from his R account into his P account. The exact amount depends on the type of task. This amount will also be reflected to coder on each project so that he could decide whether he wants to put his interest on it or not. For manager or marketer, visible only on the projects that are assigned to them. 
	
	<TODO> How to make sure the managers don't hire their own developers to get the project done and assign them entire budget of the project leaving nothing or very less for marketer and platform? How to make sure the managers are not the software development companies themselves? 
	Answer: Implement a different model for software development companies with feature of letting them define the salary of coders as well. And keep the managers in check by watching over how much profit they are leaving to be distributed among themselves, marketers and app on average.
	
	<TODO> Implement a feature for new coders who are entering development that will let them architect and implement a huge project by letting them take 1 step at a time. There will be a presentational pitch for this feature: No matter how good of a coder are you, if you are new to developing large applications involving 100 thousand lines of code, you are destined to get frustrated and rework a lot of your code throughout various stages of your development. In order to minimize the rework involved, this platform will let you take systematic steps 1 at a time so that you will be able to finish the project much sooner and with fewer trials than you would have without it. 

	<TODO> What incentive a coder will have to bring a known employer to the platform?
	<TODO> What incentive a manager will have to bring a known employer to the platform?
	
	There are following types of tasks: 	<TODO>
		Project 
			Responsibility Of: Coder
			Payment Structure: For each project, the coder will get in his P account something from employer's payment plus something from his R account. Out of the total he gets in his P account from a Project, 20% will be distributed up in the tree.
			Restriction: Strict
		Management 
			Responsibility Of: Manager
		Referral To Coder
			Responsibility Of: Coder, Manager, Marketer
		Referral To Manager 
			Responsibility Of: Manager, Marketer
		Referral To Marketer 
			Responsibility Of: Marketer, Manager
		Referral To Employer  
			Responsibility Of: Marketer, Coder, Manager
		Dispute Invigilation 
			Responsibility Of: Manager, Marketer
		Remote Viewing Invigilation 
			Responsibility Of: Manager, Marketer
		Online Welcome Chatting and Customer Service  
			Responsibility Of: Manager, Marketer
		Trainer 
			Responsibility Of: Marketer, Manager, Coder
		Online Marketing <TODO>
			Replying on Forums
			Posting Content
			Article Writing
			Twitter Posting/Tweeting/Replying/Retweeting
		Complaints Handling Task 
			Responsibility Of: Manager, Marketer
		Requests Handling Task
			Responsibility Of: Manager, Marketer
		Quality Checking Task
			Responsibility Of: Manager, Marketer
		Special Tasks (Such as digital marketing, forum marketing, social media marketing, etc.)
			Responsibility Of: Marketer, Manager, Coder
	Make sure to keep every employee in the system so busy that he will not be willing to take over work from outside, so he will direct all outside employers to the platform.
	
	The employees before being registered fully will have to give a small multiple questions test. If they give more than x number of incorrect answers, then they have to give test again (after they go thru the material). If they give only a few wrong answers, they are pointed to revise particular material only before answering the incorrect ones again.
	
	One project can have multiple coders hired by the manager.
	
	Build a portal for advertisers.
	
	Build a special system for software companies. Employee check in and check out feature by logging in and logging out. Employee productivity measurement tool which will monitor the activity of the employee on the system, such as websites visited, keystrokes, mouse clicks, mouse movements etc.
	
	For video files, create a feature to edit the video files to hide some portions of the video so as to not make the employer or coder information visible.
	
	
Architecture of Settings:

Architecture of Communication:	
	

Architecture of Tasks:
Marketer should bring marketers as well as projects
Manager should bring managers as well as manage projects
Coder should bring coders as well as code projects
Affiliate makes money on any transaction that happens through them.
	

Architecture for Search
	
Architecture for Affiliates

Architecture for Project Models
Game App
Game
Simple
Bot
Web scraper
Management Software
Mobile App
Website
Start Up Package - Backend, Mobile App, Website, Presentational Video, Marketing, Approaching Investors, Online Marketing
Simple Software 
Assignment
Complex System
Complex Software - Like Matlab, Photoshop etc.

Architecture for Skills
People can enter the skills of their choice, and if the skill is not found, it will be submitted for administrative inspection. Administrator will insert the skill in the database.


*/


/*
Interface:
addProject($creatorEmail,$employerEmail,$projectTitle,$projectDescription,$projectBudget,Array $skills)		
Permission: Employer, Marketer
Description: Creates a project and adds to the database.

editProject($projectId,$projectTitle,$projectDescription,Array $skills)
Permission: Creator of project, Manager, Marketer
Description: Edit the project.

editProject($projectId,$projectTitle,$projectDescription,$projectBudget,Array $skills)
Permission: Creator of the project
Description: Edit the project. Only creator of the project can edit the budget of the project.

archiveProject($projectId)	 
Permission: Creator of the project.
Description: Archives the project.

cancelProject($projectId)		 
Permission: Can be called by the employer only.
Description: Cancels the project. Takes care of the R amount of each employee (refund into R account) and all other responsibilities. <TODO>

validateProject($projectId,$projectTitle,$projectDescription,$projectBudget,Array $skills)
Permission: Manager of the project
Description: Manager can validate the project so that it will be ready to be opened for the coders to put their interests in.

markProjectSimple($projectId)
Permission: Manager of the project.
Description: Marks the project simple. Which means that only one coder will be hired and appropriate project flow will be implemented. By default the project is marked simple.

markProjectComplex($projectId)
Permission: Manager of the project.
Description: Marks the project complex. Which means that multiple coders will be hired and appropriate project flow will be implemented. By default the project is marked simple.

openProjectPosition($projectId,$title,$description,$budget,Array $skills)
Permission: Manager 
Description: Opens a position for the project. Can be called only if project is marked complex by the manager.

closeProjectPosition($projectPositionId)
Permission: Manager
Description: Closes the opened position for the project.

openProjectForCoders($projectId)	//opens a project for coders so that the coders will get notified, and they can put an interest in the project, or ask questions on the project
Permission: Assigned Manager of the project.
Description: Opens the project for the coders. Notify coders based on an algorithm. 		//<TODO> Implement the algorithm for identifying which coders to notify.

reopenProjectForCoders($projectId)
Permission: Assigned Manager of the project.
Description: Opens the project for the coders. Discards the currently hired coder. Notify all other coders who are available and put interest on the project. And find new coders too.

putInterestInProject($projectId)
Permission: Coder only.
Description: Logged in coder puts an interest in the project.

setCoderBudget($projectId,$budget)
Permission: Manager only.
Description: Set the budget for the coder. And calculate the adjusted earnings for the coder from this project.

setCoderBudgetPercentage($projectId,$percentage)
Permission: Manager only.
Description: Set the budget for the coder as a percentage for the total budget of the employer. And calculate the adjusted earnings for the coder from this project.

changeProjectBudgetTo($projectId,$newAmount,$explanation=null)
changeProjectBudgetBy($projectId,$amount,$explanation=null)
Permission: Manager, Marketer, Coder, Employer
Description: Changes the project budget/cost. Depending on who is changing the budget and by how much, it may or may not need approval from others. The R value is recalculated and the difference is debited/credited  from/to the R account.

changeProjectEarningTo($projectId,$newAmount,$explanation=null)
changeProjectEarningBy($projectId,$amount,$explanation=null)
Permission: Manager, Coder
Description: Changes the project earnings for coder. Depending on who is changing the budget and by how much, it may or may not need approval from others. The R value is recalculated and the difference is debited/credited  from/to the R account.

hireAnotherCoder($projectId,$coderEmail)
Permission: Manager
Description: Manager can hire multiple coders for the project. All coders of one project can communicate with each other individually and in a group.

payCoderOnCancelledProject($projectId,$percentage)
Permission: Manager
Description: Manager will decide whether the coder should get paid from his R amount on project and by how much if the project gets cancelled. This depends on how much the coder actually worked on the project before the project got cancelled. Its possible the project got cancelled because of the coder's poor quality work, in which case the coder shouldn't get paid at all. Other times its possible that the coder worked great, but still the employer cancelled. In this case, the coder should get paid for his work. This decision will be made by the manager.

markDuplicateProject($projectId1,$projectId2)
Permission: Manager
Description: Manager can mark his newly assigned project as a duplicate project, which once he does will be cancelled canceled.

markProjectBudgetTooLow($projectId)
Permission: Manager (if the project was created by the marketer), Marketer (if the project was created by the employer)
Description: If marketer created the project, then manager can mark it too-low-budget so that it will affect the marketer's ratings in negative way, and will protect manager's ratings if he fails the project. If the employer created the project himself, the marketer can mark it too-low-budget so that manager's ratings won't be affected if the project is failed.

submitRefundRequest($projectId,$amount,$explanation)
Permission: Employer
Description: Employer can submit a refund request while rating the project once the project is completed.

acceptRefundRequest($requestId,$amount,$responsibilityDistribution)
Permission: Request Handler (Could be an unrelated manager or marketer)
Description: The request handler accepts the refund request, in which case the refund is provided to the employer. The request handler also mentions distribution of the responsibilities of each employee handling the project in making the erros that lead to the refund request so that the amount will be penalized the appropriate distribution from each employee.

denyRefundRequest($requestId)
Permission: Request Handler (Could be an unrelated manager or marketer)
Description: The request handler denies the refund request. 

paidToMarketer($projectId)
Permission: Employer, Manager 
Description: Employer or manager of project can mark the project paid if the employer is paying to the marketer on freelancer.com or upwork.com etc. This way, the marketer will be charged by the system into his O account. And if the marketer doesn't make payment he will keep on accumulating the interest on the amount. Once marketer makes entire payments, the manager and coder will be paid.

*/

include_once "pm_session.php";

function addProject($employerEmail,$projectTitle,$projectDescription,$projectBudget)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=insertValues("pm_projects",Array("u_creatoremail"=>"'{$_SESSION['email']}'","u_employeremail"=>"'$employerEmail'","p_title"=>"'$projectTitle'","p_description"=>"'$projectDescription'","p_budget"=>"$projectBudget"); //<TODO> update more parameters later
//	$q="insert into pm_projects(u_employeremail,p_title,p_description,p_budget) values ('$employerEmail','$projectTitle','$projectDescription',$projectBudget)";	 	//<TODO> update more parameters later
//	$r=$gf_con->query($q);

	if($r)
	{
		return $g->insert_id;
	}
	else
		return query_error_code();	
}

//Only called on old projects which remained untouched for a long time after being archived.
function deleteProject($projectId)
{
	//<TODO> Implement restriction on who can delete which project.
	
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=$g->query("delete from pm_projects where p_id=$projectId");
	
	if($r)
	{
		if($g->affected_rows==0)
			return false;
		elseif($g->affected_rows==1)
			return true;
		elseif($g->affected_rows>1)
			return more_than_1_rows_error_code();
	}
	else 
		return query_error_code();
}

function archiveProject($projectId)	//<TODO> Implement archive feature in other functions also
{
	//<TODO> Implement restriction on who can delete which project.

	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=$g->query("update pm_projects set p_archived=true where p_id=$projectId");
	
	if($r)
	{
		if($g->affected_rows==0)
			return false;
		elseif($g->affected_rows==1)
			return true;
		elseif($g->affected_rows>1)
			return more_than_1_rows_error_code();
	}
	else 
		return query_error_code();
}

/*
function getProjects($uEmail)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$t=getUserType($uEmail);
	if(isSqlError($t)==true) return $t;
	$q="select * from pm_projects where %s='$uEmail' and p_archived=false";
	if($t=="0")
		$q=sprintf($q,"u_employeremail");
	elseif($t=="1")
	{
		$tempid="";	//<TODO> generate unique id.. best is to use $uEmail as the tempid because that all such tables give 1 result.
		$q="create view as $tempid select u_email from pm_users where u_referralemail='$uEmail'";	//<TODO> check if this query actually works.
		$r=$gf_con->query($q);
		$q="select * from $tempid join pm_projects on $tempid.u_email=pm_projects.u_employeremail";	//<TODO> projects order by date	//<TODO> Check if this query works
	}
	elseif($t=="2")
		$q=sprintf($q,"u_manageremail");
	elseif($t=="3")
		$q=sprintf($q,"u_coderemail");
	else
	{
		//<TODO>
	}			
	$r=$gf_con->query($q);
	if($isCallInternal==false)
	{
		$st="[response=%s,count=%d,pagenum=%d,%s]";
		$p="";
		$f=false;
		$c=0;
		$pagenum=0;
		while($row=$r->fetch_array())
		{
			if($f)
				$p.=",";
			else
				$f=true;
			$p.="[title={$row['p_title']},description={$row['p_description']},budget={$row['p_budget']}]";
			$c+=1;
		}
		return sprintf($st,"true",$c,$pagenum,$p);	//<TODO> implement page numbers, implement if response fails
	}
	else	//External Call
	{
		//<TODO>
	}
}
*/

function getMyProjects($pagenum,$numrows=0)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	
	$numrows=fixRowsToFetch($numrows);
	if(isSqlError($numRows)) return $numrows;
	$offset=$numrows*$pagenum;
	
	$q="select * from pm_projects where (%s='{$_SESSION['email']}' or u_creatoremail='{$_SESSION['email']}') and p_archived=false limit $offset,$numrows"; //<TODO>confirm if limit works
	$t=getUserType($uEmail);
	if(isSqlError($t)==true) 
		return $t;
	elseif($t=="0")
		$q=sprintf($q,"u_employeremail");
	elseif($t=="1")
		$q=sprintf($q,"u_creatoremail");
	elseif($t=="2")
		$q=sprintf($q,"u_manageremail");
	elseif($t=="3") 								//<TODO> revise to add for affiliate as well
		$q=sprintf($q,"u_coderemail");
	else
		return abnormal_error_code();
	$r=$g->query($q);
	if($r)
	{
		$projects=Array();
		while($row=$r->fetch_array())
			$projects[]=Array("id"=>$row['p_id'],"title"=>$row['p_title'],"budget"=>$row['p_budget'],"short_desc"=>reduceDescription($row['p_description']));	//<TODO> Accept reduceDescription's 2nd argument from client app.
		return $projects;
	}
	else
		return query_error_code();
}

function getMyProjectsIds($pagenum,$numrows=0)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	
	$numrows=fixRowsToFetch($numrows);
	if(isSqlError($numRows)) return $numrows;
	$offset=$numrows*$pagenum;
	
	$q="select p_id from pm_projects where (%s='{$_SESSION['email']}' or u_creatoremail='{$_SESSION['email']}') and p_archived=false limit $offset,$numrows"; //<TODO>confirm if limit works
	$t=getUserType($uEmail);
	if(isSqlError($t)==true) 
		return $t;
	elseif($t=="0")
		$q=sprintf($q,"u_employeremail");
	elseif($t=="1")
		$q=sprintf($q,"u_creatoremail");
	elseif($t=="2")
		$q=sprintf($q,"u_manageremail");
	elseif($t=="3")							//<TODO> revise to add for affiliate as well
		$q=sprintf($q,"u_coderemail");
	else
		return abnormal_error_code();
	$r=$g->query($q);
	if($r)
	{
		$projects=Array();
		while($row=$r->fetch_array())
			$projects[]=$row['p_id'];
		return $projects;
	}
	else
		return query_error_code();
}

//Get only those projects in which marketer was involved directly through some action.
function getMyClientsProjects($marketeremail)
{
	
}

function getMyClientsProjectsIds($marketeremail)
{
	
}

function getProjectInfo($projectId,$keepDescShort=false)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();
	$r=$g->query("select * from pm_projects where p_id=$projectId");
	if($r)
	{
		if($row=$r->fetch_array())
		{	
			$ret=Array("title"=>$row['p_title'],"budget"=>$row['p_budget']);
			if($keepDescShort)
			{
				$s=reduceDescription($row['p_description']);
				if(isSqlError($s)) return $s;
				$ret['description']=$s;
			}
			else
				$ret['description']=$row['p_description'];
			return $ret;
		}
		else
			return no_rows_error_code();
	}
	else
		return query_error_code();
}

function reduceDescription($desc,$numChars=0) //<TODO> Modify the length algo if RTF format or HTML format is allowed in the description text.
{	
	$numChars=fixShortDescLength($numChars);
	if(isSqlError($numChars)) return $numChars;
	
	$l=strlen($desc);
	if($l>$numChars)
		$desc=substr($desc,0,$numChars-3)."...";
	return $desc;	
}
?>