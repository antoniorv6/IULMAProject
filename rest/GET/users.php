<?php 
    include '../dbConnect.php';

    $dbConnection = connectToDB();
    $query = 'SELECT * FROM editor'; 

    if(!($resultado = @mysqli_query($dbConnection, $query))) 
    { 
        print json_encode("<p>Error al ejecutar la sentencia <b>$query</b>: " . mysqli_error($dbConnection));
        exit; 
    }
    
    $counter = 0;
    $response = array();
    while($row = mysqli_fetch_assoc($resultado))
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