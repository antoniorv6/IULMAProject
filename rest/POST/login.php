<?php
    
    include '../dbConnect.php';
    include '../responseSender.php';

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
            $sessioninfo = array(
                'USER' => $depuredMail,
                'DISPOSITIVE' => $_SERVER['REMOTE_ADDR']
            );
            SendResponse(1, $sessioninfo);
        }
        else
        {
            SendResponse(0, 'Error, el usuario o contraseña no son correctos');
        }
    }

?>