<?php
    //Con el GET verificamos si el usuario es un administrador
    include '../dbConnect.php';

    header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
    
    $dbConnection = connectToDB();
    
    $depuredMail = mysqli_real_escape_string($dbConnection, $_GET['email']);
    $mail = '"'.$depuredMail.'"';
    $query = 'SELECT COUNT(email) AS userExists FROM administrator WHERE email like '.$mail;

    if(!($resultado = @mysqli_query($dbConnection, $query))) 
    { 
        print json_encode("<p>Error al ejecutar la sentencia <b>$query</b>: " . mysqli_error($dbConnection));
        exit; 
    }
    else
    {
        $userExists=mysqli_fetch_assoc($resultado);
        
        if($userExists['userExists'] == 1)
        {
            //TODO -> Mandar un buen true
            $userinfo = array(
                'EXISTS' => true
            );
            SendResponse(1, $userinfo);
        }
        else
        {
            $userinfo = array(
                'EXISTS' => false
            );
            SendResponse(1, $userinfo);
        }
    }

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