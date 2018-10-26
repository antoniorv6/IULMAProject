<?php

    include '../dbConnect.php';
	include '../responseSender.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

    $dbConnection = connectToDB();

    $updateQuery = $_GET['query'];

    if(!($result = @mysqli_query($dbConnection, $updateQuery))) 
	{
		$response = array(
			'RESULT' => 'ERROR',
			'MESSAGE' => 'Ha habido un error realizando su petición',
			'DEBUGMESSAGE' => mysqli_error($dbConnection)
		);
			
		SendResponse(0, $response);
    }

    $response = array(
        'RESULT' => 'OK',
        'MESSAGE' => 'Los datos han sido actualizados correctamente',
    );

    SendResponse(1, $response);
?>