<?php
	include 'DataParser.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
	header("Content-Type: application/json");
	
	move_uploaded_file($_FILES["archivo"]["tmp_name"], "../../uploaded/".$_FILES["archivo"]["name"]);

	$fileHandler = new DataParser("../../uploaded/".$_FILES["archivo"]["name"]);
	$string = $fileHandler->convertToText();

	$response = array('CONTENT' => $string);
	http_response_code(200);
	print json_encode($response);
?>