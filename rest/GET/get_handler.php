<?php
    include '../dbConnect.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

    $dbConnection = connectToDB();
    $query = 'SELECT * FROM `column`';

    if(!($result = @mysqli_query($dbConnection, $query))) 
    {
		$response = array(
			'RESULT' => 'ERROR',
			'MESSAGE' => 'Ha habido un error realizando su petición',
			'DEBUGMESSAGE' => mysqli_error($dbConnection)
		);
			
		SendResponse(0, $response);
    }
    
    $counter = 0;
    $response = array();
    while($row = mysqli_fetch_assoc($result))
    {
        $response[$counter] = $row;
        $counter ++;
    }

    SendResponse(1, $response);
    
    function SendResponse($type, $body)
	{
		switch($type)
		{
			case 0:
				http_response_code(500);
				$response = array('RESPONSE_CODE' => 501, 'RESPONSE_TYPE'=>'INTERNAL SERVER ERROR');
				$response['BODY'] = $body; 
				print json_encode($response);
			break;

			case 1:
				http_response_code(200);
				$response = array('RESPONSE_CODE' => 200, 'RESPONSE_TYPE'=>'OK');
				$response['BODY'] = $body; 
				print json_encode($response);
			break;
		}
	}
?>