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
    $depuredMail = mysqli_real_escape_string($dbConnection, $_GET['user']);


    $mail = '"'.$depuredMail.'"';
    $query = 'DELETE FROM session WHERE email = '.$mail;
    
    SendResponse(1, 'logout ok');
    
?>