<?php
/*
Architecture:
Rules -
	Compression functionality is provided for faster uploads. User is warned of lossy compression when he opts for compression.
	
	Files are uploaded for projects, references, as well as for sending msgs or chats.
	
Interface:
compressFile($filePath)		//Client Side
Permission: Manager, Coder, Employer, Marketer
Description: Compresses the file before uploading

uploadFileInMessage($toEmail)
Permission: Manager, Coder, Marketer, Employer
Description: The file can be see only by the one who is connected to the uploader directly.

uploadFileInProject($projectId)
Permission: Manager, Coder, Marketer, Employer
Description: If coder uploads a file, only the manager can see it unless the manager validates it so that the employer (as well as marketer) can see it too. If the employer uploads the file only the manager (as well as the marketer) can see it unless the manager validates the file in which case coder can see it too. If marketer uploads the file, employer as well as manager can see it and once the manager validates the file, the coder can see it too. If the manager uploads the file, everybody can see it.

validateUploadFile($fileId)
Permission: Manager
Description: If coder uploads the file, then manager can validate the file so that it will be visible to the employer and he will get notification abt it too. If the employer uploads the file, then the manager can validate the file so that the coder will be able to access the file and he will get notification abt it too.

invalidateUploadFile($fileId,$explanation)
Permission: Manager
Description: If the manager doesnt validate, it will be same as invalidating. However, if the manager wants the coder want to actually upload the file for the employer to see but has few concerns about it, then he can mention those concerns in the $explanation so that the coder can take care of the concerns and upload the file again. Invalidation can be only called on a file which is uploaded by a coder and not employer.

*/
?>