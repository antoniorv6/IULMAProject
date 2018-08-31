<?php
    include '../dbConnect.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

	$dbConnection = connectToDB();
	if(!isset($_GET['search']))
	{
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
	}
	else
	{ 
		$searchWord = mysqli_real_escape_string($dbConnection, $_GET['search']);
		$searchWord = "'".'%'.$searchWord.'%'."'";
		$firstquery = "SELECT article FROM content WHERE textcontent LIKE $searchWord";
		if(!($articles = @mysqli_query($dbConnection, $firstquery))) 
    	{
			$response = array(
				'RESULT' => 'ERROR',
				'MESSAGE' => 'Ha habido un error localizando los ID',
				'SEARCH' => $searchWord,
				'DEBUGMESSAGE' => mysqli_error($dbConnection)
			);
			
			SendResponse(0, $response);
			return false;
		}

		$data=mysqli_fetch_assoc($articles)['article'];
		$howmany = 0;
		$query = "SELECT * FROM `column` WHERE ";
		//En data están todos los id

		if(is_array($data))
		{
			foreach($data as $id)
			{
				echo $id;

				if($howmany == 0)
					$query = $query."ID = $id";
				else 
					$query = $query."OR ID = $id";
				$howmany++;
			}
		}
		else 
			$query = $query."ID = $data";

		if(!($result = @mysqli_query($dbConnection, $query))) 
    	{
			if($data == null)
			{
				$response = array();
				SendResponse(1, $response);
			}
			else
			{
				$response = array(
					'RESULT' => 'ERROR',
					'MESSAGE' => 'Ha habido un error extrayendo artículos',
					'DEBUGMESSAGE' => mysqli_error($dbConnection)
				);
				SendResponse(0, $response);
			}
			return false;
		}

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