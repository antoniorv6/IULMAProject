<?php 

include '../dbConnect.php';
include '../responseSender.php';

header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");

$dbConnection = connectToDB();

switch($_GET['type'])
{
    case 0:
        DeleteUser($dbConnection);
    break;
    case 1:
        DeleteColumn($dbConnection);
    break;
}

function DeleteUser($dbConnection)
{
    $email = '"'.$_GET['id'].'"';
    $query = 'DELETE from editor WHERE email = ' . $email;

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
        'MESSAGE' => 'Corpus eliminado correctamente'
    );

    SendResponse(1, $response);
}

function DeleteColumn($dbConnection)
{
    $query = 'DELETE from `column` WHERE ID = ' . $_GET['id'];

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
        'MESSAGE' => 'Corpus eliminado correctamente'
    );

    SendResponse(1, $response);
}
?>