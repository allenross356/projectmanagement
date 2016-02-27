<?php

//<TODO> Implement reference marker in the conversation, chat, questions etc. which can used to point out part when support team is involved in a dispute.

/*
https://www.whatsapp.com/faq/en/iphone/23559013
*/

//Software Architecture Videos
//https://www.youtube.com/watch?v=R6GKgJb9eLs&index=2&list=PLhwVAYxlh5dusp7Y8-K-V0azc_KsCohEg

/*
Interface:
createMessage($toEmail,$msg)
Permission: Coder, Manager, Employer, Marketer
Description: User can send msg directly related to him through a project. If one coder of a project sends msg to another coder of the same project, the manager will be able to see the msgs as well.

canSendMessage($toEmail)
Permission: Coder, Manager, Employer, Marketer
Description: This calls tells whether the user can send msg to a particular user or not.

validateMessage($msgId,$newMsg=null)
Permission: Manager
Description: If the msg is created by coder, the $newMsg will be forwarded to the employer. If $newMsg is null, then original msg will be used in that place. If the msg is created by employer, then the $newMsg will be forwarded to the coder.

getHiredCodersOfProject($projectId)
Permission: Coder hired for the project.
Description: Gets the list of all the coders (their email) who are hired for the project.

createGroupMessage($projectId,$msg)
Permission: Coder
Description: The coder can send the msg to all the coders of the project. The manager of the project can see these msgs too.

createGroupMessage2($toEmails,$msg)
Permission: Coder
Description: The coder can send msg to multiple coders of the project. The manager of the project can see theese msgs too.

*/

/*public int*/ function createMessage(/*string*/ $fEmail,/*string*/ $tEmail,/*string*/ $msg)
{
	$g=get_dbconnection();
	if($g->connect_error) return db_error_code();	
	$r=$g->query("insert into pm_messages(m_msg,m_fromemail,m_toemail) values('$msg','$fEmail',$tEmail')");
	if($r)
		return $g->insert_id;
	else
		return query_error_code();
}

function fetchMessages($uEmail)
{
	
}

function fetchMessagesFrom($uEmail,$fEmail)
{
	
}

function sendEmail()
{
	
}

function sendMessageOnFacebook()
{
	
}

function sendMessageOnTwitter()
{
	
}

function sendMessageOnWhatsapp()
{
	
}

function sendSMS()
{
	
}

?>