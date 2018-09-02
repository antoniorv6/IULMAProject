<?php
	include '../dbConnect.php';
	include '../responseSender.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

	$dbConnection = connectToDB();
	if(isset($_GET['search']))
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

		$howmany = 0;
		$query = "SELECT * FROM `column` WHERE ";
		//En data están todos los id

		while($data = mysqli_fetch_assoc($articles))
		{
			$id = $data['article'];
			if($howmany == 0)
					$query = $query."ID = $id ";
				else 
					$query = $query."OR ID = $id ";
			
			$howmany++;
		}

		if(!($result = @mysqli_query($dbConnection, $query))) 
    	{
			if($howmany == 0)
			{
				$response = $query;
				SendResponse(1, $response);
			}
			else
			{
				$response = array(
					'RESULT' => 'ERROR',
					'MESSAGE' => 'Ha habido un error extrayendo artículos',
					'QUERY' => $query,
					'DEBUGMESSAGE' => mysqli_error($dbConnection)
				);
				SendResponse(0, $response);
			}
			return false;
		}
	}
	else if(isset($_GET['query']))
	{
		$string = urldecode($_GET['query']);
		$query = "SELECT * FROM `column` WHERE ".$string;
		if(!($result = @mysqli_query($dbConnection, $query))) 
		{
			$response = array(
				'RESULT' => 'ERROR',
				'MESSAGE' => 'Ha habido un error realizando su petición',
				'QUERY' => $query,
				'DEBUGMESSAGE' => mysqli_error($dbConnection)
			);
				
			SendResponse(0, $response);
		}
	}
	else
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
    
    $counter = 0;
    $response = array();
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($response,$row);
    }

    SendResponse(1, $response);
?>