<?php

	if(!isset($_REQUEST['endpoint']) || !isset($_REQUEST['query']) || !isset($_REQUEST['callback'])){
		header("Content-type: text/html");
		echo 'The variables <em>endpoint</em>, <em>query</em> and <em>callback</em> cannot be null. Parameters in request:<br />';
		foreach($_REQUEST as $param => $value){
			echo ($param . ": " . $value . "<br />");
		}
		die();
	}
		
	header("Content-type: application/javascript");
	
	$req = $_REQUEST['endpoint'] . "?query=" . urlencode($_REQUEST['query']) . "&format=json";
	//$stri=$_REQUEST['callback']."(";	
	
	// init cURL-Handle
	$ch = curl_init();

	// set URL and headers
	curl_setopt($ch, CURLOPT_URL, $req);
	curl_setopt($ch, CURLOPT_HEADER, false); //  header output OFF
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/sparql-results+json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);


	$source= curl_exec($ch);
	// that's all folks
	if(substr($source, 0, 1) !== "{") {
	   $source="{".$source."}";
	}

	curl_close($ch);

	echo $_REQUEST['callback']."(".$source.")";
		
?>