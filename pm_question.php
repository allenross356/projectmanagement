<?php
/*
Interface:
createComment(string $title,$projectId,Array $references,$parentCommentId)
Permission: Coders can create root comment (or question) or sub comments (or sub questions, or answers). Manager and Employer can create only sub comments (or sub questions, or answers).
Description: Create a question, or discussion topic, or an answer to question, or a comment. If coder creates the comment, its obviously for manager/employer. If employer creates a comment, its obviously only for coder(s). If manager creates a comment, it will be obviously for whoever he replies to. Every a time a non-manager creates a comment, the manager will be notified of it. Every time a manager creates a comment, the receiver of the comment will be notified. If manager creates the comment, the comment is automatically validated, whereas if the non-manager creates a comment, it must be validated by the manager.

createReComment() <TODO>

hideComment($commentId,$response=null,Array $responseReferences=null)
Permission: Manager or Comment Creator.
Description: If the creator of the comment hides the comment, then comment goes in "Draft" mode. Only he (and manager) can see and edit it. If the coder created the comment and manager hides it with a response, the coder will be notified of this activity, and the comment will go in "Invalidated" mode. If the employer creates a comment, and manager hides it then the employer will NOT be notified.

editComment($commendId,$newTitle,$newReferences)
Permission: Manager or Comment Creator.
Description: Edits the comment.

markCommentRepeat($commentId,$response,Array $references)
Permission: Manager of the project only.
Description: Marks the comment repeat, and doesn't let it go live. The manager also leaves a response and references to the answers from the old questions.

validateComment($commentId,$response=null,Array $responseReferences=null)
Permission: Manager only.
Description: If the comment is created by employer or manager himself (for coder), the comment will go visible, and the involved coder(s) will be notified of it. If the comment is created by coder or manager himself (for employer), the comment will go visible and employer will be notified of it. However, if the $response is not null, then the receiver won't be notified, and instead the manager's response will be sent back to the sender.




*/
?>