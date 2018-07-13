<?php
    
    include '../dbConnect.php';

    header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
    
    $response = null;
    $dbConnection = connectToDB();
    //Vamos a hacer la consulta para ver si se puede hacer login

    //Depuramos variables
    $depuredMail = mysqli_real_escape_string($dbConnection, $_GET['user']);


    $mail = '"'.$depuredMail.'"';
    $query = 'DELETE FROM session WHERE email = '.$mail;

    if(!($resultado = @mysqli_query($dbConnection, $query))) 
    { 
        print json_encode("<p>Error al ejecutar la sentencia <b>$query</b>: " . mysqli_error($dbConnection));
        exit; 
    }
    else
    {
        SendResponse(1, 'logout ok');
    }

    function SendResponse($type, $body)
	{
		switch($type)
		{
			case 0:
				http_response_code(401);
				$response = array('RESPONSE_CODE' => 401, 'RESPONSE_TYPE'=>'UNAUTHORIZED');
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