<?php
/*
Interface:
requestTempLeave($numDays,$explanation,$projectId)
Permission: Manager or Coder.
Description: 

editLeaveRequest($leaveId,$newNumDays,$newExplanation)
Permission: Creator of the leave request.
Description: If the leave request is not granted or denied yet, the request can be edited by the creator of the request.

deleteLeaveRequest($leaveId)
Permission: Creator of the leave request.
Description: If the leave request is not granted or denied yet, the request can be edited by the creator of the request.

validateLeaveRequest($leaveId)
Permission: Manager can validate the leave request created by the coder of his project.
Description: 

editLeaveRequestByValidator($leaveId,$newExplanation)


requestLeaveExtension($leaveId,$additionalNumDays,$explanation)
Permission: Creator of the leave request.
Description: 

extendTempLeave($leaveId,$additionalNumDays)
Permission: 
Description:


grantLeaveRequest($leaveId)
Permission: If leave request was created by the 

denyLeaveRequest
Permission:

goForVacation()
Permission: Any Employee.
Description: 

backToWork()
Permission: Any Employee.
Description: This will expire all the leave requested created by the caller of this function.

emergencyLeave()
Permission:
Description:

Chron:
Check for employees who haven't yet turned from leave yet.
*/
?>