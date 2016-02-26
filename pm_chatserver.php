<?php

	//<TODO> implement client and server communication with each client
	//<TODO> implement special char: $specialChar="-*#-(#";  to split headers and msgs.
	//<TODO> assign each client to each client intelligently: (1) 2 clients who know each other from before, give them preference to let them talk to each other, if there previous projects went well together, otherwise don't give them preference. (2) Don't assign more than 2 employers to each available employee.
	//<TODO> implement limit on number of characters sending in each call.
	//<TODO> check the data before sending to make sure that a non-assigned client is not sending the data to a wrong client.
	//<TODO> don't sent empty msgs to clients.. ignore them

	$specialChar="-*#-(#";
	
	set_time_limit(30);		//<TODO> Confirm what happens if 2 instances of same php script run in parallel.

	function argProcess($arr)
	{
		global $specialChar;
		$r="";
		$c=0;
		foreach($arr as $key=>$val)
		{
			if($c==0)
			{
				$c=1;
				$r.=$val;
			}
			else
				$r.=$specialChar . $val;
		}
	}
	
	class SimpleKeyFacilitator
	{
		private $c=0;
		private $recycledKeyList=array();
		private $rCount=0;
		
		public function getNewKey()
		{
			if($this->rCount==0)
			{
				$this->c+=1;
				return $this->c-1;
			}
			else
			{
				$this->rCount-=1;
				$i=$this->recycledKeyList[$this->rCount];
				unset($this->recycledKeyList[$this->rCount]);
				return $i;
			}
		}
		
		public function recycleKey($key)
		{
			$this->recycledKeyList[]=$key;
			$this->rCount+=1;
		}
	}
	
	class chatServer
	{
		private $k=new SimpleKeyFacilitator();
		private $clients = array();
		private $clientIds=array();
		private $similarClientLists=array();
		private $port = 9050;

		function removeClient($key)
		{
			$k=&$this->k;		//<TODO> optimize by removing the references and using the variables directly.
			$clients=&$this->clients;
			$clientIds=&$this->clientIds;
			$similarClientLists=&$this->similarClientLists;
			unset($similarClientLists[array_search($key,$similarClientLists[$key]]);
			foreach($similarClientLists[$key] as $x) 
				unset($similarClientLists[$x][array_search($key,$similarClientLists[$x])]); 
			unset($clientIds[$key]);
			unset($clients[$key]);
			unset($similarClientLists[$key]);
			$k->recycleKey($key);
		}
		
		function sendMsg($sender_sock,$senderId,$receiverId,$dataForItself,$dataForSender,$dataForReceiver)
		{
			$clients=&$this->clients;
			$clientIds=&$this->clientIds;
			$similarClientLists=&$this->similarClientLists;
			if($dataForReceiver===false);
			else
			{
				$key=array_search($receiverId,$clientIds);
				foreach($similarClientLists[$key] as $x)
					socket_write($clients[$x],$dataForReceiver);
			}
			if($dataForItself===false && $dataForSender===false); else
			{
				$key=array_search($senderId,$clientIds);
				foreach($similarClientLists[$key] as $x)
				{
					if($clients[$x]==$sender_sock)
					{
						if($dataForItself===false);else
							socket_write($clients[$x],$dataForItself);
					}
					else
					{
						if($dataForSender===false);else
							socket_write($clients[$x],$dataForSender);
					}
				}
			}
		}
		
		function run()
		{
			global $specialChar;
			$k=&$this->k;
			$clients=&$this->clients;
			$clientIds=&$this->clientIds;
			$similarClientLists=&$this->similarClientLists;
			$port=&$this->port;
			
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);		
			socket_bind($sock, 0, $port);
			socket_listen($sock); 
			$i=$k->getNewKey();
			$clients[$i]=$sock;
			$clientIds[$i] = "__SERVER__";
			$similarClientLists[$i]=array($i);
			while (true) 
			{
				$read = $clients; 
				$write=null;
				$except=null;
				$sc=socket_select($read, $write, $except, 0); 
				if ($sc <1) continue;
				if (in_array($sock, $read)) 
				{ 
					$i=$k->getNewKey();
					$clients[$i] = $newsock = socket_accept($sock);
					$clientIds[$i]="";
					$similarClientLists[$i]=array($i);
					$key = array_search($sock, $read); 
					unset($read[$key]); 
				}
				foreach ($read as $readkey=>$read_sock) 
				{
					$data = @socket_read($read_sock, 1024, PHP_NORMAL_READ);
					//NOTE: $data format is always- "{$Msg_to}{$specialChar}{$MsgId}{$specialChar}{$Msg}" or "{$Msg_to}{$specialChar}{$requestId}{$specialChar}{$Msg}"
					//								 $Msg_to  will always be either an email representing a user_client or "__SERVER__" representing the msg is a query to server.
					if ($data === false) 	//If client is disconnected
					{
						$key = array_search($read_sock, $clients);
						$this->removeClient($key);
						//<TODO> Notify other clients who were previously connected with this client.
						continue;
					}
					$data = trim($data);
					if (!empty($data)) 
					{  
						$senderClientId=$clientIds[$readkey]; 
						$d = explode($specialChar,$data); 
						if($d[0]=="__SERVER__")		//If msg is for server.
						{
							$reqId=$d[1]; $param=$d[2];
							if($reqId=="clientid")
							{
								$key=array_search($read_sock,$clients);
								$key2=array_search($param,$clientIds);
								$clientIds[$key]=$param;
								if($key2===false)
								{
									$similarClientLists[$key]=array($key);
								}
								else
								{
									foreach($similarClientLists[$key2] as $x)
									{
										$similarClientLists[$x][]=$key;
									}
									$similarClientLists[$key]=$similarClientLists[$key2];
								}
							}
							//<TODO> now since client has identified himself, let him know which other clients are available online that he can connect to.
						}
						elseif($d[0]=="__CLIENT__")
						{
							$reqId=$d[1]; $senderId=$d[2]; $msgId=$d[3];
							if($reqId=="msgreceived")	 //receiver sends a msg back to confirm msg receipt.
							{
								//<TODO> multiple devices from same receiver may send confirmation of receipt. sending Client shud handle gracefully.
								//<TODO> let the sender know that receiver received the msg
								//<TODO> implement on client side, so that all of the sender's devices will be notified of msgreceived.
								$this->sendMsg($read_sock,$senderClientId,$senderId,false,false,argProcess(array("__CLIENT__",$reqId,$msgId)));
							}
							elseif($reqId="msgseen")	//receiver sends a msg back to confirm that user from receiver device actually saw/acted on the msg.
							{
								//<TODO> implement on client side, so that any of the receiver's devices may confirm msgseen.
								//<TODO> implement on client side, so that all of the sender's devices will be notified of msgseen.
								//<TODO> implement on client side, so that all of the sender's devices will be notified of msgreceived.								
								$this->sendMsg($read_sock,$senderClientId,$senderId,false,false,argProcess(array("__CLIENT__",$reqId,$msgId)));
							}
						}
						else
						{
							$receiverClientId=$d[0]; $msgId=$d[1]; $msg=$d[2];
							$this->sendMsg($read_sock,$senderClientId,$receiverClientId,argProcess(array("__SERVER__","msgreceived",$msgId)),argProcess(array($senderClientId,$receiverClientId,$msgId,$msg)),argProcess(array($senderClientId,$msgId,$msg)));
							/*
							foreach ($clients as $writekey=>$send_sock) 
							{ 
								if ($send_sock == $sock || ($clientIds[$writekey]!=$receiverClientId && $clientIds[$writekey]!=$senderClientId)) continue;
								if($send_sock == $read_sock)	//sender itself
								{
									socket_write($send_sock,argProcess(array("__SERVER__","msgreceived",$msgId)));		//sender will know that the server received and processed the msg.
								}
								elseif($clientIds[$writekey]==$receiverClientId)	//one of the receiver's devices
								{
									socket_write($send_sock, argProcess(array($senderClientId,$msgId,$msg)));		//receiver will receive the msg from the sender 				
								}
								elseif($clientIds[$writekey]==$senderClientId)		//another device of sender
								{
									socket_write($send_sock, argProcess(array($senderClientId,$receiverClientId,$msgId,$msg)));		//other devices from sender will know what msg sender sent and to whom 
								}
							} 
							*/
						}
					}			   
				} 
			}
			socket_close($sock);
		}
	}
/*
Server:
__SERVER__, clientid, <clientId>	//when client is providing server with its user's name.		<DONE>
__CLIENT__, msgreceived, <senderId>, <msgId>	//when client is letting server know that it received a sender's msg.	<DONE>
__CLIENT__, msgseen, <senderId>, <msgId>		//when client is letting server know that user saw the received msg.	<DONE>
<receiverClientId>, <msgId>, <msg>  //when client is sending another client a msg.		<DONE>

Client:
<senderClientId>, <msgId>, <msg>	//when client is notified of a msg from another client		<DONE>
<itselfId>, <receiverClientId>, <msgId>, <msg>	//when a client is notified that same user has sent a msg to another user from another device.	<DONE>
__SERVER__, msgreceived, <msgId>	//when server is letting a client know that it has received and processed a msg that the client is trying to send to another client.	<DONE>
__SERVER__, getclients		//when server is providing client information about which other clients are currently online
__CLIENT__, msgreceived, <msgId>	//when receiver client is letting a sender client know that it has received a msg.	<DONE>
__CLIENT__, msgseen, <msgId>	//when receiver client is letting a sender client know that user has seen or acted on a msg.	<DONE>
*/
?>