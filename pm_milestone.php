<?php
/*
Interface:
createMilestoneByAmount($projectId,$amount,$description)
Permission: Employer, Manager
Description: Create an empty milestone.

createMilestoneByPercentage($projectId,$perentage,$description)
Permission: Employer, Manager
Description: Create an empty milestone.

fundMilestoneByID($milestoneId)
Permission: Employer only.
Description: Funds a milestone if Own account has enough money.

fundMilestoneByAmount($projectId,$amount)
Permission: Employer only.
Description: Fill earliest milestone first with the amount, and go on forth. Funds only if Own account has enough money.

releaseMilestoneById($milestoneId)
Permission: Employer only.
Description: Releases the milestones in order to pay for the project. This money will be available to the manager to release to the coder. The manager or marketer cannot withdraw until the project is completed and coder is paid. Cannot release an empty or partially funded milestone. If the project is fully paid, the project is marked compelete.

releaseMilestoneByAmount($projectId,$amount)
Permission: Employer only.
Description: Releases money only enought funds are there in the milestones for the project (and not including the funds of Own account). Earliest milestone is released first. If the project is fully paid, the project is marked compelete.

canMakePayment($projectId,$amount)
Permission: Employer only.
Description: Returns true if the employer has enough funds in milestones of the project and/or in his Own account to make the payment of amount $amount. Else returns false.

canFundMilestone($p)
Permission: Employer only.
Description: Returns true if the employer has enough funds in Own account.

makePayment($projectId,$amount)
Permission: Employer only.
Description: First the amount will be deducted from all the precious milestones that have been created. The balance will be deducted from the employer's Own account. If the project is fully paid, the project is marked compelete.

cancelMilestoneById($milestoneId)
Permission: Manager Only.
Description: Cancels the milestones amount so it will be returned to the employer's Own account.

cancelMilestoneByAmount($projectId,$amount)
Permission: Manager Only.
Description: Cancels the milestones amount so it will be returned to the employer's Own account. Latest milestone is emptied first.

deleteMilestone($milestoneId)
Permission: Manager, Employer (both can delete milestones created by each other)
Description: Delete an empty milestone. If the milestone is fully or partially funded then it cannot be deleted.

editMilestone($milestoneId,$newAmount,$description)
Permission: Manager, Employer.
Description: The description can be changed without permission. If the milestone is empty, the amount can be changed to anything, except zero. If the milestone is fully or partially funded, the amount can be changed to anything above the amount by which its funded.

disputeMilestone($milestoneId)
Permission: Employer, Manager (only if certain conditions are met)
Description: Dispute a milestone. Employer can dispute a milestone anytime. But Manager can dispute only if employer stops responding for a while, and the milestones will be released only if there are proofs that the coder and manager finished the work.

releaseAmountToCoder($projectId,$amount)
Permission: Manager
Description: Releases amount to coder from the amount that the employer has released for the project so far.

canReleaseAmountToCoder($projectId,$amount)
Permission: Manager
Description: Checks whether the amount can be released to the coder from the amount that the employer has released for the project so far.

*/
?>