<?php
/*
Interface:
requestTempLeave($numDays,$explanation,$projectId)
Permission: Manager or Coder.
Description: Manager or Coder may apply for a leave request.

editLeaveRequest($leaveId,$newNumDays,$newExplanation)
Permission: Creator of the leave request.
Description: If the leave request is not granted or denied yet, the request can be edited by the creator of the request.

deleteLeaveRequest($leaveId)
Permission: Creator of the leave request.
Description: If the leave request is not granted or denied yet, the request can be deleted by the creator of the request.

validateLeaveRequest($leaveId,$newExplanation=null)
Permission: Manager of the coder who created the leave request.
Description: Manager can validate the leave request created by the coder of his project so that the request will be visible to the employer.

requestLeaveExtension($leaveId,$additionalNumDays,$explanation)
Permission: Creator of the leave request.
Description: Creator of the leave can request to extend the leave.

extendTempLeave($leaveId,$additionalNumDays)
Permission: Employer
Description: Employer can extend the leave period of the employee.

reduceTempLeave($leaveId,$reduceByNumDays)
Permission: Leave requestor
Description: The employee can reduce the leave period for himself.

grantLeaveRequest($leaveId)
Permission: Employer of the creator of the leave.
Description: The employer can grant the leave request.

denyLeaveRequest($leaveId)
Permission: Employer
Description: The employer can deny the manager's or coder's leave request, in which case the creator of the leave request can choose to reassign his responsibility to someone else, or he will be penalized if the project is delayed due to him.

goForVacation()
Permission: Any Employee.
Description: The employee can call this once he has no more projects to worry about. Or he can call this once he doesn't want any more projects so that once his current projects and responsibilities are over, he could go on a vacation.

backToWork()
Permission: Any Employee who 'wentForVacation' or had to leave in emergency.
Description: This will expire all the leave requested created by the caller of this function.

emergencyLeave($expectedNumDays,$explanation)
Permission: Any Employee
Description: If coder calls this function, the manager and employer will be notified of this. It will penalize the caller of the function. The manager or employer have an option to reassign the project/responsibilities to someone else. The first call will be penalized with negligible amount, and each subsequent calls will be penalized with progressively increased amount.


*/
?>