<?php
    include '../dbConnect.php';
    include '../responseSender.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

    $dbConnection = connectToDB();

    $dataquery = mysqli_real_escape_string($dbConnection, $_GET['param']);

    $query = "SELECT DISTINCT $dataquery FROM `column`";

    if(!($result = @mysqli_query($dbConnection, $query)))
    {
        $response = array(
            'RESULT' => 'ERROR',
            'MESSAGE' => 'Ha habido un problema en la búsqueda de parámetros',
            'DEBUGMESSAGE' => mysqli_error($dbConnection)
        );

        SendResponse(0, $response);
        return false;
    }

    $response = array();

    while($row = mysqli_fetch_assoc($result))
    {
        array_push($response, $row[$dataquery]);
    }

    SendResponse(1, $response);

?>