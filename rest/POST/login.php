<?php
    
    include '../dbConnect.php';

    header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
    
    $response = null;
    $dbConnection = connectToDB();
    //Vamos a hacer la consulta para ver si se puede hacer login

    //Depuramos variables
    $depuredMail = mysqli_real_escape_string($dbConnection, $_POST['email']);
    $depuredPass = mysqli_real_escape_string($dbConnection, $_POST['pass']);


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
            $token = GenerateSessionToken($dbConnection, $mail, $pass);
            $sessioninfo = array(
                'USER' => $depuredMail,
                'SESSION_TOKEN' =>  $token,
                'DISPOSITIVE' => $_SERVER['REMOTE_ADDR']
            );
            SendResponse(1, $sessioninfo);
        }
        else
        {
            SendResponse(0, 'Error, el usuario o contraseña no son correctos');
        }
    }

    function GenerateSessionToken($dbConnection, $user, $pass)
    {   
        $today = time();
        $date = "'".date('Y-m-d H:i:s', $today)."'";
        $token = "'".md5( $pass . date('YmdHis', $today))."'";
        $dispositive = "'".$_SERVER['REMOTE_ADDR']."'";
        $token_insertion = "INSERT INTO session (email,dispositive,timeoflogin,token) VALUES ($user, $dispositive, $date, $token)";

        if(!($result = @mysqli_query($dbConnection, $token_insertion))) 
        { 
           $secondQuery = 'SELECT * FROM session WHERE email = ' . $user;
           if(!($secondresult = @mysqli_query($dbConnection, $secondQuery)))
           {
                print json_encode("<p>Error al ejecutar la sentencia <b>$secondQuery</b>: " . mysqli_error($dbConnection));
                exit; 
           }

           $data=mysqli_fetch_assoc($secondresult);

           if($data['dispositive'] == $_SERVER['REMOTE_ADDR'])
           {
               //Mismo dispositivo, renovamos token de sesion
               $updateQuery = 'UPDATE session SET token = '.$token.',timeoflogin='.$date.'WHERE email ='.$user;

               if(!($updateresult = @mysqli_query($dbConnection, $updateQuery)))
               {
                    print json_encode("<p>Error al ejecutar la sentencia <b>$updateQuery</b>: " . mysqli_error($dbConnection));
                    exit;
               }
           }
           else
           {
                SendResponse(0, 'Error, otro dispositivo tiene la sesión iniciada');
           }
        }
        closeDBcon($dbConnection);
        return $token;
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