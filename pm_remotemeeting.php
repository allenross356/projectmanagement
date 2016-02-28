<?php

/*
Interface:
createRemoteMeetingRequest($projectId,$scheduleDescription)
Permission: Employer only.
Description: Employer can create a request of remote meeting with the coder. This meeting has to be invigilated by the manager or any other non-associated and non-partial employee.

deleteMeetingRequest($meetingId)
Permission: Creator of meeting
Description: Creator of meeting can delete the request.

handleMeeting($meetingId)
Permission: Manager, Marketer
Description: If both coder and employer are online but manager is absent even after the time past of the scheduled meeting, then the meeting will opened for other managers and marketers to handle. Any of the currently online managers and marketers can choose to handle the meeting. They will be compensated after the project's completion or payments accordingly. Only those managers and marketers will be able to grab a meeting who have completed the meeting handling crash course.

coderScheduleForMeeting($meetindId,$scheduleDescription)
Permission: Coder
Description: When meeting is requested by the employer, the coder can specify his schedule so that the coder and employer could agree on one time to hold the meeting.

proposeTimeForMeeting($meetingId,$time)
Permission: Employer, Coder
Description: Coder or Employer could propose a time to meet.

counterProposeTimeForMeeting($meetingId,$time)
Permission: Employer, Coder
Description: If coder proposed a time to meet the employer could counter propose if the proposed time doesn't suit him. If employer proposed a time to meet the code could counter propose if the proposed time doesn't suit him.

agreeProposedTimeForMeeting($meetingProposedTimeId)
Permission: Employer, Coder
Description: If the coder proposed or counter proposed a time, the employer could agree to the proposal. If the employer proposed or counter proposed a time, the coder could agree to the proposal. 

*/
?>