<?php
	include 'DataParser.php';
	include '../dbConnect.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
	header("Content-Type: application/json");

	$response = null;
	switch($_POST["type"])
	{
		case "1":
			move_uploaded_file($_FILES["archivo"]["tmp_name"], "../../uploaded/".$_FILES["archivo"]["name"]);
			$fileHandler = new DataParser("../../uploaded/".$_FILES["archivo"]["name"]);
			$string = $fileHandler->convertToText();
			//Ya tenemos el string hecho, ahora llamamos a la función para sacar los datos
			ExtractData($fileHandler, $string);
		break;
		case "2":
			InsertDataInDB();
		break;
	}

	function ExtractData($parserObject, $content)
	{
		$type = 0;
		//Ver de que tipo es nuestro archivo

		if($parserObject->type_of_doc() == 1)
		{
			$lines = explode(chr(0x0D),$content); //Extraigo todas las líneas del texto
			$data = explode(',', $lines[1]);

			$arrayResponse = array(
				'SURNAME' => $data[0],
				'NAME' => $data[1],
				'TITLE' => $data[2],
				'SOURCE' => $data[3],
				'PLACE' => $data[4],
				'DATE' => $data[5],
				'PAGE' => $data[6],
				'COLUMN' => $data[7],
				'MEDIUM' => $data[8],
				'LANGUAGE' => $data[9],
				'COUNTRY' => $data[10],
				'PATH' => "uploaded/".$_FILES["archivo"]["name"]
			);
			$type = 1;
		}
		else if($parserObject->type_of_doc() == 2)
		{
			$lines = explode(chr(0x0D),$content); //Extraigo todas las líneas del texto
			$data = explode(',', $lines[0]);
			if(sizeof($lines)>1)
			{
				$position = sizeof($data)-1;
				for($counter = 1 ; $counter < sizeof($lines); $counter++) //Mientras hayan lineas separadas por retorno de carros
				{
					$dataforincluding = explode(",", $lines[$counter]);
					foreach($dataforincluding as $mustinclude)
					{
						$data[$position] = $mustinclude;
						$position++;
					}
				}
			}
			$arrayResponse = array(
				'SURNAME' => $data[0],
				'NAME' => $data[1],
				'TITLE' => $data[2],
				'SOURCE' => $data[3],
				'PLACE' => $data[4],
				'DATE' => $data[5],
				'PAGE' => $data[6],
				'COLUMN' => $data[7],
				'MEDIUM' => $data[8],
				'LANGUAGE' => $data[9],
				'COUNTRY' => $data[10]
			);
			$type = 1;
		}
		else
		{
			$arrayResponse = array(
				'ERROR' => "Error, document extension not supported"
			);
		}
		
		SendResponse($type, $arrayResponse);
	}

	function InsertDataInDB()
	{
		$response = null;
		$dbConnection = connectToDB();
		//Conectados a la base de datos
		//Saneamos las variables que insertamos en la query
		$surname = '"'.$_POST['surname'].'"';
		$name = '"'.$_POST['name'].'"';
		$title = '"'.$_POST['title'].'"';
		$source = '"'.$_POST['source'].'"';
		$place = '"'.$_POST['place'].'"';
		$date = '"'.$_POST['date'].'"';
		$col = '"'.$_POST['column'].'"';
		$medium = '"'.$_POST['medium'].'"';
		$language = '"'.$_POST['language'].'"';
		$country = '"'.$_POST['country'].'"';
		$user = '"'.$_POST['user'].'"';
		$path = '"'.$_POST['filepath'].'"';
		//Fin del saneamiento
		$query = "INSERT INTO `column` (Author_surname, Author_Name, Title, Place, Dateofcreation, Col, Source, Medium, Language_written, Country, First_insert, Last_insert, Filepath) VALUES ($surname, $name, $title, $place, $date, $col, $source, $medium, $language, $country, $user, $user, $path)";
		//Query escrita, ahora escribimos en la base de datos

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
			'MESSAGE' => 'Datos insertados correctamente'
		);

		SendResponse(1, $response);
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