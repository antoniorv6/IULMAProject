<?php 

	$var = $_GET['q'];
	http_response_code(200);
	print json_encode($var);
?>