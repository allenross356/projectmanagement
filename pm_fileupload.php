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

uploadFileInMessage($projectId)
Permission: Manager, Coder, 
Description:

uploadFileInProject($projectId)
Permission:
Description:

*/
?>