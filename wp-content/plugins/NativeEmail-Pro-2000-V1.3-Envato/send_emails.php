<?php

	
/**
    EventSource is documented at 
    http://dev.w3.org/html5/eventsource/
*/
 
//a new content type. make sure apache does not gzip this type, else it would get buffered
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
 
/**
    Constructs the SSE data format and flushes that data to the client.
*/
function send_message($id, $message, $progress) 
{
	foreach (getallheaders() as $name => $value) {
			$var =  "$name: $value\n";
		}
    $d = array('message' => $message , 'progress' => $progress , 'var' => $var);
     if(file_exists("../../../wp-blog-header.php")){
		//require_once('../../../wp-blog-header.php');
	}
	else{
		die("unable to process this request");
	}
     
    //PUSH THE data out by all FORCE POSSIBLE
    #ob_flush(); 
	
    echo "id: $id" . PHP_EOL;
		
		

    echo "data: " . json_encode($d) . PHP_EOL;
    echo PHP_EOL;
	
	ob_flush();
    flush();
}
 
$serverTime = time();
 
//LONG RUNNING TASK
for($i = 0; $i < 10; $i++)
{
    send_message($serverTime, 'server time: ' . date("h:i:s", time()) , ($i+1)*10); 
     
    //Hard work!!
    sleep(1);
}
 
send_message($serverTime, 'TERMINATE'); 