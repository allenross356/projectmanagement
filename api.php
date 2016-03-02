<?php

//ini_set("log_errors", 1);
//ini_set("error_log", "php-error.log");
//error_log( "Hello, errors!" );
//error_log("You messed up!", 3, "my-errors.log");


//<TODO>Error handling for failing queries.

//<TODO> Implement server side so that it will confirm whether the query is coming from this software or some other software.
//<TODO> Confirm whether POSTing a password in the query manually is safe.
//<TODO> For adding project, give permission to marketer and manager only.
//<TODO> For adding client, give per mission to marketer only.
//<TODO> For referring the software/service to any one, give permission to all: marketer,coder,manager,employer.
//<TODO> Impose limit of 5000 characters on Project description in PHP and VB.net
//<TODO> Implement auto-cleanup for the uploaded files of projects that are completed long enough ago.
//<TODO> Implement auto-cleanup for projects that are created but has no activity related to them since long enough ago.
//<TODO> If user is logged in from multiple devices, and one device makes a request which changes the database, all the other devices should be notified and their datastructures should be updated to keep them in sync.
//<TODO> Confirm if MySQL queries are atomic. Confirmed they are not atomic. Need to puth semaphores/mutex
//<TODO> Add dates to projects creation

//<TODO> Make sure to display a msg during register to user that we don't spam their inbox nor do we reveal their emails to any third parties.

//<TODO> Implement spoken languages of employer and manager assigned.

//<TODO> Implement a script to return set of variables which can be modified just by changing the values in DB.

//<TODO> Update table to minimize the space taken up by INT fields.

//<TODO> Make sure that each update command checks the number of rows affected and return false if none are affected.

//<TODO> Implement library for making the SQL commands ACIDic (meaning, if SQL returns error or false, then rollback/undo the operation properly before exiting) 

//Tutorial for uploading files on server accessing through php
//http://www.php-mysql-tutorial.com/wikis/mysql-tutorials/uploading-files-to-mysql-database.aspx


//<PHP CONFIGURATION>
//<TODO>For file uploads: Configure The "php.ini" File (C:\wamp\bin\apache\apache2.4.9\bin)
//First, ensure that PHP is configured to allow file uploads.
//In your "php.ini" file, search for the file_uploads directive, and set it to On:
//file_uploads = On
//session.upload_progress.enabled = On
//also, set the 'post_max_size' and 'upload_max_filesize' variables in php.ini .. upload_max_filesize is 64M by default;  post_max_size is 3M by default, can be set to 0 to remove the limit
//Important variables: session.upload_progress.cleanup		session.upload_progress.freq		session.upload_progress.min_freq		$_SESSION[$key]["cancel_upload"]

//<TODO> Make sure to configure PHP with --enable-bcmath in order to access bcmath functions.
//BC math configuration 
//options Name 		Default 	Changeable 		Changelog
//bcmath.scale 		"0" 		PHP_INI_ALL


/*<TODO> Implement constants:
Number of coders threshold 1 - below this threshold, the platform will mostly dependent on managers getting coders from third party source.
Number of coders threshold 2 - below this threshold, managers will get coders from third party source as well be able to contact coders on platform itself.
Number of coders threshold 3 - below this threshold, managers will heavily depend on getting coders from the platform and less from outside.
Number of coders threshold 4 - below this threshold, managers will only depend on getting coders from the platform. More coders will be attracted on platform only thru ads.

*/

//<TODO> Rating system should be such as the rater shud have an option to only rate the user in 1 criteria. If the rater rates the user bad, then the system should ask more specific reasons why. The system should also ask the rater to open up an investigation, and investigation shud be opened only if the rater asks to.
//<TODO> Failure ratings (Calculated Automatically Internally), Etiquettes/Professionalism/Expertise Ratings (Given by users)
//<TODO> Users can choose to hide the ratings they give to the other user. This means that the other user will see that the first user rated him full. When user chooses this option, the app explains him the psychology difference between both hiding and showing the ratings. But even if the user hides the ratings, other similar users can see the real ratings so that they can base their judgements about the other user.

//<TODO> Initially, the new employee should be assigned to a trained employee, so that he the new employee cud ask the trained employee any questions on how to tackle certain situations when he runs into such. In the end, both employees will rate each other.

//<TODO> Set all fields in databases to be NULL default in order to optimize 

//<TODO> If project is coming from marketer directly and is the first project of the client, the project will be done at any price as long as price is not zero. If the 

//<TODO> Automatic determination of whether the coder will get milestones or not all the payment at the end. Determination will be based on the amount of money accumulated so far for him to get paid.

//<TODO> Give impression to the employer as if marketer is senior/boss of manager, so that employer won't cut marketer off. Don't use the word Marketer at all.

//<TODO> For few months the ratings of each project to each user will be stored in depth in a separate table. After few months, the ratings will be compressed and aggregated to store in the user's table only and removed from the separate table to save space and speed up queries.

//<TODO> For 2 years, the projects, will be stored in a separate table. After 2 years, the projects will be aggregated to optimize database and speed.


//<TODO> In GUI, all requests created by requestor should be visible in the chat window between the creator and prospective grantor.

//<TODO> The marketers will be given incentive to create portfolio of best projects.

//<TODO> After the launch of the app, choose the package billing in the Google Cloud SQL to lower the usage cost.

//<TODO> Add SSL before launching the app.

//<TODO> Implement Remote Viewing 

//<TODO> Implement IP tracking to block users from creating multiple accounts of same or different types.

//<TODO> Implement feature to not let multiple instances of the app run simultaneously.
//<TODO> Implement feature to detect same or another version of the app already installed on the machine.

//<TODO> Make sure to not make the interface confusing by providing too many options to the users. Keep the interface simple and straightforward and keep the number of options offered limited and keeping the flows limited and intuitive.

//<TODO> Build a Quick Tour feature, and a Crash Course for each type of user. For employees build a small test before they could start using the app. For employer, build a sandbox simulation of a project life-cycle.

//<TODO> Implement features of organizing coding, development, design, and data sciences competition.

//<TODO> Implement features to let entrepreneurs launch a fake money crowd funding, where investors will invest the money by looking at the crowd who is willing to purchase it. Buyers will place pre-order by paying in advance or cash-on-delivery. Entrepreneur will launch a nice presentational video for the project, and then create openings to hire coders to build the stuff. The stuff built will be delivered through Logistics services who will register online to take the orders. Online Store too. Affiliates can also promote the start up idea, so that if an investor invest $200,000 the affiate makes $10,000. Build a secure environment for investors in order to minimize the risk. Build Marketplace for the bigger fish to buy out smaller fish.

//<TODO> Coders can launch software tools and products in our online store, which affiliates can sell.
 

/*<NOTE>
Coder Bidding Models
Model 1:
Coders will bid with amount and time.
The coders with higher than client's budget will be rejected without letting them know.
The bidding will stop automatically after certain number of good coders bid with perfect price and timeline. 
Price can be one of the following: $5, $25, $50, $100, $150, $200, $300, $400, $500, $600, $700, $800, $900, $1000, $1250, $1500, $1750, $2000, $2250, $2500, $2750, $3000, $3250 $3500, $3750, $4000, $4250, $4500, $4750, $5000, $5250, $5500, $5750.. upto $10000. 	<TODO> Display reason to coder why he can only bid these discrete amounts.
Out of the eligible coders, the lowest price coder will be assigned the task automatically with his chosen bid.
If he fails the task, his ratings will suffer, and he will be chosen less frequently in future.
If he fails the next eligible coder is chosen, and so on.

Model 2:
Same as model 1. But coders will be chosen sometimes with the price that employer is willing to pay at even though that price is higher than the actual price, and sometimes they will be chosen with the price that they bid for. This will give enough psychological incentive to the coder to bid as low as possible but still not lower than what he is willing to work for.

Model 3:
Same as model 1. But coders wont actually mention a price, just the timeline. And they will be paid from whatever the client is paying. This will go in advantage because Marketers will try to get as high payment as possible.

Model 4:
Same as model 1. But coders will also know the max budget under which they will have to place the bid.

Model 5:
Same as model 2, but they wont actually know that there is a 50-50 chance of them getting hired at their mentioned bidding price or the employer's budget price. This way they will think that the client's budget was close to their bidding price everytime they are picked at their own bidding price. So they will not bid extra low just to get the project thinking they will get paid higher than what they bid for.

Model 6:
Normal bidding model, in which any coder cud bid anything, and manager can choose any coder that he feels appropriate. No automation.

Model 7:
Project is posted with exact cost that employer has budget for. Whoever coder grabs the project first, he owns it, and has to finish it. 15% of the project cost will be split among manager, marketer and company, the remaining 85% will goto the coder.

Model 8:
Model 1-7 + Coder will also make constant money from referrals. Once he is making over $10000 a month from referrals, he wont get paid any extra money from the projects, but he will still have to deliver some target every month in order to get that money from referrals. In this case, the money paid by the client will be distributed among the manager, marketer and company.

<TODO> Implement model to handle the scenario that coder leaves the project in between

Marketers Models:
Model 1:
<TODO>

Manager Models:
<TODO> Implement model to handle the scenario that manager leaves project in between

*/


//<TODO> implement recycling of IDs of each table.

//<TODO> Implement the p_openbidding field in functions of adding project

session_start();

$specialChar="-*#-(#";
$gf_con = new mysqli("localhost", "root", "", "projectmanagement"); //<TODO Set password in database to make it secure>

if(isset($_POST["args"])==true) 
	$args=$_POST["args"]; 
else 
	$args=$_GET["args"]; 



if($args!=null && $args!="")
{
	if ($gf_con->connect_error) 
		echo "Connection failed: " . $conn->connect_error;
	else
	{ 
		$t=explode($specialChar,$args);
		array_push($t, "", "","","","","","","","","","","","","","","","","","","","","","","","");
		echo call_user_func($t[0],$t[1],$t[2],$t[3],$t[4],$t[5],$t[6],$t[7],$t[8],$t[9],$t[10]); 			//<TODO> Implement Error handler for function calls that don't exist
		
		//<TODO> Implement case for functions that are called but are not meant to be called.
	}
}
else
{
	if ($gf_con->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		//<TODO> redirecto to fail page
	}
}

//<TODO> Called by internal functions ONLY.
function fixParam($x)
{
	if($x==null || $x=="" || $x=="0") return false; else return true;
}

//<TODO> Called by internal functions ONLY.
function insertValues($tableName,$fv)
{
	global $gf_con;
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

//<TODO> Implement already added clients but not registered yet
function doesEmailExist($email,$isCallInternal)
{ 
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="select u_name from pm_users where u_email='$email'";	//<TODO Make query injection proof>
	$r=$gf_con->query($q);
	//<TODO check if $r is true or false and act accordingly>
	 
	
	
	if($r==null or $r->num_rows==0)
	{ 
		if($isCallInternal==true)
			return false;	
		else
			return "[response=false]";
	}
	else 
	{
		$row=$r->fetch_array();		//<TODO> check if succeeds
		if($isCallInternal==true)
			return true;
		else
			return "[response=true,name=$row[0]]";
	}
}

//<TODO> Use u_referralemail as well.
function registerUser($name,$email,$pass,$type,$setSession,$isCallInternal)	//<TODO> update parameters later
{
	$setSession=fixParam($setSession);
	$isCallInternal=fixParam($isCallInternal);
	
	if(doesEmailExist($email,true)==true)
	{
		if($isCallInternal==true) 
			return false; 
		else
			return "[response=false,msg=User already exists.]";
	}
	
	//$pass=crypt($pass,"st");		<TODO>
	
	global $gf_con;
	$q="insert into pm_users(u_name,u_email,u_pass,u_type) values('$name','$email','$pass',$type)";	//<TODO Make query injection-proof> 	//<TODO> update/add more parameters later
	$r=$gf_con->query($q);
	
	if($setSession==true)
	{
		$_SESSION['email']=$email;
	}
	
	//<TODO What if $r query fails.. Check it>
	if($r==true)
	{
		if($isCallInternal==true)
			return true;
		else
			return "[response=true]";		
	}
	else
	{
		if($isCallInternal==true)
			return false;
		else
			return "[response=false,msg=Query failed.]";		
	}
}

//<TODO> Implement already added clients but not registered yet
function authenticateUser($email,$pass,$doLoginIfVerified,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	$doLoginIfVerified=fixParam($doLoginIfVerified);

	//pass=crypt($pass,"st");	<TODO>
	global $gf_con;
	$q="select u_name from pm_users where u_email='$email' and u_pass='$pass'";	//<TODO Make query injection proof>
	$r=$gf_con->query($q); 
	
	if($r->num_rows>0)
	{
		if($doLoginIfVerified==true) $_SESSION['email']=$email;
		if($isCallInternal==true)
			return true;
		else
			return "[response=true]";
	}
	else
	{
		if($isCallInternal==true)
			return false;
		else
			return "[response=false,msg=Email and Password combination incorrect.]";		
	}	
}

//<TODO> Implement already added clients but not registered yet
function loginUser($email,$pass,$isCallInternal)
{
	return authenticateUser($email,$pass,true,$isCallInternal);
}

function logout($isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	unset($_SESSION["email"]);
	
	if($isCallInternal==true)
	{
		return true;
	}
	else
		return "[response=true]";
}

function userInformation($isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);

	global $gf_con;
	$q="select u_name,u_email,u_type from pm_users where u_email='{$_SESSION["email"]}'";	 	//<TODO> update more parameters later
	$r=$gf_con->query($q);
	
	$row=$r->fetch_array();		//<TODO> check if succeeds
	
	if($isCallInternal==false)
		return "[response=true,name={$row[0]},email={$row[1]},type={$row[2]}]";
	else
		return Array("name"=>$row[0],"email"=>$row[1],"type"=>$row[2]); 
}

//Always internal
function getLoggedInUserType()
{	//0=Employer	1=Marketer	2=Manager	3=Coder
	global $gf_con;
	$q="select u_type from pm_users where u_email='{$_SESSION["email"]}'";
	$r=$gf_con->query($q);
	if($row=$r->fetch_array())	//<TODO> Else
		return $row["u_type"];
}

//Always Internal
function getUserType($uEmail)
{
	global $gf_con;
	$q="select u_type from pm_users where u_email='$uEmail'";
	$r=$gf_con->query($q);
	if($row=$r->fetch_array())	//<TODO> Else
		return $row["u_type"];	
}

//<TODO> Implement permissions to marketer, manager and  client only, Coder cannot create a new project.
//<TODO> implement unknown budget, budget range, floating point budget values, and budget in different currencies.
//<TODO> implement limit on project description length
function addProject($employerEmail,$projecTitle,$projectDescription,$projectBudget,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);

	global $gf_con;
	$q="select u_employeremail,p_title,p_description,p_budget,p_type from pm_users where u_email='{$_SESSION["email"]}'";	 	//<TODO> update more parameters later
	$q="insert into pm_projects(u_employeremail,p_title,p_description,p_budget) values ('$employerEmail','$projecTitle','$projectDescription',$projectBudget)";	 	//<TODO> update more parameters later
	$r=$gf_con->query($q);
	
	//<TODO> what if $r returns failure.
	if($isCallInternal==true)
	{
		return $gf_con->insert_id;
	}
	else
	{
		return "[response=true,projectid={$gf_con->insert_id}]";
	}
}

function deleteProject($projectId,$isCallInternal)
{
	//<TODO> Implement restriction on who can delete which project.
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$r=$gf_con->query("delete from pm_projects where p_id=$projectId");
	if($r)
	{
		if($isCallInternal)
			return true;
		else
			return "[response=true]";
	}
	else
	{
		if($isCallInternal)
			return false;
		else
			return "[response=false]";		
	}
}

function getProjects($uEmail,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$t=getUserType($uEmail);
	$q="select * from pm_projects where %s='$uEmail'";
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
			$c+=1
		}
		return sprintf($st,"true",$c,$pagenum,$p);	//<TODO> implement page numbers, implement if response fails
	}
	else	//External Call
	{
		//<TODO>
	}
}

//Get only those projects in which marketer was involved directly through some action.
function getDirectProjectsOfMarketer($marketeremail,$isCallInternal)
{
	
}

//<TODO> Remove this function.. not used anywhere yet.
function getMarketerReferredEmployers($marketeremail,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="select u_email from pm_users where u_referralemail='$marketeremail'";
	$r=$gf_con->query($q);
	
	$arr=array();
	if($isCallInternal)
	{
		while($row=$r->fetch_array())
		{
			$arr[]=$row['u_email'];
		}
		return $arr;
	}
	else
	{
		//<TODO>
	}
}

function uploadProjectFile($projectid,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	$id=$projectid;
	
	$target_dir = "uploads/";			//<TODO> Implement placement in a secure folder
	//echo "{$_FILES['filename']['tmp_name']}";

	$fileName = $_FILES['filename']['name'];
	$tmpName  = $_FILES['filename']['tmp_name'];
	$fileSize = $_FILES['filename']['size'];
	$fileType = $_FILES['filename']['type'];

/*$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
//$content = addslashes($content);
fclose($fp);
echo $content;*/
	
	
	$target_file = $target_dir . basename($_FILES["filename"]["name"]);		//<TODO> Check to confirm that the name of the file should be same as when the user uploaded, along with the extension name.
																			//<TODO> Implement name clash check to rename the files with same name as older files.
	//$uploadOk = 1;
	//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
		$q="insert into pm_projectuploads(p_id,pu_filename) values($pid,'$target_file')";		//<TODO> Testing and revision.
        return "[response=true,fileid={$gf_con->insert_id}]";
    } else {
        return "[response=false]";
    }
}

function removeUploadedFile($fileid,$isCallInternal)
{
		//<TODO>
}

function uploadProgress($progressId,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	
	//<TODO> Implement error handling.. return false response and msg.
	
	$key = ini_get("session.upload_progress.prefix") . $progressId;
	echo $key;
	if (!empty($_SESSION[$key])) 
	{
		$current = $_SESSION[$key]["bytes_processed"];
		$total = $_SESSION[$key]["content_length"];
		$p=($current < $total ? floor($current / $total * 100) : 100);
		if($isCallInternal==true)
			return $p;
		else
			return "[response=true,progress=$p]";
	}
	else 			 
	{
		echo "here";
		$p=100;
		if($isCallInternal==true)
			return $p;
		else
			return "[response=true,progress=$p]";
	}
}

function doesEmployerExist($email,$isCallInternal)
{
	
}

//<TODO> Implement restrictions, Only Marketer can add a new client. A new client can register himself though but then this function won't be called in that case.
//<TODO> Save u_referralemail as well.
function addEmployer($name,$email,$country,$notes,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal)
	
	if(doesEmployerExist($email,true)==true)
		return "[response=false,msg=Employer already exists.";
	
	global $gf_con;
	$q="insert into pm_users(u_name,u_email,u_notes,u_type,u_country) values('$name','$email','$notes',0,'$country')";
	$r=$gf_con->query($q);
	
	if($r)
	{
		return "[response=true]";
	}
	else
	{
		return "[response=false]";		//<TODO> provide a msg as well.
	}
}

function addAdditionalContact($email,$type,$value,$isCallInternal)	//return contact ID
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="inset into pm_additionalcontacts(u_email,ac_type,ac_detail) values('$email','$type','$value')";
	$r=$gf_con->query($q);
		//<TODO> check if query executed
	if($isCallInternal)
		return $gf_con->insert_id;
	else
		return "[response=true,contactid={$gf_con->insert_id}]";
}

function removeAdditionalContact($email,$type,$value,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="delete from pm_additionalcontacts where u_email='$email' and ac_type='$type' and ac_detail='$value'";		//<TODO> find row with less parameters such as without email
	$r=$gf_con->query($q);
		//<TODO> check if query executed
	if($isCallInternal)
		return true;
	else
		return "[response=true]";		
}

function removeAdditionalContact2($contactId,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="delete from pm_additionalcontacts where ac_id=$contactId";
	$r=$gf_con->query($q);
		//<TODO> check if query executed
	if($isCallInternal)
		return true;
	else
		return "[response=true]";	
}

function search($term,$tableName)
{
	//<TODO> check if $term is empty, and return nothing if it is.
	//<TODO> SQL Injection Attacks Prevention
	//<TODO> Implement sorting so that most relevent search results will appear first. One way relevance can be checked is by measuring the percent constitution of the term in the field. Higher percent means higher relevance.
	//<TODO> Implement search in other tables as well that are directly related to this table. 1 minor table is "Directly" related to major table if the information in the minor table should have been incorporated in the major table. 
	//<TODO> Implement condition to not check for fields that are not visible publically such as u_referralemail.
	global $gf_con;
	$q="show columns from $tableName";
	$r=$gf_con->query($q);
	
	$f=false;
	$qc="select * from $tableName where";
	while($row=$r->fetch_array())	//<TODO> Confirm if this works.
	{
		if(strpos($row['Type'],"var")===false and strpos($row['Type'],"text")===false) continue;
		if(strpos($row['Field'],"pass")===false); else continue;
		if($f)
		{
			$qc.=" or {$row['Field']} like '%$term%'";			
		}
		else
		{
			$f=true;
			$qc.=" {$row['Field']} like '%$term%'";
		}	
	}
	$r=$gf_con->query($qc);
	return $r;
}

function userSearch($term,$isCallInternal)
{
	//<TODO>
}

function assignProjectToManager($projectId,$isCallInternal)
{
	//Fill all the best managers to work first and award the worst managers last.
	//Treat new manager with no reputation as user of average ratings in terms of frequency of projects awarded, but below average ratings in terms of size of projects awarded, and below average ratings in terms of the number of concurrent projects.
	//Once in a while give chance to low rating users to lift themselves up, once in 3 months. If they perform average/well consistently for 5 projects, there previous bad reputation is overshadowed by their new performance. But overshadowing has to occur repeatedly, its effect should be lowered in each repeat.	
}

//This function is either called by manager, marketer, or automatically when manager stops responding. Its called automatically sooner if project is small+urgent, and later if project is big or not urgent.
function switchResponsibilityToAnotherManager()
{
	
}

function switchResponsibilityToAnotherCoder()
{
	
}

function openProjectForCoders($projectId,$isCallInternal)	//Only manager can call this
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="update pm_projects set p_openbidding=true where p_id=$projectId";
	$r=$gf_con->query($q);
	
	if($isCallInternal)		//<TODO> check if query executed
		return true;
	else
		return "[response=true]";
}

//Automatically called when project is assigned to a coder, when project is closed, or cancelled. Or can be called manually by Manager.
function closeProjectForCoders($projectId,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="update pm_projects set p_openbidding=false where p_id=$projectId";
	$r=$gf_con->query($q);
	
	if($isCallInternal)		//<TODO> check if query executed
		return true;
	else
		return "[response=true]";	
}

function coderPlacesBid($coderEmail,$projectId,$price,$numOfDays,$isCallInternal)	//return bid ID
{
	$isCallInternal=fixParam($isCallInternal);
	
	//<TODO> If coder has already placed bid on this project before, he cannot bid again, he can edit the bid though.
	//<TODO> if the project is closed for bidding, he cannot place a bid on this project.
	
	global $gf_con;
	$q="insert into pm_bids(u_email,p_id,b_price,b_numdays) values('$coderEmail',$projectId,$price,$numOfDays)";
	$r=$gf_con->query($q);
			//<TODO> check if query executed.
	if($isCallInternal)
		return $gf_con->insert_id;
	else
		return "[response=true,bidid={$gf_con->insert_id}]";
}

function coderEditsBid($bidId,$newPrice,$newNumOfDays,$isCallInternal)
{
	$isCallInternal=fixParam($isCallInternal);
	
	global $gf_con;
	$q="update pm_bids set b_price=$newPrice, b_numdays=$newNumOfDays where b_id=$bidId";
	$r=$gf_con->query($q);
			//<TODO> check if query executed
	if($isCallInternal)
		return true;
	else
		return "[response=true]";
}

function automaticProjectAssignmentToCoder($projectId,$isCallInternal)
{
	
}

function coderAcceptsProject($projectId,$uId,$isCallInternal)
{
	
}

//Manager can award the project to coder only if the coder is online currently 
function managerAwardsProjectToCoder($projectId,$coderId,$isCallInternal)
{
	
}

function coderInterestedInProject($projectId,$coderId,$isCallInternal)
{
	
}

//Request is accepted automatically if budget is decreased by coder.
//<TODO> give warning to coder if request is submitted for decrease.
function coderRequestManagerChangeBudget($projectId,$newBudget)
{
	
}

//Request is accepted automatically if budget is increased by manager.
//<TODO> give warning to manager if request is submitted for increase.
function managerRequestCoderChangeBudget($projectId,$newBudget)
{
	
}

//<TODO> Ratings system

//Coder or Manager or Marketer or Employer can request Withdrawal of payments.
//<TODO> Employee cannot withdraw less than $200, Employer can withdraw any amount.
function withdrawPayments($uId,$amount)
{
	
}

function makePayments($uId,$amount)
{
	
}

//Always Internal
function blacklistCoder($uId)	
{
	
}

//Will intelligently notify some available coders to assign the project for themselves. Wont spam all coders.
//Manager can choose manually if he first want to notify particular of his previous coders.
//Then other coders may be notified as well.
function notifyCodersOfProject($projectId,$isCallInternal) 
{
	
}

function addTimelineItem($projectId,$description,$milestoneAmount,$numOfDays,$isCallInternal)	//return timelineId
{
	
}

function removeTimelineItem($timelineId,$isCallInternal)
{
	
}

//Only Manager can call this function.
//Mark a timeline item as: Not Started, Waiting For Employer's Input, In Progress, Debugging, Completed/Waiting For Employer's Confirmation, Completed/Employer Confirmed.
function changeTimelineItemStatus($timelineId,$status,$isCallInternal)
{
	
}

//Only marketer can call this function.
//Mark a milestone as paid/unpaid
//<TODO> milestoneId is same as timelineId
function changeMilestoneStatus($milestoneId,$status,$isCallInternal)
{
	
}

//Only Manager and Employer can call this function.
//Request client/manager to approve of project's change of budget
//If client is trying to increase the budget, or if manager is trying to decrease the budget, then no need of approval, the request will get accepted automatically.
function requestChangeProjectBudget($projectId,$uId /*who initiated the request*/,$isCallInternal) //returns a requestId
{
	
}

//If request is created by manager, then only client can call this function. If request is made by client, then only manager can call this function.
//Employer/Manager accepts the budget change request.
//Marketer will be notified of the new budget.
function changeOfBudgetConfirmed($budgetChangeRequestId,$isCallInternal)
{
	
}

//Always Internal. 
function changeProjectBudget($projectId,$newBudget)
{
	
}

//Only manager can call.
//Manager requests employer to increase the timeline.
function requestToIncreaseProjectTimeline($projectId,$newNumDays,$isCallInternal)	//Returns requestId
{
	
}

//Can be called internally, or can be called by Employer
//Changes the project timeline
function increaseProjectTimeline($projectId,$newNumDays,$isCallInternal)
{
	
}

//Only Employer calls.
//Employer accepts the request to increase the timeline of project
function confirmIncreaseProjectTimeline($requestId,$isCallInternal)
{
	
}

//Automatically called when all milestones are paid and all timelines are marked completed, since any milestone is paid only after the stage is completed and tested by client.
//Manager and Employer can call this function manually.
//Change the status of the project to: Not Started, In Progress, Completed, Cancelled, Failed
//Manager can only change the status to: In Progress, Failed, Cancelled (Cancelled only if system knows that client hasn't responded for a long time, and has vanished completed)
//Employer can only change the status to: Completed, Failed (Employer can mark it failed so that it can be assigned to a new manager/coder)
function changeProjectStatus($projectId,$isCallInternal)
{
	
}

//<TODO> Only users connected by the same project can send msgs to each other. Also, coder can only msg to manager; manager can msg to marketer,coder,employer; marketer can msg to manager and employer; employer can msg to marketer and manager.
//<TODO> Msgs will appear in app's notification section.
function sendMsg($senderId,$receiveId,$msg)
{
	
}

//<TODO> users will be provided with a unique custom email address on which other users can email at. There is no restriction on which user can email who. Any user can email any user. The receiver will see the sender's email address as another custom email address generated by the app.
function emailMsg()
{
	
}

//<TODO> users will be provided with a unique custom email address on which other users can email at. There is no restriction on which user can email who. Any user can email any user. The receiver will see the sender's email address as another custom email address generated by the app.
function smsMsg()
{
	
}

function facebookMsg()
{
	
}

function timer()
{
	//controlled expansion of the company. Calculate how many more marketers/managers are needed next.
	
	//
}


//Always External Call
function displayVariables()	
{
	//usually "PHP_SESSION_UPLOAD_PROGRESS"
	$v1=ini_get("session.upload_progress.name");		//<TODO> Check for failure
	return "[response=true,session.upload_progress.name={$v1}]";
}

function displaySessionName()	//test function
{
	if(isset($_SESSION["email"])==true) return $_SESSION["email"]; else return "";
}

function test()
{
	$target_dir = "uploads/";
	echo "{$_FILES['filename']['tmp_name']}";

$fileName = $_FILES['filename']['name'];
$tmpName  = $_FILES['filename']['tmp_name'];
$fileSize = $_FILES['filename']['size'];
$fileType = $_FILES['filename']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
//$content = addslashes($content);
fclose($fp);
echo $content;
	
	
	$target_file = $target_dir . basename($_FILES["filename"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["filename"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

}




?>


