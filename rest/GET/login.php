<?php
    
    include '../dbConnect.php';

    header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
    
    $response = null;
    $dbConnection = connectToDB();
    //Vamos a hacer la consulta para ver si se puede hacer login

    //Depuramos variables
    $depuredMail = mysqli_real_escape_string($dbConnection, $_GET['email']);
    $depuredPass = mysqli_real_escape_string($dbConnection, $_GET['pass']);


    $mail = '"'.$depuredMail.'"';
    $pass = '"'.$depuredPass.'"';
    $query = 'SELECT COUNT(email) AS userExists FROM editor WHERE email = '.$mail.' AND password = '.$pass;

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
            //TODO -> Crear token de sesión y automatizar el proceso de eliminación de tokens cada X horas.
            SendResponse(1, 'Login OK');
        }
        else
        {
            SendResponse(0, 'Error, el usuario o contraseña no son correctos');
        }
    }

    function SendResponse($type, $body)
	{
		switch($type)
		{
			case 0:
				http_response_code(401);
				$response = array('RESPONSE_CODE' => 501, 'RESPONSE_TYPE'=>'UNAUTHORISED');
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