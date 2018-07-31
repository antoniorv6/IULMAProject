<?php 

include '../dbConnect.php';

header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");

$dbConnection = connectToDB();

//DEPURACION
$depuredmail = mysqli_real_escape_string($dbConnection, $_POST['mail']);
$depuredname = mysqli_real_escape_string($dbConnection, $_POST['username']);
$depuredsurname = mysqli_real_escape_string($dbConnection, $_POST['surname']);
$depuredpass = mysqli_real_escape_string($dbConnection, $_POST['pwd']);
//

$mail = '"'.$depuredmail.'"';
$name = '"'.$depuredname.'"';
$surname = '"'.$depuredsurname.'"';
$pwd = '"'.$depuredpass.'"';

$query = $query = "INSERT INTO editor (email, password, name, surname) VALUES ($mail, $pwd, $name, $surname)";

if(!($result = @mysqli_query($dbConnection, $query))) 
{
	$response = array(
		'RESULT' => 'ERROR',
		'MESSAGE' => 'Ha habido un error realizando su petición',
		'DEBUGMESSAGE' => mysqli_error($dbConnection)
	);
			
	SendResponse(0, $response);
}

$response = array(
    'RESULT' => 'OK',
    'MESSAGE' => 'Usuario registrado correctamente'
);

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