<?php

	//<TODO> implement client and server communication with each client
	//<TODO> implement special char: $specialChar="-*#-(#";  to split headers and msgs.
	//<TODO> assign each client to each client intelligently: (1) 2 clients who know each other from before, give them preference to let them talk to each other, if there previous projects went well together, otherwise don't give them preference. (2) Don't assign more than 2 employers to each available employee.
	//<TODO> implement limit on number of characters sending in each call.
	//<TODO> check the data before sending to make sure that a non-assigned client is not sending the data to a wrong client.
	//<TODO> don't sent empty msgs to clients.. ignore them

	$specialChar="-*#-(#";
	
	set_time_limit(30);		//<TODO> Confirm what happens if 2 instances of same php script run in parallel.

	
    $port = 9050;
   
    // create a streaming socket, of type TCP/IP
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
   
    // set the option to reuse the port
    socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
   
    // "bind" the socket to the address to "localhost", on port $port
    // so this means that all connections on this port are now our resposibility to send/recv data, disconnect, etc..
    socket_bind($sock, 0, $port);
   
    // start listen for connections
    socket_listen($sock); 

    // create a list of all the clients that will be connected to us..
    // add the listening socket to this list
    $clients = array($sock);
	



	
	
    while (true) {
		// create a copy, so $clients doesn't get modified by socket_select()
        $read = $clients; 
	   
        // get a list of all the clients that have data to be read from
        // if there are no clients with data, go to next iteration
		$write=null;
		$except=null;
		
		$sc=socket_select($read, $write, $except, 0); 
        if ($sc <1)
            continue;
       
        // check if there is a client trying to connect
        if (in_array($sock, $read)) { 
            // accept the client, and add him to the $clients array
			$clients[] = $newsock = socket_accept($sock); 

            // send the client a welcome message
            socket_write($newsock, "no noobs, but ill make an exception :)\n".
            "There are ".(count($clients) - 1)." client(s) connected to the server\n");
			echo "New connection<br>";
           
            socket_getpeername($newsock, $ip);
            echo "New client connected: {$ip}<br>";
           
            // remove the listening socket from the clients-with-data array
            $key = array_search($sock, $read); 
            unset($read[$key]); 
        }
       
        // loop through all the clients that have data to read from
        foreach ($read as $read_sock) {
            // read until newline or 1024 bytes
            // socket_read while show errors when the client is disconnected, so silence the error messages
            $data = @socket_read($read_sock, 1024, PHP_NORMAL_READ);
			//NOTE: $data format is always- "{$Msg_to}{$specialChar}{$MsgId}{$specialChar}{$Msg}" or {$Msg_to}{$specialChar}{$requestId}{$specialChar}{$Msg}"
			//								 $Msg_to  will always be either an email representing a user_client or "__SERVER__" representing the msg is a query to server.
           
            // check if the client is disconnected
            if ($data === false) {
                // remove client for $clients array
                $key = array_search($read_sock, $clients);
                unset($clients[$key]);
                echo "client disconnected.<br>";
                // continue to the next client to read from, if any
                continue;
            }
           
            // trim off the trailing/beginning white spaces
            $data = trim($data);
			
            // check if there is any data after trimming off the spaces
            if (!empty($data)) {
				
				echo "Data received: $data<br>";
				
				// send this to all the clients in the $clients array (except the first one, which is a listening socket)
				foreach ($clients as $send_sock) {
			   
					// if its the listening sock or the client that we got the message from, go to the next one in the list
					if ($send_sock == $sock || $send_sock == $read_sock)
						continue;
				   
					// write the message to the client -- add a newline character to the end of the message
					socket_write($send_sock, $data);
				   
				} // end of broadcast foreach
		   
               
				echo "Data sent to everyone!<br>";
            }
           
        } // end of reading foreach
    }

    // close the listening socket
    socket_close($sock);
	echo "Socket closed\n";
?>