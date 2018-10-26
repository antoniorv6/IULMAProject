<?php
	include '../dbConnect.php';
	include '../responseSender.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

    $dbConnection = connectToDB();

    $id = "'". $_GET['id']."'";

    $query = "SELECT * FROM additionaldata WHERE Article = ". $id;

    if(!($result = @mysqli_query($dbConnection, $query))) 
		{
			$response = array(
				'RESULT' => 'ERROR',
				'MESSAGE' => 'Ha habido un error buscando los parámetros adicionales',
				'QUERY' => $query,
				'DEBUGMESSAGE' => mysqli_error($dbConnection)
			);	
			SendResponse(0, $response);
        }
    $counter = 0;
    $response = array();
    while($row = mysqli_fetch_assoc($result))
    {
            array_push($response,$row);
    }
    
    SendResponse(1, $response);
    
?>